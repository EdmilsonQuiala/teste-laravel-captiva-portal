# Portal Captivo com Laravel e PF (Firewall macOS)

Este projeto implementa um portal captivo caseiro usando Laravel e o firewall PF nativo do macOS.

## Configuração do Sistema

### 1. Mover o script para o local correto

```bash
sudo cp captive-allow.sh /usr/local/bin/
sudo chmod +x /usr/local/bin/captive-allow.sh
```

### 2. Criar arquivo de IPs permitidos

```bash
sudo touch /etc/pf.captive.allowed
sudo chmod 644 /etc/pf.captive.allowed
```

### 3. Configurar permissões sudo

Edite o arquivo sudoers para permitir que o Laravel execute o script sem senha:

```bash
sudo visudo -f /etc/sudoers.d/captive
```

Adicione a seguinte linha (substitua SEU_USUARIO pelo seu nome de usuário):

```
SEU_USUARIO ALL=(root) NOPASSWD: /usr/local/bin/captive-allow.sh, /sbin/pfctl, /usr/bin/tee
```

### 4. Configurar o PF (Packet Filter)

Edite o arquivo de configuração do PF:

```bash
sudo nano /etc/pf.conf
```

Adicione estas linhas (ajuste conforme necessário):

```
# Tabela de IPs autorizados
table <allowed> persist file "/etc/pf.captive.allowed"

# Interface de rede para Internet Sharing (geralmente bridge100)
wifi_if = "bridge100"

# Regras para o portal captivo
pass in on $wifi_if proto tcp from <allowed> to any
pass in on $wifi_if proto udp from <allowed> to any port 53
block in on $wifi_if from any to any
```

Recarregue as regras do PF:

```bash
sudo pfctl -f /etc/pf.conf
sudo pfctl -e
```

## Executando o Portal

1. Inicie o servidor Laravel:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

2. Ative o Internet Sharing no macOS:
   - Preferências do Sistema > Compartilhamento > Compartilhamento de Internet
   - Compartilhe a conexão da sua fonte de Internet (Ethernet/Wi-Fi) para computadores usando Wi-Fi

## Como Funciona

1. Quando um dispositivo se conecta ao hotspot, ele tenta acessar qualquer site HTTP
2. O navegador é redirecionado para o portal captivo (seu servidor Laravel)
3. O usuário faz login com as credenciais (admin/123456)
4. O Laravel executa o script que adiciona o IP do dispositivo à tabela `allowed` do PF
5. O dispositivo agora tem acesso à Internet

## Credenciais de Acesso

- Usuário: `admin`
- Senha: `123456`

## Logout e Remoção de Acesso

Para remover o acesso de um dispositivo, acesse a rota `/logout` no portal.

## Limpeza Total

Para remover todos os acessos:

```bash
sudo /sbin/pfctl -t allowed -T flush
echo "" | sudo tee /etc/pf.captive.allowed >/dev/null
```