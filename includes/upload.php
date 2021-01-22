<?php
session_start();
include 'dbh.inc.php';
$id = $_SESSION['userid'];

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];


    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { //5MB
                $fileNameNew = "profile" . $id . "." . $fileActualExt;
                $fileDest = '../uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDest);
                // alter img table => usersimg.url = $fileDest
                $sql = 'UPDATE usersimg SET status = 1, url = "/Project2/uploads/' . $fileNameNew . '" WHERE userID = ' . $id . ';';
                $result = mysqli_query($conn, $sql);
                header("Location: /Project2/pages/profile.php?successfulupload");
            } else {
                echo "Your file is too big";
            }
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo "You cannot upload files of this type.";
    }
}