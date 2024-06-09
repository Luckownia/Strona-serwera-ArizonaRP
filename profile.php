<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArizonaRP</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        #deleteAccountButton {
            background-color: red; /* Kolor tła po najechaniu */
            width: 180px;
            padding: 15px 20px;
            font-size: 18px;
            color: white;
            margin-bottom: 30px;
        }
        #deleteAccountButton:hover{
            background-color: #d30f0f; /* Kolor tła po najechaniu */
        }
        .alert-success{
            text-align:left;
        }
        p {
            margin: 0;
        }
    </style>
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
                        <li><a href="index.php" class="nav-link">Główna</a></li>
                        <li><a href="logout.php" class="nav-link">Wyloguj się</a></li>
                        <li><a href="panel.php" class="nav-link active">Panel</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="headline-profile" class="headline-section">
            <?php
                echo "<h1 class='headline' id='panel_nick'>Nick: {$_SESSION['user_nickname']}</h1>";
                echo "<p class='sub-headline' id='panel_rank'>Ranga: {$_SESSION['user_rank']}</p>";
                echo "<p class='sub-headline' id='panel_email'>Email: {$_SESSION['user_email']}</p>";
            ?>
            <?php
            if (isset($_POST["profile_submit"])) {
                $password = $_POST["new_password"];
                $errors = array();

                // Walidacja hasła
                if (strlen($password) < 8) {
                    array_push($errors, "Hasło musi mieć przynajmniej 8 znaków");
                }

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert-danger'>$error</div>";
                    }
                } else {
                    // Tworzenie połączenia z bazą danych
                    require 'database.php';

                    // Ucieczka wartości zmiennych, aby uniknąć SQL Injection
                    $user = $_SESSION['user_nickname'];
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Zapytanie SQL do zmiany hasła
                    $sql = "UPDATE users SET password = '$hashedPassword' WHERE nickname = '$user'";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='alert-success'>Pomyślnie zmieniono hasło.</p>";
                    } else {
                        echo "<div class='alert-danger'>Coś poszło nie tak przy zmianie hasła: " . $conn->error . "</div>";
                    }

                    // Zamknięcie połączenia
                    $conn->close();
                }
            }
            ?>

            <form action="profile.php" method="post" style="margin-top: 30px;">
                <div class="field">
                    <label>Zmień hasło: </label>
                    <input type="password" name="new_password" required>
                    <input type="submit" value="Zmień" name="profile_submit">
                </div>
            </form>
            
            <button class="btn-join-2" id="deleteAccountButton">Usuń konto</button>
            <a href="panel.php"><button class="btn-join-2" id="btn_back">Wróć</button></a>
        </div>
        <div class="container-car">
            <div class="slideshow-container" style="left: 3%;">

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="public/assets/feature1.jpeg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="public/assets/car.jpg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="public/assets/heist.jpg"></div>
                        </div>
                    </section>
                </div>

                <div class="mySlides fade">
                    <section id="section-1">
                        <div class="section-feature">
                            <div class="feature-photo"><img src="public/assets/bar.jpg"></div>
                        </div>
                    </section>
                </div>

            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script src="script-2.js"></script>
        <script src="slideshow.js"></script>
        <script>
            const nick_profile = document.querySelector("#panel_nick");
            nick_profile.addEventListener("mouseenter", animateCursor);
            nick_profile.addEventListener("mouseleave", removeAnimateCursor);

            const panel_rank = document.querySelector("#panel_rank");
            panel_rank.addEventListener("mouseenter", animateCursor);
            panel_rank.addEventListener("mouseleave", removeAnimateCursor);

            const panel_email = document.querySelector("#panel_email");
            panel_email.addEventListener("mouseenter", animateCursor);
            panel_email.addEventListener("mouseleave", removeAnimateCursor);

            const field = document.querySelector(".field");
            field.addEventListener("mouseenter", animateCursor);
            field.addEventListener("mouseleave", removeAnimateCursor);

            const btn_back = document.querySelector("#btn_back");
            btn_back.addEventListener("mouseenter", animateCursor);
            btn_back.addEventListener("mouseleave", removeAnimateCursor);

            const rank_con = document.querySelector("#rank_con");
            rank_con.addEventListener("mouseenter", animateCursor);
            rank_con.addEventListener("mouseleave", removeAnimateCursor);

            const rank = document.querySelector("#rank");
            rank.addEventListener("mouseenter", animateCursor);
            rank.addEventListener("mouseleave", removeAnimateCursor);

            document.getElementById('deleteAccountButton').addEventListener('click', function () {
                if (confirm('Czy na pewno chcesz usunąć swoje konto?')) {
                    fetch('deleteAccount.php', {
                        method: 'POST'
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Twoje konto zostało pomyślnie usunięte.');
                            window.location.href = 'index.php'; // Przekierowanie na stronę główną
                        } else {
                            alert('Wystąpił błąd podczas usuwania konta: ' + data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        </script>
    </body>
</html>
