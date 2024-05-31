<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['newStatus']);

    $sql = "UPDATE submissions SET status = '$newStatus' WHERE id = '$userId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>