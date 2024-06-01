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
    <?php
      $selector = $_GET["selector"];
      $validator = $_GET["validator"];

      if(empty($selector) || empty($validator)){
        echo "Błąd";
      }
      else{
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
            ?>
    <form action="resetPasswordRequest.php" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector ?>">
        <input type="hidden" name="validator" value="<?php echo $validator ?>">
        <div class="field">
            <input type="password" name="pwd" required>
            <label>Nowe hasło</label>
        </div>
        <div class="field">
            <input type="password" name="pwd-repeat" required>
            <label>Powtórz hasło</label>
        </div>
        <div class="content"></div>
        <div class="field">
            <input type="submit" value="Zmień hasło" name="reset-password-submit">
        </div>
    </form>

           <?php
        }
      }
    ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
</body>
</html>
