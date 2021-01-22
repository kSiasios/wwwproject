<?php

include 'dbh.inc.php';
include 'functions.inc.php';

$userToSpare1 = 13; //Admin
$userToSpare2 = 14; //Test User
$userToSpare3 = 466;

$usersToSpare = array($userToSpare1, $userToSpare2, $userToSpare3);

$spare = 1; //wont be deleted

flushDatabase($conn, $usersToSpare, $spare);