<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NA Events | Journée UUKHA</title>

    <style>
        body{
            margin:0;
            font-family:Arial, Helvetica, sans-serif;
            background:#f4f7fa;
            color:#222;
        }

        header{
            background:#ffffff;
            padding:20px 50px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .logo{
            font-size:28px;
            font-weight:bold;
            color:#004b87;
        }

        .hero{
            max-width:1100px;
            margin:auto;
            padding:80px 30px;
            text-align:center;
        }

        h1{
            font-size:48px;
            margin-bottom:15px;
            color:#004b87;
        }

        h2{
            color:#c62828;
            margin-bottom:40px;
        }

        .card-container{
            display:flex;
            gap:25px;
            justify-content:center;
            flex-wrap:wrap;
            margin-top:60px;
        }

        .card{
            width:280px;
            background:white;
            border-radius:15px;
            padding:25px;
            box-shadow:0 8px 20px rgba(0,0,0,.08);
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-6px);
        }

        button{
            width:100%;
            margin-top:20px;
            padding:14px;
            border:none;
            border-radius:8px;
            background:#004b87;
            color:white;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#00345f;
        }

        footer{
            margin-top:80px;
            padding:30px;
            text-align:center;
            background:white;
        }

    </style>

</head>
<body>

<header>

    <div class="logo">
        NORMANDIE ARCHERIE
    </div>

    <div>
        Démonstration UUKHA
    </div>

</header>

<section class="hero">

    <h1>Journée de démonstration UUKHA</h1>

    <h2>Samedi 3 octobre 2026</h2>

    <p>

        63 Boulevard Charles de Gaulle<br>

        Actipôle des Chartreux<br>

        76140 Le Petit-Quevilly

    </p>

    <div class="card-container">

        <div class="card">

            <h3>10h00 - 12h00</h3>

            <p>12 places disponibles</p>

            <button>Réserver</button>

        </div>

        <div class="card">

            <h3>13h00 - 15h00</h3>

            <p>12 places disponibles</p>

            <button>Réserver</button>

        </div>

        <div class="card">

            <h3>15h30 - 17h30</h3>

            <p>12 places disponibles</p>

            <button>Réserver</button>

        </div>

    </div>

</section>

<footer>

© 2026 Normandie Archerie

</footer>

</body>
</html>