<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArizonaRP</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans&display=swap"
            rel="stylesheet">
</head>
<body>
        <span class="mouse"></span>
            <div class="landing-page">
                <header>
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
                            <li> <a href="index.php" class="nav-link"> Główna</a> </li>
                            <li> <a href="logout.php" class="nav-link"> Wyloguj się</a> </li>
                            <li> <a href="panel.php" class="nav-link active"> Panel</a> </li>
                        </ul>

                    </div>
                </nav>
                </header>
                <article>
                    <div class="job-container">
                        <section>
                            <a href="requestQuiz.php?job=medic">
                                <div class="job"><div class="job-logo"><img src="public/assets/mediclogo.png"> <h1>medyk</h1> <p>Wciel się w rolę medyka, wykonuj wymagające operacje i pomagaj potrzebującym</p></div><div class="layer-job"></div><img src="public/assets/medic.jpg"></div>
                            </a>
                        </section>
                        <section>
                            <a href="requestQuiz.php?job=police">
                                <div class="job"><div class="job-logo"><img src="public/assets/policelogo.png"> <h1>policjant</h1> <p>Zostań policjantem i przypilnuj, by w mieście panował porządek. </p></div><div class="layer-job"></div><img src="public/assets/police.jpg"></div>
                            </a>
                        </section>
                        <section>
                            <a href="requestQuiz.php?job=mechanic">
                                <div class="job"><div class="job-logo"><img src="public/assets/mechaniclogo.png"> <h1>mechanik</h1> <p>Pracuj jako mechanik, tuninguj fury bogaczom i naprawiaj fury biedakom. </p></div><div class="layer-job"></div><img src="public/assets/mechanic.png"></div>
                            </a>
                        </section>
                    </div>
                </article>
    </div>

 <script src="script-2.js"></script>   
</body>
</html>