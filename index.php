
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandinha</title>
    <style>
        :root {
            --rosa: #ffe6ea;
            --vermelho: #e74c3c;
            --verde: #2ecc71;
            --cinza: #ccc;
            --texto: #333;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            background: linear-gradient(135deg, var(--rosa), #fff);
            min-height: 100vh;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            color: #d6336c;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
            color: #222;
        }
        .agenda {
            max-width: 600px;
            margin: 10px auto;
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
        .linha-compromisso {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #ccc;
            padding: 8px 0;
        }

        .info-compromisso {
            flex: 1;
        }

        .hora-compromisso {
            white-space: nowrap;
            margin-left: 10px;
            font-weight: bold;
            color: #444;
        }
        .casais {
            max-width: 800px;
            margin: 20px auto;
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
            flex: 1 0 100px;
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

<header>
    <h1>Agenda Bandinha <br> RCC 2025</h1>
</header>

<h2>Próximos Compromissos</h2>
<ul class="agenda">
<?php foreach ($ensaios as $e): ?>
    <li class="linha-compromisso">
        <div class="info-compromisso">
            <?= $e['concluido'] ? "✅ " : "" ?>
            <?= date("d/m", strtotime($e['data'])) ?> - <?= $e['descricao'] ?> - <?= $e['local'] ?>
        </div>
        <div class="hora-compromisso">
            🕘<?= substr($e['hora'], 0, 5) ?>
        </div>
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

<?php include 'footer.html'; ?>
</body>
</html>
