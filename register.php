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
                    <li><a href="index.php" class="nav-link">Główna</a></li>
                    <li><a href="#" class="nav-link active">Zaloguj się</a></li>
                    <li> <a href="panel.php" class="nav-link"> Panel</a> </li>
                </ul>
            </div>
        </nav>
</header>
<div class="wrapper">
    <div class="title">Zarejestruj się</div>
    <?php
    if (isset($_POST["submit"])) {
        $nickname = $_POST["nickname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $rank = "rekrut"; //domyślna ranga, dla ludzi którzy jeszcze nie mają whitelist zdanej
        $repeated_password = $_POST["repeated_password"];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();

        if (empty($nickname) || empty($email) || empty($password) || empty($repeated_password)) {
            array_push($errors, "Wszystkie pola są wymagane");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email jest nieprawidłowy");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Hasło musi mieć przynajmniej 8 znaków");
        }
        if ($password !== $repeated_password) {
            array_push($errors, "Hasła nie są takie same");
        }

        // Tworzenie połączenia z bazą danych
        //require_once "database.php"; powinno to działać i nie trzeba by było tego co jest niżej wtedy dawać
        $hostName = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "login_register";
        $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
        //o dotąd co nie, nwm czemu nie chyta z tego pliku drugiego
        if (!$conn) {
            die("Coś poszło nie tak z połączeniem do bazy danych");
        }

        // Sprawdzanie, czy email już istnieje
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Konto z takim adresem już istnieje!");
            }
        } else {
            die("Coś poszło nie tak przy sprawdzaniu emaila");
        }

        // Wyświetlanie błędów lub dodawanie użytkownika do bazy danych
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert-failure'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO users (nickname, email, password, rank) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $nickname, $email, $password_hash, $rank);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert-success'>
                       Pomyślnie zarejestrowano. <a href='login.php'>Zaloguj się</a>
                       
                       </div>";
            } else {
                die("Coś poszło nie tak przy dodawaniu użytkownika");
            }
        }
    }
    ?>
    <form action="register.php" method="post">
        <div class="field">
            <input type="text" name="nickname" required>
            <label>Nickname</label>
        </div>
        <div class="field">
            <input type="text" name="email" required>
            <label>E-mail</label>
        </div>
        <div class="field">
            <input type="password" name="password" required>
            <label>Hasło</label>
        </div>
        <div class="field">
            <input type="password" name="repeated_password" required>
            <label>Powtórz hasło</label>
        </div>
        <div class="content"></div>
        <div class="field">
            <input type="submit" value="Zarejestruj się" name="submit">
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
</body>
</html>
