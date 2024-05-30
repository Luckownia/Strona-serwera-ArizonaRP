<?php
session_start();
require 'database.php'; // Upewnij się, że ten plik zawiera połączenie z bazą danych

// Sprawdź, czy użytkownik jest zalogowany
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    
    // Zaktualizuj rangę użytkownika
    $sql = "UPDATE users SET rank = 'Zdaje' WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        // Aktualizacja powiodła się, zaktualizuj sesję
        $_SESSION['user_rank'] = 'Niezdane';
        // Przekieruj użytkownika na stronę quizu
        header("Location: whitelistQuiz.php");
        exit();
    } else {
        // Błąd aktualizacji rangi
        echo "Błąd aktualizacji rangi: " . mysqli_error($conn);
    }
} else {
    // Użytkownik nie jest zalogowany, przekieruj na stronę logowania
    header("Location: login.php");
    exit();
}
?>
