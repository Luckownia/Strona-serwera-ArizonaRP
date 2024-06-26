<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php?newpwd=firstlogin");
    exit();
}

require '../config/database.php'; // Wczytaj połączenie z bazą danych

// Pobierz czas niezdania z bazy danych, jeśli istnieje
$stmt = $conn->prepare("SELECT failed_time FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($failed_time);
$stmt->fetch();
$stmt->close();

// Sprawdź, czy minął wymagany czas od niezdania
$retry_time = date('Y-m-d H:i:s', strtotime($failed_time . ' +1 minutes')); //testowo 1 min
$current_time = date('Y-m-d H:i:s');
$can_retry = $current_time >= $retry_time;

$conn->close();
?>
<!DOCTYPE html lang="pl">
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArizonaRP</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <span class="mouse"></span>
    <div class="landing-page">
        <header>
            <nav>
                <div class="navbar">
                    <div class="logo">
                        <img src="../assets/palm-tree-48.png" alt="palm-tree" width="48px">
                        <a href="../../index.php" class="logo-link">ArizonaRP</a>
                    </div>
                    <label class="switch-mode-container">
                        <input type="checkbox" class="switch-mode-checkbox">
                        <span class="btn-switch-mode" tabindex="0">
                            <span class="circle">
                                <img src="../assets/sun.png" alt="light-sun" class="circle-image">
                            </span>
                        </span>
                    </label>
                    <button class="hamburger">
                        <span class="pasek1"></span>
                    </button>
                    <ul class="navigation">
                        <li><a href="../../index.php" class="nav-link">Główna</a></li>
                        <li><a href="../models/logout.php" class="nav-link">Wyloguj się</a></li>
                        <li><a href="panel.php" class="nav-link active">Panel</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="headline-panel" class="headline-section">
            <?php
                echo "<h1 class='headline' id='headline_panel'>Witaj {$_SESSION['user_nickname']}, miło cię widzieć ;)</h1>";
                echo '<a href="profile.php"><button class="btn-join-2">Mój Profil</button></a>';
                if ($_SESSION["user_rank"] == "Rekrut") {
                    echo '<a href="../models/updateRankTempWl.php"><button class="btn-join-2">Zdaj na white-list</button></a>';
                } else if ($_SESSION["user_rank"] == "Niezdane") {
                    if ($can_retry) {
                        echo '<a href="../models/updateRankTempWl.php"><button class="btn-join-2">Spróbuj ponownie</button></a>';
                    } else {
                        echo "<button class='btn-join-2' disabled>Spróbuj ponownie $retry_time</button>";
                    }
                    echo '<a href="checkSubmissions.php"><button class="btn-join-2">Sprawdź status podań</button></a>';
                } else if ($_SESSION["user_rank"] == "Oczekuję") {
                    echo "<button class='btn-join-2' disabled>Twoje podanie oczekuje na weryfikację</button>";
                    echo '<a href="checkSubmissions.php"><button class="btn-join-2">Sprawdź status podań</button></a>';
                } else {
                    echo '<a href="https://discord.gg/WYq74GqehK" target="_blank"><button class="btn-join-2">Dołącz na serwer</button></a>';
                }
                if ($_SESSION["user_rank"] == "Administrator") {
                    echo '<a href="manageSubmissions.php"><button class="btn-join-2">Zarządzaj podaniami</button></a>';
                    echo '<a href="manageUsers.php"><button class="btn-join-2">Zarządzaj graczami</button></a>';
                }
                if ($_SESSION["user_rank"] == "Gracz") {
                    echo '<a href="request.php"><button class="btn-join-2">Wyślij podanie</button></a>';
                    echo '<a href="checkSubmissions.php"><button class="btn-join-2">Sprawdź status podań</button></a>';
                }
            ?>
        </div>
        <div class="container-car">
            <div class="slideshow-container" style="left: 3%;">

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="../assets/slide3.jpg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="../assets/slide4.jpg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="../assets/slide5.jpg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="../assets/slide7.jpg"></div>
                        </div>
                    </section>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="../../script/script-2.js"></script>
    <script src="../../script/slideshow.js"></script>
</body>
</html>
