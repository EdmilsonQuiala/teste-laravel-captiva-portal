<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\CaptiveService;

class CaptiveController extends Controller
{
    public function showLogin()
    {
        // Página mínima: HTML inline para o CNA (mini browser do SO)
        return response()->view('captive.login');
    }

    public function authorizeClient(Request $request, CaptiveService $svc)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // TODO: troque por validação real (DB/Users/etc.)
        $ok = $request->input('username') === 'admin' && $request->input('password') === '123456';

        $clientIp = $request->ip(); // ex.: 192.168.2.X
        Log::info('[CAPTIVE] tentativa de login', ['ip' => $clientIp, 'user' => $request->input('username')]);

        if (!$ok) {
            Log::warning('[CAPTIVE] credenciais inválidas', ['ip' => $clientIp]);
            return response('<h3>Credenciais inválidas</h3><a href="/">Tentar novamente</a>', 401);
        }

        $result = $svc->allowIp($clientIp);

        if (!$result['ok']) {
            Log::error('[CAPTIVE] falha ao liberar IP no PF', ['ip' => $clientIp, 'err' => $result['err'], 'out' => $result['out'], 'code' => $result['code']]);
            return response('<h3>Erro ao liberar acesso. Contate o suporte.</h3><pre>'.e($result['err']).'</pre>', 500);
        }

        Log::info('[CAPTIVE] IP liberado com sucesso', ['ip' => $clientIp, 'out' => $result['out']]);

        // Mensagem curta para CNA + link para testar navegação
        return response(
            "<h3>Acesso liberado para {$clientIp}</h3>"."<p>Você já pode navegar. Abra <a href=''>example.com</a> ou <a href=''>neverssl.com</a>.</p>"
        );
    }
    
    public function logout(Request $request)
    {
        $ip = $request->ip();
        
        // Usar o serviço para remover o IP da tabela allowed
        $cmd = '/usr/bin/sudo /sbin/pfctl -t allowed -T delete ' . escapeshellarg($ip) . ' && ' .
               '/usr/bin/sudo /usr/bin/sed -i "" "/^'.preg_quote($ip,'/').'$/d" /etc/pf.captive.allowed';
        
        exec($cmd, $output, $exitCode);
        
        Log::info('[CAPTIVE] Acesso revogado', ['ip' => $ip, 'exit_code' => $exitCode]);
        
        return response(
            "<h3>Acesso revogado para {$ip}</h3><p><a href='/'>Voltar ao login</a></p>"
        );
    }
}