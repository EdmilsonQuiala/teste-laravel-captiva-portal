<?php

namespace App\Http\Controllers;

use App\Models\CaptiveUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com a lista de todos os usuários
     */
    public function index(Request $request)
    {
        // Obtém todos os usuários com paginação
        $users = CaptiveUser::query();
        
        // Aplica filtros se fornecidos
        if ($request->has('search')) {
            $search = $request->search;
            $users->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mac_address', 'like', "%{$search}%")
                      ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('authorized')) {
            $users->where('is_authorized', $request->authorized == 'yes');
        }
        
        // Ordenação
        $sortField = $request->sort ?? 'created_at';
        $sortDirection = $request->direction ?? 'desc';
        $users->orderBy($sortField, $sortDirection);
        
        // Paginação
        $users = $users->paginate(10);
        
        // Estatísticas
        $stats = [
            'total_users' => CaptiveUser::count(),
            'authorized_users' => CaptiveUser::where('is_authorized', true)->count(),
            'unauthorized_users' => CaptiveUser::where('is_authorized', false)->count(),
            'recent_users' => CaptiveUser::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('dashboard.index', compact('users', 'stats'));
    }
}