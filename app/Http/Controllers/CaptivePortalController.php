<?php

namespace App\Http\Controllers;

use App\Models\CaptiveUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaptivePortalController extends Controller
{
    /**
     * Exibe a página de login do portal captivo
     */
    public function showLoginForm(Request $request)
    {
        // Captura o endereço IP e MAC do cliente
        $ipAddress = $request->ip();
        $macAddress = $this->getMacAddress($ipAddress);
        
        return view('captive.login', compact('ipAddress', 'macAddress'));
    }

    /**
     * Processa o registro do usuário e libera o acesso à internet
     */
    public function register(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ip_address' => 'required|string',
            'mac_address' => 'nullable|string',
        ]);

        // Salva os dados do usuário
        $user = CaptiveUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'ip_address' => $validated['ip_address'],
            'mac_address' => $validated['mac_address'],
            'is_authorized' => true,
        ]);

        // Libera o acesso à internet para o dispositivo
        $this->authorizeDevice($validated['ip_address'], $validated['mac_address']);

        // Redireciona para a página de sucesso
        return redirect()->route('captive.success');
    }

    /**
     * Exibe a página de sucesso após o registro
     */
    public function showSuccess()
    {
        return view('captive.success');
    }

    /**
     * Obtém o endereço MAC a partir do endereço IP
     */
    private function getMacAddress($ipAddress)
    {
        // Para fins de demonstração, retornamos um valor simulado
        return 'AA:BB:CC:DD:EE:FF';
    }

    /**
     * Libera o acesso à internet para o dispositivo
     */
    private function authorizeDevice($ipAddress, $macAddress)
    {   
        Log::info("Acesso liberado para IP: {$ipAddress}, MAC: {$macAddress}");
        
        // Para fins de demonstração, apenas registo a ação
        return true;
    }
}