<?php
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submissionId = mysqli_real_escape_string($conn, $_POST['submissionId']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['newStatus']);

    $sql = "UPDATE submissions SET status = '$newStatus' WHERE id_submission = '$submissionId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>