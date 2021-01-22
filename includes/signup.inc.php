<?php

if (isset($_POST["submit"])) {

    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];
    $isPro = $_POST["isPro"];
    $skill = "";

    if ($isPro == 'isPro') {
        $skill = $_POST["skill"];
    }

    $isAdmin = 0;
    $canRedir = 1;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($skill !== 'Amateur' && $skill !== 'Intermediate' && $skill !== 'Pro' && $skill !== 'Master' && $isPro == 'isPro') {
        header("location: /Project2/pages/signup.php?error=emptyskill");
        exit();
    }

    if (emptyInputSignup($username, $email, $password, $passwordRepeat) !== false) {
        header("location: /Project2/pages/signup.php?error=emptyinput");
        exit();
    }
    if (invalidUID($username) !== false) {
        header("location: /Project2/pages/signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: /Project2/pages/signup.php?error=invalidemail");
        exit();
    }
    if (passwordMatch($password, $passwordRepeat)) {
        header("location: /Project2/pages/signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uIDExists($conn, $username, $email) !== false) {
        header("location: /Project2/pages/signup.php?error=usernametaken");
        exit();
    }

    $url = '';

    createUser($conn, $username, $email, $password, $isAdmin, $skill, $canRedir, $url);

    exit;
} else {
    header("location: /Project2/pages/signup.php");
    exit();
}