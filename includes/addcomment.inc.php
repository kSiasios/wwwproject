<?php
session_start();
?>

<?php

if (isset($_POST["submit"])) {
    if (isset($_SESSION["useruid"])) {
        $uid = $_SESSION["userid"];
        if (isset($_POST["user-comment"])) {
            $txt = $_POST["user-comment"];
            $filteredtext = htmlspecialchars($txt);
            require_once 'dbh.inc.php';
            require_once 'functions.inc.php';

            if (empty($filteredtext)) {
                header("location: /Project2/index.php?error=nocommentinserted");
                exit();
            }

            postComment($conn, $uid, $filteredtext);

            exit();
        } else {
            header("location: /Project2/index.php?error=needtologin");
        }
    } else {
        header("location: /Project2/index.php?error=needtologin");
    }
} else {
    header("location: /Project2/index.php?error=needtologin");
    exit();
}