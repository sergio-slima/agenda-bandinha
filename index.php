
<?php
require 'config.php';

// Pega os ensaios
$ensaios = $pdo->query("SELECT * FROM ensaios ORDER BY data ASC")->fetchAll();

// Pega os casais
$casais = $pdo->query("SELECT * FROM casais ORDER BY nome")->fetchAll();

// Pega todas as presenças
$presencasQuery = $pdo->query("SELECT * FROM presencas WHERE presente = 1");
$presencas = [];
foreach ($presencasQuery as $p) {
    $presencas[$p['casal_id']][$p['ensaio_id']] = true;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agenda da Bandinha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f2f4;
            margin: 0;
            padding: 0 15px 80px;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
            color: #222;
        }
        .agenda {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 10px #ccc;
        }
        .agenda li {
            list-style: none;
            padding: 8px 0;
            border-bottom: 1px dashed #ccc;
        }
        .agenda li:last-child {
            border-bottom: none;
        }
        .casais {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 10px #ccc;
        }
        .casais div {
            display: flex;
            align-items: center;
            padding: 5px 0;
            flex-wrap: wrap;
        }
        .casais .nome {
            flex: 1 0 200px;
        }
        .pontinhos {
            display: flex;
            gap: 5px;
            flex-wrap: nowrap;
        }
        .pontinho {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            border-radius: 50%;
            background: #ccc;
        }
        .presente {
            background: #22c55e;
        }
        .falta {
            background: #ef4444;
        }
        footer {
            background: #222;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Próximos Compromissos</h2>
<ul class="agenda">
<?php foreach ($ensaios as $e): ?>
    <li>
        <?= $e['concluido'] ? "✅ " : "" ?>
        <?= date("d/m", strtotime($e['data'])) ?> - <?= $e['descricao'] ?> – <?= substr($e['hora'], 0, 5) ?>
    </li>
<?php endforeach; ?>
</ul>

<h2>Presenças dos Casais</h2>
<div class="casais">
<?php foreach ($casais as $casal): ?>
    <div>
        <div class="nome"><?= $casal['nome'] ?></div>
        <div class="pontinhos">
            <?php foreach ($ensaios as $e):
                $idEnsaio = $e['id'];
                $concluido = $e['concluido'];
                $presente = $presencas[$casal['id']][$idEnsaio] ?? false;

                $classe = '';
                if ($concluido && $presente) {
                    $classe = 'presente';
                } elseif ($concluido && !$presente) {
                    $classe = 'falta';
                }
            ?>
                <div class="pontinho <?= $classe ?>"></div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<footer>
  <nav class="footer-links">
    <a href="https://www.instagram.com/rcc_acailandia_/" target="_blank">📷 Instagram</a>
    <a href="https://sergio-slima.github.io/page-links/" target="_blank">💻 Desenvolvido por DEVAPP</a>
    <a href="login.php">🔐 Área Administrativa</a>
  </nav>
</footer>

</body>
</html>
