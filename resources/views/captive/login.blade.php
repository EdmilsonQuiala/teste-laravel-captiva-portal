<!doctype html>
<html lang="pt-br"><meta charset="utf-8">
<title>Portal de Acesso</title>
<body style="font-family:system-ui;max-width:420px;margin:40px auto">
  <h3>Portal de Acesso</h3>
  <form method="POST" action="/authorize">
    @csrf
    <input name="username" placeholder="Usuário" style="width:100%;padding:10px;margin:6px 0">
    <input type="password" name="password" placeholder="Senha" style="width:100%;padding:10px;margin:6px 0">
    <button style="padding:10px 16px">Entrar</button>
    <p style="color:#666">Após autenticar, o seu dispositivo terá acesso à Internet.</p>
  </form>
</body>
</html>