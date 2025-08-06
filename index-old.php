<?php
/*
|--------------------------------------------------------------------------
| CONFIGURAÇÃO DA AGENDA
|--------------------------------------------------------------------------
| Cada mês contém um array de eventos.  Basta alterar / acrescentar linhas
| que tudo aparece automaticamente na página.
*/
$agenda = [
    'Junho' => [
        ['data' => '28/06', 'hora' => '16h', 'descricao' => 'Ensaio – Casa Dani & Deia'],
        ['data' => '29/06', 'hora' => '12h', 'descricao' => 'Almoço RCC'],
    ],
    'Julho' => [
        ['data' => '19/07', 'hora' => '18h', 'descricao' => 'Ensaio / Reunião – IASD Milagres'],
    ],
    'Agosto' => [
        ['data' => '16/08', 'hora' => '16h', 'descricao' => 'Ensaio – Central Laranjeiras'],
        ['data' => '23/08', 'hora' => '18h', 'descricao' => 'Ensaio / Reunião – Laranjeiras'],
    ],
    'Setembro' => [
        ['data' => '06/09', 'hora' => '16h', 'descricao' => 'Ensaio – Central Laranjeiras'],
        ['data' => '13/09', 'hora' => '18h', 'descricao' => 'Ensaio / Reunião – Central Bonnaire'],
    ],
    'Outubro' => [
        ['data' => '04/10', 'hora' => '18h', 'descricao' => 'Ensaio / Reunião – Central Laranjeiras'],
        ['data' => '12/10', 'hora' => '14h', 'descricao' => 'Ensaio – Central Bonnaire'],
        ['data' => '16/10', 'hora' => '19h', 'descricao' => 'Ensaio / Culto – Central Bonnaire'],
        ['data' => '17–19/10', 'hora' => '19h', 'descricao' => 'RCC 2025 – Escola IEMA'],
    ],
];
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
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
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
        /* 1) links lado a lado */
        footer{
            background:#fafafa;
            padding:1rem;
        }
        .footer-links{
            display:flex;
            justify-content:center;
            gap:2rem;
            flex-wrap:wrap;          /* quebra em telas pequenas */
        }
        .footer-links a{
            color:var(--texto);
            text-decoration:none;
            font-weight:500;
            transition:.2s;
        }
        .footer-links a:hover{color:var(--rosa-escuro);}

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
    <h1>Agenda Bandinha RCC - 2025</h1>
</header>

<!-- <main>
<?php foreach ($agenda as $mes => $eventos): ?>
    <section class="mes">
        <h2><?= htmlspecialchars($mes) ?></h2>
        <?php foreach ($eventos as $ev): ?>
            <div class="evento">
                <div class="data-hora">
                    <span><?= htmlspecialchars($ev['data']) ?></span>
                    <span class="relogio"></span>
                    <span><?= htmlspecialchars(strtoupper($ev['hora'])) ?></span>
                </div>
                <div class="descricao"><?= htmlspecialchars($ev['descricao']) ?></div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>
</main>       -->

  <section class="agenda">
    <h2>Próximos Compromissos</h2>
    <ul>
      <li>28/06 - Ensaio Casa Dani & Deia – 16h ✅</li>
      <li>29/06 - Almoço RCC – 12h ✅</li>
      <li>19/07 - Ensaio / Reunião IASD Milagres – 16h</li>
      <li>16/08 - Ensaio Central Laranjeiras – 16h</li>
      <li>23/08 - Ensaio / Reunião Laranjeiras – 18h</li>
      <li>06/09 - Ensaio Central Laranjeiras – 16h</li>
      <li>13/09 - Ensaio / Reunião Central Bonnaire – 18h</li>
      <li>04/10 - Ensaio / Reunião Central Laranjeiras – 18h</li>
      <li>12/10 - Ensaio Central Bonnaire – 14h</li>
      <li>16/10 - Ensaio / Culto Central Bonnaire – 19h</li>
    </ul>
  </section>

  <table>
    <thead>
      <tr>
        <th>Casal</th>
        <th>Presenças</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $casais = [
        ['Ananda e Sérgio',        [1, 1]],
        ['Karine e Ulisses',       [1, 1]],
        ['Raquel e William',       [1, 1]],
        ['Jaine e Elton',          [1, 0]],
        ['Marisa e Willis',        [1, 1]],
        ['Waleria e Alex',         [1, 1]],
        ['Taty e Joatan',          [1, 1]],
        ['Adriellen e Raphael',    [1, 1]],
        ['Cynthia e John Lenon',   [0, 1]],
        ['Andreia e Daniel *',     [1, 1]],
        ['Pâmela e Heber',         [1, 1]],
        ['Jordânia Nay*',          [0, 0]],
        ['Diana e Marcos*',        [1, 0]],
        ['Ramona e Almires',       [1, 1]],
        ['Leciane e Rivenildo',    [1, 1]],
        ['Weslianny e Thiago',     [0, 1]],
      ];

      foreach ($casais as $casal) {
        echo "<tr><td>{$casal[0]}</td><td><div class='bolinhas'>";
        for ($i = 0; $i < 10; $i++) {
          if ($i === 0)
            $classe = $casal[1][0] ? 'verde' : 'vermelha';
          elseif ($i === 1)
            $classe = $casal[1][1] ? 'verde' : 'vermelha';
          else
            $classe = '';
          echo "<div class='bolinha $classe'></div>";
        }
        echo "</div></td></tr>";
      }
      ?>
    </tbody>
  </table>

<footer>
<nav class="footer-links">
    <a href="https://instagram.com/acai.bandinha" target="_blank">📷 Instagram</a>
    <a href="login.php">🔐 Área Administrativa</a>
    <a href="#">💻 Desenvolvido por Vagner</a>
</nav>
</footer>

</body>
</html>
