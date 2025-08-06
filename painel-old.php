
<?php
require 'config.php';

if (!isset($_SESSION['bandinha_user'])) {
    header("Location: login.php");
    exit;
}

// Marcar ensaio como concluído
if (isset($_GET['concluir'])) {
    $id = intval($_GET['concluir']);
    $pdo->prepare("UPDATE ensaios SET concluido = 1 WHERE id = ?")->execute([$id]);
}

// Marcar presença do casal
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

<h1>Painel Administrativo</h1>
<a href="logout.php">Sair</a>
<hr>

<h2>Ensaios</h2>
<ul>
<?php foreach ($ensaios as $ensaio): ?>
    <li>
        <?= date("d/m", strtotime($ensaio['data'])) ?> - <?= $ensaio['descricao'] ?> às <?= substr($ensaio['hora'], 0, 5) ?>
        <?= $ensaio['concluido'] ? "✅" : "<a href='?concluir={$ensaio['id']}'>[Marcar como concluído]</a>" ?>

        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="ensaio_id" value="<?= $ensaio['id'] ?>">
            <strong>Presenças:</strong><br>
            <?php foreach ($casais as $casal): ?>
                <label>
                    <input type="checkbox" name="presente[]" value="<?= $casal['id'] ?>"
                    <?php
                        $stmt = $pdo->prepare("SELECT 1 FROM presencas WHERE ensaio_id = ? AND casal_id = ? AND presente = 1");
                        $stmt->execute([$ensaio['id'], $casal['id']]);
                        if ($stmt->fetch()) echo "checked";
                    ?>>
                    <?= $casal['nome'] ?>
                </label><br>
            <?php endforeach; ?>
            <button type="submit" name="presenca">Salvar Presenças</button>
        </form>
        <hr>
    </li>
<?php endforeach; ?>
</ul>
