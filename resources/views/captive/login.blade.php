<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Wi-Fi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .captive-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .form-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .form-control {
            padding: 12px;
            margin-bottom: 15px;
        }
        .form-text {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="captive-container">
            <div class="logo-container">
                <h1>Wi-Fi Grátis</h1>
            </div>
            
            <h2 class="form-title">Conecte-se à Internet</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('captive.register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Seu nome" required>
                </div>
                
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail" required>
                </div>
                
                <input type="hidden" name="ip_address" value="{{ $ipAddress }}">
                <input type="hidden" name="mac_address" value="{{ $macAddress }}">
                
                <button type="submit" class="btn btn-primary">Conectar</button>
                
                <div class="form-text">
                    Ao clicar em "Conectar", você concorda com nossos Termos de Uso e Política de Privacidade.
                </div>
            </form>
        </div>
    </div>
</body>
</html>