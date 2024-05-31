<?php
session_start();

// Google reCAPTCHA API keys settings 
$secretKey = '6Ldusu0pAAAAALXxpdJJJBbgiVPU9DH7uFO5esZX';
$siteKey = '6Ldusu0pAAAAAFf_YspCyionhvfoBPJikgjz0-_Y';

// Jeśli formularz został przesłany
$postData = $statusMsg = '';
$status = 'error';
if(isset($_POST['login'])){ 
    $postData = $_POST;

    // Validate reCAPTCHA checkbox 
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
        // Verify the reCAPTCHA API response 
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
        // Decode JSON data of API response 
        $responseData = json_decode($verifyResponse); 
        // If the reCAPTCHA API response is valid 
        if($responseData->success){ 
            // Retrieve value from the form input fields 
            $email = !empty($_POST['email'])?$_POST['email']:'';
            $password = !empty($_POST['password'])?$_POST['password']:'';

            // Your login validation logic here
            $sql = "SELECT * FROM users WHERE email = '$email'";
            require 'database.php';
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = "yes";
                    $_SESSION['user_id'] = $user['id']; // Załóżmy, że użytkownik ma identyfikator 'id' w tabeli użytkowników
                    $_SESSION['user_nickname'] = $user['nickname'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_rank'] = $user['rank'];
                    header("Location: panel.php");
                    die();
                } else {
                    $statusMsg = 'Nieprawidłowe hasło';
                }
            } else {
                $statusMsg = 'Użytkownik z takim e-mailem nie istnieje';
            }
        } else { 
            $statusMsg = 'Weryfikacja CAPTCHA nie powiodła się, spróbuj ponownie.'; 
        } 
    } else { 
        // Show CAPTCHA verification error message only if form is submitted
        if (isset($_POST['login'])) {
            $statusMsg = 'Proszę potwierdzić, że nie jesteś robotem.'; 
        }
    }
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
            <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
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
