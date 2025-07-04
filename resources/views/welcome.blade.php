<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Gestão de treinamentos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />

    <style>
        /* Reset e base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0052D4, #4364F7, #6FB1FC);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(0, 0, 0, 0.25);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        header img.logo {
            height: 40px;
            width: auto;
            margin-right: 15px;
            border-radius: 5px;
            background: #fff;
            padding: 3px;
        }

        header h1 {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
        }

        .content {
            max-width: 600px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            backdrop-filter: blur(10px);
        }

        .content h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .content p {
            font-size: 1.25rem;
            line-height: 1.6;
            color: #e0e0e0;
        }

        /* Responsividade */
        @media (max-width: 480px) {
            header h1 {
                font-size: 1.2rem;
            }
            .content {
                padding: 30px 20px;
            }
            .content h2 {
                font-size: 2rem;
            }
            .content p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<header>
    <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa" class="logo" />
    <h1>Gestão de treinamentos</h1>
</header>

<main>
    <div class="content">
        <h2>Estamos quase lá!</h2>
        <p>
            Nosso sistema de gestão de treinamentos está em fase final de desenvolvimento.<br />
            Prepare-se para uma experiência inovadora que vai transformar a forma como você gerencia capacitações.<br /><br />
            Fique atento! Grandes novidades estão a caminho.
        </p>
    </div>
</main>

</body>
</html>
