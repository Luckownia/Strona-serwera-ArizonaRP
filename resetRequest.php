<?php
session_start();

require 'database.php';

if(isset($_POST["submit"])){
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token);
    
    $expires = date("U") + 1800;
    $userEmail = $_POST["email"];

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

    $to = $userEmail;
    $subject = 'Zresetuj hasło dla Arizona';

    $message = '<p> Wysłano mail </p>';
    $message .= '<p>Link: </br>';
    $message .= '<a href ="' . $url . '">' . $url . '</a></p>';

    $headers = "Z: ArizonaRP <arizonarp@gmail.com>\r\n";
    $headers .= "Odpowiedz dla: arizonarp@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    //mail($to, $subject, $message, $headers);
    echo "$message";
    header("resetPassword.php?reset=success");
}
else{
    header("login.php");
}
?>
