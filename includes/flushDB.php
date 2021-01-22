<?php

include 'dbh.inc.php';
include 'functions.inc.php';

//example
$userToSpare1 = 1;
$userToSpare2 = 2;
$userToSpare3 = 3;

$usersToSpare = array($userToSpare1, $userToSpare2, $userToSpare3);

$spare = 1; //wont be deleted

flushDatabase($conn, $usersToSpare, $spare);