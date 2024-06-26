<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

require '../config/database.php';

if(isset($_POST["submit"])){
    $userEmail = $_POST["email"];

    // Sprawdzenie, czy email istnieje w bazie danych
    $sql = "SELECT email FROM users WHERE email=?"; // Zastąp 'users' nazwą swojej tabeli użytkowników
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Błąd";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCount = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($resultCount == 0) {
            header("Location: ../views/resetPassword.php?reset=notfound");
            exit();
        }
    }

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost/projekty/Strona-serwera-ArizonaRP/public/views/createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token); //do zmiany potem
    
    $expires = date("U") + 1800;

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "blad";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "blad";
        exit();
    }else{
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    } 

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // PHPMAILER
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'arizonaroleplaycompany@gmail.com';
    $mail->Password = 'rrbzgfpmpmngkhvt';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('arizonaroleplaycompany@gmail.com');
    $mail->addAddress($userEmail);

    $mail->isHTML(true);

    $mail->Subject = 'Zresetuj haslo dla Arizona';
    $mail->Body = "Oto twój link do resetowania hasła: <a href='$url'>$url</a>";

    try {
        $mail->send();
        echo '<script>
                alert("Sent Successfully");
                document.location.href="../views/resetPassword.php";
            </script>';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    /*
    $message = '<p> Wysłano mail </p>';
    $message .= '<p>Link: </br>';
    $message .= '<a href ="' . $url . '">' . $url . '</a></p>';

    $headers = "Z: ArizonaRP <arizonarp@gmail.com>\r\n"; //
    $headers .= "Odpowiedz dla: arizonarp@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers); //potem do odkomentowania
    echo "$message";
    */
    header("Location: ../views/resetPassword.php?reset=success"); //to trzeba potem odkomentowac,
    //teraz jest po to zeby wiadomosc widziec
}
else{
    header("../views/login.php");
}
?>
