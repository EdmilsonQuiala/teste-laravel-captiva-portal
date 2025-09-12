<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portal Wi-Fi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .dashboard-container {
            padding: 30px;
        }
        .stats-card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 30px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container container-fluid">
        <div class="header-container">
            <h1 class="mb-4">Dashboard de Usuários</h1>
            <a href="{{ route('captive.login') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar ao Portal</a>
        </div>
        
        <!-- Cards de Estatísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Usuários</h5>
                        <h2>{{ $stats['total_users'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Usuários Autorizados</h5>
                        <h2>{{ $stats['authorized_users'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Usuários Não Autorizados</h5>
                        <h2>{{ $stats['unauthorized_users'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Novos (7 dias)</h5>
                        <h2>{{ $stats['recent_users'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filtros e Pesquisa -->
        <div class="table-container">
            <form action="{{ route('dashboard') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome, email, IP ou MAC" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="authorized" class="form-select">
                        <option value="">Status de Autorização</option>
                        <option value="yes" {{ request('authorized') == 'yes' ? 'selected' : '' }}>Autorizados</option>
                        <option value="no" {{ request('authorized') == 'no' ? 'selected' : '' }}>Não Autorizados</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Limpar</a>
                    </div>
                </div>
            </form>
            
            <!-- Tabela de Usuários -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <a href="{{ route('dashboard', array_merge(request()->except(['sort', 'direction']), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    ID
                                    @if(request('sort') == 'id')
                                        <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('dashboard', array_merge(request()->except(['sort', 'direction']), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    Nome
                                    @if(request('sort') == 'name')
                                        <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('dashboard', array_merge(request()->except(['sort', 'direction']), ['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    Email
                                    @if(request('sort') == 'email')
                                        <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Endereço MAC</th>
                            <th>Endereço IP</th>
                            <th>Status</th>
                            <th>
                                <a href="{{ route('dashboard', array_merge(request()->except(['sort', 'direction']), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    Data de Registro
                                    @if(request('sort') == 'created_at' || !request('sort'))
                                        <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mac_address ?? 'N/A' }}</td>
                                <td>{{ $user->ip_address ?? 'N/A' }}</td>
                                <td>
                                    @if($user->is_authorized)
                                        <span class="badge bg-success">Autorizado</span>
                                    @else
                                        <span class="badge bg-danger">Não Autorizado</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Nenhum usuário encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>