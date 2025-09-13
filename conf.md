# Configuração do Portal Captivo Laravel + PF (macOS)

Este documento contém as instruções para configurar o Portal Captivo Laravel com o firewall PF no macOS.

## 1. Configuração do Script de Liberação

### 1.1 Instalar o script captive-allow.sh

```bash
# Copiar o script para o local correto
sudo cp captive-allow.sh /usr/local/bin/

# Dar permissão de execução
sudo chmod +x /usr/local/bin/captive-allow.sh

# Criar arquivo de IPs permitidos (se não existir)
sudo touch /etc/pf.captive.allowed
sudo chmod 644 /etc/pf.captive.allowed
```

### 1.2 Configurar o sudoers

Crie um arquivo sudoers específico para o portal captivo:

```bash
sudo visudo -f /etc/sudoers.d/captive
```

Adicione o seguinte conteúdo (substitua SEU_USUARIO pelo seu nome de usuário):

```
SEU_USUARIO ALL=(root) NOPASSWD: /usr/local/bin/captive-allow.sh, /sbin/pfctl, /usr/bin/tee
```

> **Importante**: Se você estiver usando o `php artisan serve`, o usuário será o seu usuário de login. Se estiver usando Apache/Nginx, pode ser `www-data`, `_www`, etc.

## 2. Verificação das Regras PF

Verifique se as regras do PF estão configuradas corretamente:

```bash
# Verificar se a tabela <allowed> existe
sudo pfctl -a captive -sr | grep allowed

# Verificar se a regra de redirecionamento está correta
sudo pfctl -a captive -sn

# Verificar se a interface está correta (deve ser bridge100, não bridge0)
cat /etc/pf.anchors/captive | grep bridge
```

As regras devem incluir:

```
table <allowed> persist file "/etc/pf.captive.allowed"
rdr pass on $lan_if inet proto tcp from $lan_net to any port = 80 -> 127.0.0.1 port $portal_port
pass quick on $wan_if from <allowed> to any keep state
```

## 3. Executando o Portal Captivo

```bash
# Iniciar o servidor Laravel na interface 0.0.0.0 (todas as interfaces)
php artisan serve --host=0.0.0.0 --port=8000
```

## 4. Testando o Portal Captivo

1. Em um dispositivo conectado à rede Wi-Fi compartilhada:
   - Tente acessar `https://google.com` (deve falhar)
   - Acesse `http://neverssl.com` (deve redirecionar para o portal)

2. Faça login com:
   - Usuário: `admin`
   - Senha: `123456`

3. Verifique se o IP foi adicionado à tabela allowed:
   ```bash
   sudo pfctl -t allowed -T show
   ```

4. Teste a navegação no dispositivo (deve funcionar agora)

5. Para revogar o acesso, acesse `/logout` no portal

## 5. Solução de Problemas

### 5.1 "sudo: no tty present and no askpass program specified"

- Verifique se o arquivo sudoers está configurado corretamente com NOPASSWD
- Verifique se o usuário está correto

### 5.2 Tabela <allowed> não existe

- Verifique se a linha `table <allowed> persist file "/etc/pf.captive.allowed"` está presente no arquivo `/etc/pf.anchors/captive`
- Recarregue as regras com `sudo pfctl -f /etc/pf.conf`

### 5.3 Laravel não consegue executar o script

- Verifique se `proc_open/exec` não estão desabilitados no php.ini
- Teste manualmente: `sudo /usr/local/bin/captive-allow.sh 192.168.2.50`

### 5.4 Redirecionamento não ocorre

- Certifique-se que `lan_if = "bridge100"` (não bridge0)
- Verifique se o cliente recebeu IP na faixa 192.168.2.x