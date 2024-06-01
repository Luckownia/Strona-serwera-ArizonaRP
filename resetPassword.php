<!DOCTYPE html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArizonaRP</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <style>
        .resetSuccess{
            text-align: center;
            color: green;
            font: var(--fontfirst);
            font-weight: 700;
            font-size: 17px;
        }
        .resetFailed{
            text-align: center;
            color: red;
            font: var(--fontfirst);
            font-weight: 700;
            font-size: 17px;
        }
    </style>
</head>
<body>
<span class="mouse"></span>
<header>
    <div class="landing-page">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="public/assets/palm-tree-48.png" alt="palm-tree" width="48px">
                    <a href="index.php" class="logo-link">ArizonaRP</a>
                </div>
                <label class="switch-mode-container">
                    <input type="checkbox" class="switch-mode-checkbox">
                    <span class="btn-switch-mode" tabindex="0">
                        <span class="circle">
                            <img src="public/assets/sun.png" alt="light-sun" class="circle-image">
                        </span>
                    </span>
                </label>
                <button class="hamburger">
                    <span class="pasek1"></span>
                </button>
                <ul class="navigation">
                    <li><a href="index.php" class="nav-link">Główna</a></li>
                    <li><a href="#" class="nav-link active">Zaloguj się</a></li>
                    <li> <a href="panel.php" class="nav-link"> Panel</a> </li>
                </ul>
            </div>
        </nav>
</header>
<div class="wrapper">
    <div class="title">Zapomniałem hasła</div>
    <form action="resetRequest.php" method="post">
    <?php 
      if (isset($_GET["reset"])){
        if ($_GET["reset"] == "success"){
            echo '<p class="resetSuccess"> Sprawdź maila </p>';
        }
        if ($_GET["reset"] == "notfound"){
            echo '<p class="resetFailed"> Nie znaleziono maila </p>';
        }
      }
    ?>
        <div class="field">
            <input type="text" name="email" required>
            <label>E-mail</label>
        </div>
        <div class="content"></div>
        <div class="field">
            <input type="submit" value="Przypomnij hasło" name="submit">
        </div>
    </form>
 
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
</body>
</html>
