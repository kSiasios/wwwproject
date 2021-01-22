<?php

include 'dbh.inc.php';
include 'functions.inc.php';

$requestPayload = file_get_contents("php://input");

$data = json_decode($requestPayload);
foreach ($data->table as $newUser) {

    $randomUsername = $newUser->un;
    $randomEmail = $newUser->em;
    // $randomImg = $newUser->im;
    $randomPwd = randomStr(10); // random password with 10 chars
    $randomIsAdmin = 0;
    $randomSkill = "";
    $random = rand(0, 4); //4 levels of pro
    $canRedir = 0;
    switch ($random) {
        case 1:
            $randomSkill = "Amateur";
            break;
        case 2:
            $randomSkill = "Intermediate";
            break;
        case 3:
            $randomSkill = "Pro";
            break;
        case 4:
            $randomSkill = "Master";
            break;
        default:
            $randomSkill = "";
    }

    $url = $newUser->img;

    createUser($conn, $randomUsername, $randomEmail, $randomPwd, $randomIsAdmin, $randomSkill, $canRedir, $url);
    // }
}

var_dump($data);