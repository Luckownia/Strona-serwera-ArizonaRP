<?php
session_start();

// Google reCAPTCHA API keys settings 
$secretKey = '6Ldusu0pAAAAALXxpdJJJBbgiVPU9DH7uFO5esZX';
$siteKey = '6Ldusu0pAAAAAFf_YspCyionhvfoBPJikgjz0-_Y';

// Sprawdzenie, czy użytkownik jest już zalogowany
if(isset($_SESSION["user"])) {
    header("Location: panel.php");
    exit;
}

// Jeśli formularz został przesłany
$postData = $statusMsg = '';
$status = 'error';

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
// Sprawdzenie czy dane logowania są poprawne
if(isset($_POST['login'])) {
    // Validate login credentials
    $email = !empty($_POST['email']) ? $_POST['email'] : '';
    $password = !empty($_POST['password']) ? $_POST['password'] : '';

    // Sprawdzenie, czy reCAPTCHA jest wymagana
    if(isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 2) {
        if(empty($_POST['g-recaptcha-response'])) {
            $statusMsg = 'Proszę potwierdzić, że nie jesteś robotem.';
            $showRecaptcha = true; // Ustawienie flagi, aby wyświetlić reCAPTCHA
        }
    }

    // Jeśli reCAPTCHA nie jest wymagana lub została zweryfikowana
    if(!isset($showRecaptcha)) {
        // Your login validation logic here
        $sql = "SELECT * FROM users WHERE email = '$email'";
        require 'database.php';
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = "yes";
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nickname'] = $user['nickname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_rank'] = $user['rank'];
                // Reset login attempts on successful login
                $_SESSION['login_attempts'] = 0;
                header("Location: panel.php");
                exit;
            } else {
                // Increment login attempts
                $_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;
                $statusMsg = 'Nieprawidłowe hasło';
            }
        } else {
            $statusMsg = 'Użytkownik z takim e-mailem nie istnieje';
            $_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;
        }
    }
}

// Wyświetlanie reCAPTCHA tylko w przypadku nieprawidłowych danych logowania
if($_SESSION['login_attempts'] >= 2 ) {
    // Wyświetl reCAPTCHA
    $showRecaptcha = true;
} else {
    // Nie wyświetlaj reCAPTCHA
    $showRecaptcha = false;
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">    
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <style>
        .wrapper form {
        padding: 10px 30px 50px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
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
                        <li><a href="index.php" class="nav-link"> Główna</a></li>
                        <li><a href="#" class="nav-link active"> Zaloguj się</a></li>
                        <li><a href="panel.php" class="nav-link"> Panel</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <div class="wrapper">
        <div class="title">
            Zaloguj się
        </div>
        <?php if(!empty($statusMsg)){ ?>
            <p class="alert-danger <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
        <?php } ?>
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
            <?php if ($showRecaptcha) { ?>
                <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
            <?php } ?>
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

