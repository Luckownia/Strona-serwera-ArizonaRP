<?php
session_start();

require 'database.php'; // Wczytaj połączenie z bazą danych

// Zaktualizuj rangę użytkownika na "Niezdane" i zapisz czas
$_SESSION['user_rank'] = 'Niezdane';
$_SESSION['failed_time'] = date('Y-m-d H:i:s');

$rank = 'Niezdane';
$failed_time = $_SESSION['failed_time'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET rank = ?, failed_time = ? WHERE id = ?");
$stmt->bind_param("ssi", $rank, $failed_time, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Brak odpowiedzi - użycie navigator.sendBeacon
    http_response_code(204);
} else {
    echo "Wystąpił błąd podczas aktualizacji rangi.";
}

$stmt->close();
$conn->close();
exit();
?>
