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
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Agenda de Encontros de Casais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts para um toque mais suave -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --rosa:#ffccd5;
            --rosa-escuro:#ff9aa7;
            --cinza:#f4f4f4;
            --texto:#333;
        }
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

            body::before {
            content: "❤️ ❤️ ❤️ ❤️ ❤️ ❤️ ❤️ ❤️ ❤️ ❤️";
            position: fixed;
            top: -100px;
            left: 0;
            width: 100%;
            font-size: 2rem;
            color: rgba(255, 160, 180, 0.1);
            white-space: nowrap;
            animation: flutuar 60s linear infinite;
            z-index: 0;
            }

            @keyframes flutuar {
            0%   { transform: translateY(0); }
            100% { transform: translateY(2000px); }
            }

            h1 {
            text-align: center;
            font-size: 2rem;
            color: #d6336c;
            position: relative;
            z-index: 1;
            }

            h2, h3 {
            text-align: center;
            color: #d6336c;
            position: relative;
            z-index: 1;
            }

            h3 {
                margin-bottom: 1.5rem;
            }

            .agenda {
            max-width: 600px;
            margin: 0 auto 2rem;
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            }

            .agenda h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--texto);
            }

            .agenda ul {
            list-style: none;
            padding-left: 0;
            }

            .agenda li {
            padding: .5rem 0;
            border-bottom: 1px dashed #eee;
            font-size: 1rem;
            }

            table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            }

            th, td {
            padding: 0.7rem;
            text-align: left;
            border-bottom: 1px solid #eee;
            }

            th {
            background: var(--rosa);
            }

            .bolinhas {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            }

            .bolinha {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--cinza);
            }

            .verde { background: var(--verde); }
            .vermelha { background: var(--vermelho); }

            @media (max-width: 600px) {
                .bolinhas {
                    justify-content: flex-start;
                }
                .agenda li {
                    font-size: 0.75rem;
                }
            }        
        *{box-sizing:border-box;margin:0;padding:0;font-family:'Poppins',sans-serif;}
        body{
            background:linear-gradient(135deg,var(--rosa) 0%, var(--cinza) 100%);
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }
        header{
            text-align:center;
            padding:2rem 1rem 1rem;
            color:var(--texto);
        }
        header h1{font-size:clamp(1.8rem, 4vw, 3rem); font-weight:700;}
        header p{font-size:1.1rem; margin-top:.5rem;}

        /* Coração decorativo */
        header::after{
            content:"❤️";
            display:block;
            font-size:2rem;
            margin:0 auto;
            animation:pulsar 2.5s ease-in-out infinite;
        }
        @keyframes pulsar{0%,100%{transform:scale(1);}50%{transform:scale(1.3);} }

        main{
            flex:1;
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:1.5rem;
            padding:1rem 2vw 2rem;
        }
        .mes{
            background:#fff;
            width:290px;
            border-radius:15px;
            box-shadow:0 4px 10px rgba(0,0,0,.08);
            overflow:hidden;
            display:flex;
            flex-direction:column;
        }
        .mes h2{
            background:var(--rosa-escuro);
            color:#fff;
            text-align:center;
            padding:.6rem;
            font-size:1.2rem;
            letter-spacing:.5px;
        }
        .evento{
            padding:1rem 1.2rem;
            border-bottom:1px dashed #eaeaea;
        }
        .evento:last-child{border-bottom:none;}
        .data-hora{
            font-weight:700;
            display:flex;
            align-items:center;
            gap:.5rem;
            margin-bottom:.3rem;
        }
        .relogio{
            width:18px;height:18px;display:inline-block;
            background:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="%23000" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>') center/contain no-repeat;
        }
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

        /* 2) corações no fundo, suavemente animados */
        body::before{
            content:"";
            position:fixed;
            inset:0;
            z-index:-1;
            background:
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox=\"0 0 32 29\"><path fill=\"%23ff9aa7\" d=\"M23.6 0c-3.2 0-6 2.3-7.6 5.6C14.4 2.3 11.6 0 8.4 0 3.8 0 0 3.8 0 8.4c0 9 16 20.4 16 20.4S32 17.4 32 8.4C32 3.8 28.2 0 23.6 0z\"/></svg>') repeat;
            background-size:80px;
            animation:flutuar 25s linear infinite;
            opacity:.07;
        }
        @keyframes flutuar{
            0%  {transform:translateY(0);}
            100%{transform:translateY(-800px);}
        }

    </style>
</head>
<body>

<header>
    <h1>Agenda Bandinha</h1>
    <h2>RCC - 2025</h2>
    <h3>Açailândia</h3>
</header>

  <section class="agenda">
    <h2>Próximos Compromissos</h2>
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
    </section>

    <footer>
      <nav class="footer-links">
        <a href="https://instagram.com/acai.bandinha" target="_blank">📷 Instagram</a>
        <a href="#">💻 Desenvolvido por DevApp</a>
        <a href="login.php">🔐 Área Administrativa</a>
      </nav>
    </footer>

</body>
</html>
