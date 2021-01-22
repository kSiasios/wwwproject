<?php

session_start();
session_unset();
session_destroy();

header("location: /Project2/index.php");
exit();