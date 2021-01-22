<?php

include 'dbh.inc.php';
include 'functions.inc.php';
session_start();
$requestPayload = file_get_contents("php://input");
// echo "Hey from PHP";
$data = json_decode($requestPayload);
foreach ($data->table as $user) {
    $uid = $user->uid;

    if (isset($_SESSION['userid'])) {

        $sql = "INSERT INTO userfav (uid, favuid) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /Project2/index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userid'], $uid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
exit();