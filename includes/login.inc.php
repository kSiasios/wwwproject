<?php

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $password) !== false) {
        header("location: /Project2/pages/login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $email, $password);
    exit();
} else {
    header("location: /Project2/pages/login.php");
    exit();
}