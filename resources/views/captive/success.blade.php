<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conexão Bem-sucedida</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #198754, #20c997);
      font-family: 'Arial', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .success-box {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      text-align: center;
      max-width: 480px;
      width: 100%;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .success-icon {
      font-size: 70px;
      color: #198754;
      margin-bottom: 20px;
    }
    .success-title {
      font-weight: 600;
      color: #198754;
      margin-bottom: 15px;
    }
    .success-message {
      font-size: 16px;
      color: #333;
      margin-bottom: 25px;
    }
    .btn-continue {
      background-color: #198754;
      border: none;
      padding: 12px 28px;
      font-size: 16px;
      border-radius: 8px;
      font-weight: 500;
      width: 100%;
    }
    .btn-continue:hover {
      background-color: #157347;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <div class="success-icon">✓</div>
    <h2 class="success-title">Conexão Bem-sucedida!</h2>
    <p class="success-message">Você já está conectado à internet. Boa navegação!</p>
    <a href="https://www.google.com" class="btn btn-continue">Começar a Navegar</a>
  </div>

  <script>
    // Redireciona automaticamente após 2s para seu site
    setTimeout(() => {
      window.location.href = 'http://quialacorps.com';
    }, 2000);
  </script>
</body>
</html>
