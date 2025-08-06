
<?php
require 'config.php';

// Consulta os ensaios
$stmt = $pdo->query("SELECT * FROM ensaios ORDER BY data");
$ensaios = $stmt->fetchAll();

// Consulta os casais
$stmtCasais = $pdo->query("SELECT * FROM casais ORDER BY nome");
$casais = $stmtCasais->fetchAll();

// Consulta presenças
$presencas = [];
$stmtPresencas = $pdo->query("SELECT * FROM presencas WHERE presente = 1");
foreach ($stmtPresencas as $p) {
    $presencas[$p['ensaio_id']][] = $p['casal_id'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agenda da Bandinha</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .ensaio { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .casal { display: inline-block; margin: 5px; padding: 5px 10px; border-radius: 5px; background: #ccc; }
        .presente { background: #6f6 !important; }
        footer {
            margin-top: 40px;
            padding: 20px;
            background: #222;
            color: #fff;
            text-align: center;
        }
        .footer-links a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1>📅 Agenda da Bandinha</h1>

    <?php foreach ($ensaios as $ensaio): ?>
        <div class="ensaio">
            <strong><?= date("d/m/Y", strtotime($ensaio['data'])) ?> - <?= $ensaio['descricao'] ?> às <?= substr($ensaio['hora'], 0, 5) ?></strong>
            <?= $ensaio['concluido'] ? " ✅" : "" ?>
            <div>
                <?php foreach ($casais as $casal): 
                    $presente = in_array($casal['id'], $presencas[$ensaio['id']] ?? []);
                ?>
                    <div class="casal <?= $presente ? 'presente' : '' ?>">
                        <?= $casal['nome'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <footer>
      <nav class="footer-links">
        <a href="https://instagram.com/acai.bandinha" target="_blank">📷 Instagram</a>
        <a href="login.php">🔐 Área Administrativa</a>
        <a href="#">💻 Desenvolvido por Vagner</a>
      </nav>
    </footer>

</body>
</html>