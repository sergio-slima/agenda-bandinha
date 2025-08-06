<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['usuario'] ?? '';
    $s = $_POST['senha']   ?? '';

    $stmt = $pdo->prepare("SELECT id, senha FROM bandinha_usuarios WHERE usuario=?");
    $stmt->execute([$u]);
    $user = $stmt->fetch();

    if ($user && password_verify($s, $user['senha'])) {
        $_SESSION['bandinha_user'] = $user['id'];
        header('Location: painel.php');
        exit;
    }
    $erro = "Usuário ou senha inválidos.";
}
?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><title>Login ADM</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{display:flex;justify-content:center;align-items:center;min-height:100vh;font-family:sans-serif;background:#ffccd5;}
form{background:#fff;padding:2rem 2.5rem;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1);min-width:280px}
h2{text-align:center;margin-bottom:1rem}
input{width:100%;padding:.7rem;margin:.4rem 0;border:1px solid #ccc;border-radius:8px}
button{width:100%;padding:.7rem;margin-top:.8rem;border:none;border-radius:8px;background:#ff9aa7;color:#fff;font-weight:600;cursor:pointer}
.error{color:#d00;text-align:center;margin-top:.5rem;font-size:.9rem}
</style></head><body>
<form method="post">
    <h2>Acesso Administrativo</h2>
    <input type="text"  name="usuario" placeholder="Usuário" required>
    <input type="password" name="senha"   placeholder="Senha" required>
    <button type="submit">Entrar</button>
    <?php if(!empty($erro)) echo "<div class='error'>$erro</div>"; ?>
</form>
</body></html>
