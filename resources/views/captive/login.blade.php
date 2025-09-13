<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal de Acesso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #0dcaf0);
      font-family: 'Arial', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 400px;
    }
    .login-box h3 {
      color: #0d6efd;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
    }
    .form-control {
      padding: 12px;
      font-size: 16px;
    }
    .btn-login {
      background: #0d6efd;
      border: none;
      padding: 12px;
      font-size: 16px;
      font-weight: 500;
      width: 100%;
      border-radius: 8px;
    }
    .btn-login:hover {
      background: #0b5ed7;
    }
    .info-text {
      font-size: 14px;
      color: #6c757d;
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h3>Portal de Acesso</h3>
    <form method="POST" action="/authorize">
      @csrf
      <div class="mb-3">
        <input type="text" class="form-control" name="username" placeholder="Usuário">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" name="password" placeholder="Senha">
      </div>
      <button type="submit" class="btn btn-login">Entrar</button>
    </form>
    <p class="info-text">Após autenticar, seu dispositivo terá acesso à internet.</p>
  </div>
</body>
</html>
