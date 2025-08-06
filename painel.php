
<?php
require 'config.php';

if (!isset($_SESSION['bandinha_user'])) {
    header("Location: login.php");
    exit;
}

// CRUD Ensaio
if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar_ensaio') {
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $local = $_POST['local'];
    $pdo->prepare("INSERT INTO ensaios (descricao, data, hora, local) VALUES (?, ?, ?, ?)")
        ->execute([$descricao, $data, $hora, $local]);
}

if (isset($_POST['acao']) && $_POST['acao'] === 'editar_ensaio') {
    $id = $_POST['id'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $local = $_POST['local'];
    $pdo->prepare("UPDATE ensaios SET descricao=?, data=?, hora=?, local=? WHERE id=?")
        ->execute([$descricao, $data, $hora, $local, $id]);
}

if (isset($_GET['excluir_ensaio'])) {
    $pdo->prepare("DELETE FROM ensaios WHERE id=?")->execute([$_GET['excluir_ensaio']]);
}

if (isset($_GET['concluir'])) {
    $pdo->prepare("UPDATE ensaios SET concluido=1 WHERE id=?")->execute([$_GET['concluir']]);
}

// CRUD Casal
if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar_casal') {
    $nome = $_POST['nome'];
    $pdo->prepare("INSERT INTO casais (nome) VALUES (?)")->execute([$nome]);
}

if (isset($_POST['acao']) && $_POST['acao'] === 'editar_casal') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $pdo->prepare("UPDATE casais SET nome=? WHERE id=?")->execute([$nome, $id]);
}

if (isset($_GET['excluir_casal'])) {
    $pdo->prepare("DELETE FROM casais WHERE id=?")->execute([$_GET['excluir_casal']]);
}

// Marcar presenças
if (isset($_POST['presenca'])) {
    $ensaio_id = $_POST['ensaio_id'];
    $presencas = $_POST['presente'] ?? [];
    $pdo->prepare("DELETE FROM presencas WHERE ensaio_id = ?")->execute([$ensaio_id]);
    foreach ($presencas as $casal_id) {
        $pdo->prepare("INSERT INTO presencas (ensaio_id, casal_id, presente) VALUES (?, ?, 1)")
            ->execute([$ensaio_id, $casal_id]);
    }
}

$ensaios = $pdo->query("SELECT * FROM ensaios ORDER BY data DESC")->fetchAll();
$casais = $pdo->query("SELECT * FROM casais ORDER BY nome")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1, h2 { color: #444; }
        form { margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 5px; }
        input, button, select {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .box { background: #fff; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .ensaio-box { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        .casal { display: inline-block; padding: 5px 10px; margin: 3px; border-radius: 4px; background: #ccc; }
        .presente { background: #6f6; }
        a.btn { padding: 6px 10px; background: #2d89ef; color: white; text-decoration: none; border-radius: 4px; }
        a.btn-danger { background: #c00; }
        a.btn-success { background: #090; }
        @media (max-width: 768px) {
            body { padding: 10px; }
            input, button, select { width: 100%; margin-bottom: 10px; }
        }
    </style>
</head>
<body>

<h1>Painel Administrativo</h1>
<a href="logout.php" class="btn btn-danger">Sair</a>

<h2>➕ Novo Ensaio</h2>
<form method="POST">
    <input type="hidden" name="acao" value="cadastrar_ensaio">
    <input type="text" name="descricao" placeholder="Descrição" required>
    <input type="date" name="data" required>
    <input type="time" name="hora" required>
    <input type="text" name="local" placeholder="Local" required>
    <button type="submit">Cadastrar</button>
</form>

<h2>➕ Novo Casal</h2>
<form method="POST">
    <input type="hidden" name="acao" value="cadastrar_casal">
    <input type="text" name="nome" placeholder="Nome do casal" required>
    <button type="submit">Cadastrar</button>
</form>

<h2>📅 Ensaios</h2>
<?php foreach ($ensaios as $ensaio): ?>
    <div class="box">
        <strong><?= date("d/m/Y", strtotime($ensaio['data'])) ?> - <?= $ensaio['descricao'] ?> às <?= substr($ensaio['hora'], 0, 5) ?> (<?= $ensaio['local'] ?>)</strong>
        <?= $ensaio['concluido'] ? "✅" : "<a class='btn btn-success' href='?concluir={$ensaio['id']}'>Concluir</a>" ?>
        <a href="?excluir_ensaio=<?= $ensaio['id'] ?>" class="btn btn-danger" onclick="return confirm('Excluir este ensaio?')">Excluir</a>
        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="acao" value="editar_ensaio">
            <input type="hidden" name="id" value="<?= $ensaio['id'] ?>">
            <input type="text" name="descricao" value="<?= $ensaio['descricao'] ?>" required>
            <input type="date" name="data" value="<?= $ensaio['data'] ?>" required>
            <input type="time" name="hora" value="<?= $ensaio['hora'] ?>" required>
            <input type="text" name="local" value="<?= $ensaio['local'] ?>" required>
            <button type="submit">Editar</button>
        </form>
        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="ensaio_id" value="<?= $ensaio['id'] ?>">
            <strong>Presenças:</strong><br>
            <?php foreach ($casais as $casal):
                $stmt = $pdo->prepare("SELECT 1 FROM presencas WHERE ensaio_id = ? AND casal_id = ? AND presente = 1");
                $stmt->execute([$ensaio['id'], $casal['id']]);
                $checked = $stmt->fetch() ? "checked" : "";
            ?>
                <label class="casal <?= $checked ? 'presente' : '' ?>">
                    <input type="checkbox" name="presente[]" value="<?= $casal['id'] ?>" <?= $checked ?>>
                    <?= $casal['nome'] ?>
                </label>
            <?php endforeach; ?>
            <br><button type="submit" name="presenca">Salvar Presenças</button>
        </form>
    </div>
<?php endforeach; ?>

<h2>👫 Casais</h2>
<?php foreach ($casais as $casal): ?>
    <div class="box">
        <?= $casal['nome'] ?>
        <a href="?excluir_casal=<?= $casal['id'] ?>" class="btn btn-danger" onclick="return confirm('Excluir casal?')">Excluir</a>
        <form method="POST">
            <input type="hidden" name="acao" value="editar_casal">
            <input type="hidden" name="id" value="<?= $casal['id'] ?>">
            <input type="text" name="nome" value="<?= $casal['nome'] ?>" required>
            <button type="submit">Editar</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>
