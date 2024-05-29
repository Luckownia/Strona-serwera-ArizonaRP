<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $newRank = mysqli_real_escape_string($conn, $_POST['newRank']);

    $sql = "UPDATE users SET rank = '$newRank' WHERE id = '$userId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>