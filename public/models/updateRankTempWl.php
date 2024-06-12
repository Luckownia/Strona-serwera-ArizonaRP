<?php
session_start();
require '../config/database.php'; // Upewnij się, że ten plik zawiera połączenie z bazą danych

// Sprawdź, czy użytkownik jest zalogowany
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $_SESSION['failed_time'] = date('Y-m-d H:i:s'); // Przypisanie daty do zmiennej sesji

    // Zaktualizuj rangę użytkownika i czas niezdania w bazie danych
    $sql1 = "UPDATE users SET rank = 'Niezdane' WHERE id = '$user_id'";
    $sql2 = "UPDATE users SET failed_time = '{$_SESSION['failed_time']}' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        // Aktualizacja powiodła się, zaktualizuj sesję
        $_SESSION['user_rank'] = 'Niezdane';
        // Przekieruj użytkownika na stronę quizu
        header("Location: ../views/whitelistQuiz.php");
        exit();
    } else {
        // Błąd aktualizacji rangi
        echo "Błąd aktualizacji rangi: " . mysqli_error($conn);
    }
} else {
    // Użytkownik nie jest zalogowany, przekieruj na stronę logowania
    header("Location: ../views/login.php");
    exit();
}
?>