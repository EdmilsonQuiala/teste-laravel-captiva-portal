<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexão Bem-sucedida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .success-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .success-title {
            color: #28a745;
            margin-bottom: 15px;
        }
        .success-message {
            margin-bottom: 30px;
            color: #333;
        }
        .btn-continue {
            background-color: #28a745;
            border-color: #28a745;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
        }
        .btn-continue:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-container">
            <div class="success-icon">✓</div>
            <h2 class="success-title">Conexão Bem-sucedida!</h2>
            <p class="success-message">Você está conectado à internet. Aproveite sua navegação!</p>
            <a href="https://www.google.com" class="btn btn-continue">Começar a Navegar</a>
        </div>
    </div>

     <script>
    setTimeout(() => {
        window.location.href = 'http://neverssl.com';
    }, 500);
    </script>
</body>
</html>