<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: panel.php");
}
?>
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
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <span class="mouse"></span>
        <header>
            <div class="landing-page">
                <nav>
                    <div class="navbar">
                        <div class="logo">
                            <img src="public/assets/palm-tree-48.png" alt="palm-tree" width="48px">
                            <a href="#" class="logo-link">ArizonaRP</a>
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
                            <li> <a href="#" class="nav-link active"> Zaloguj się</a> </li>
                            <li> <a href="panel.php" class="nav-link"> Panel</a> </li>
                        </ul>

                    </div>
                </nav>
        </header>
                <div class="wrapper">
                    <div class="title">
                        Zaloguj się
                    </div>
                    <?php
                    if (isset($_POST["login"])) {
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $sql = "SELECT * FROM users WHERE email = '$email'";
                        $hostName = "localhost";
                        $dbUser = "root";
                        $dbPassword = "";
                        $dbName = "login_register";
                        $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
                        $result = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        if ($user) {
                            if (password_verify($password, $user["password"])) {
                                session_start();
                                $_SESSION["user"] = "yes";
                                $_SESSION['user_id'] = $user['id']; // Załóżmy, że użytkownik ma identyfikator 'id' w tabeli użytkowników
                                $_SESSION['user_nickname'] = $user['nickname'];
                                $_SESSION['user_email'] = $user['email'];
                                $_SESSION['user_rank'] = $user['rank'];
                                header("Location: panel.php");
                                die();
                            }else{
                                echo "<div class='alert-danger'>Dane się nie zgadzają</div>";
                            }
                        }else{
                            echo "<div class='alert-danger'>Dane się nie zgadzają</div>";
                        }
                    }
                    ?>
                    <form action="login.php" method="post">
                        <div class="field">
                            <input type="text" required name="email">
                            <label>E-mail</label>
                        </div>
                        <div class="field">
                            <input type="password" required name="password">
                            <label>Hasło</label>
                        </div>
                        <div class="content">
                            <div class="pass-link">
                                <a href="#">Zapomniałeś hasła?</a>
                            </div>
                        </div>
                        <div class="field">
                            <input type="submit" value="Zaloguj" name="login">
                        </div>
                        <div class="signup-link">
                            Nie masz konta? <a href="register.php">Zarejestruj się</a>
                        </div>
                    </form>
                </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="script-2.js"></script>

    </body>

    </html>