<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class CaptiveService
{
    public function allowIp(string $ip): array
    {
        $script = '/usr/local/bin/captive-allow.sh';
        $sudo   = '/usr/bin/sudo';

        // Importante: caminhos absolutos e sem shell parsing
        $process = new Process([$sudo, $script, $ip]);
        $process->setTimeout(5); // segundos

        try {
            $process->run();
        } catch (\Throwable $e) {
            return ['ok' => false, 'code' => 1, 'out' => '', 'err' => $e->getMessage()];
        }

        $ok = $process->isSuccessful();
        return [
            'ok'   => $ok,
            'code' => $process->getExitCode(),
            'out'  => $process->getOutput(),
            'err'  => $process->getErrorOutput(),
        ];
    }
}