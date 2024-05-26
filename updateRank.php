<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Sprawdź, czy dane zostały przesłane za pomocą metody POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy wszystkie wymagane pola zostały przesłane
    if (isset($_POST["userId"]) && isset($_POST["newRank"])) {
        // Pobierz identyfikator użytkownika i nową rangę
        $userId = $_POST["userId"];
        $newRank = $_POST["newRank"];

        // Tutaj należy zaimplementować kod aktualizujący rangę użytkownika w bazie danych
        // Przykładowe zapytanie do bazy danych (zakładając, że korzystasz z MySQLi):
        // $sql = "UPDATE users SET rank = '$newRank' WHERE id = $userId";
        // Po wykonaniu zapytania możesz przekierować użytkownika na stronę panelu lub gdziekolwiek indziej
        // header("Location: panel.php");
        // exit();
    } else {
        // Jeśli brakuje któregoś z pól, przekieruj użytkownika na stronę panelu
        header("Location: manageUsers.php");
        exit();
    }
} else {
    // Jeśli dane nie zostały przesłane za pomocą metody POST, przekieruj użytkownika na stronę panelu
    header("Location: manageUsers.php");
    exit();
}
?>