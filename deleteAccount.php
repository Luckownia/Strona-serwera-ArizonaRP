<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require 'database.php';

$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    session_destroy(); // Zakończenie sesji użytkownika
    echo "success";
} else {
    echo "error: " . $stmt->error;
}
?>
