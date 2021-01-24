<?php

include 'dbh.inc.php';
// include 'functions.inc.php';
session_start();
// echo "Hey from PHP ";
$requestPayload = file_get_contents("php://input");
// echo "Hey from PHP";
$data = json_decode($requestPayload);
foreach ($data->table as $com) {
    $id = $com->id;
    $sql = "DELETE FROM comments WHERE comments.id = " . $id . ";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /Project2/index.php?error=stmt4failed");
        exit();
    }
    // mysqli_stmt_bind_param($stmt1, "i", $id);
    mysqli_stmt_execute($stmt);
}

// header("Location: /Project2/index.php?deletedCommentSuccessfully");
// echo "<script>location='/Project2/index.php?deletedCommentSuccessfully'</script>";
exit();