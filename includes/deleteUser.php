<?php

include 'dbh.inc.php';
include 'functions.inc.php';
session_start();
$requestPayload = file_get_contents("php://input");
$data = json_decode($requestPayload);
foreach ($data->table as $user) {
    $uid = $user->uid;
    $redir = "";

    if (isset($_SESSION['useruid'])) {
        if ($uid === $_SESSION['useruid']) {
            echo "Deleting self";
            $redir = "/Project2/index.php";
            session_start();
            session_unset();
            session_destroy();
        }
    }
    deleteUID($conn, $uid, $redir);
}