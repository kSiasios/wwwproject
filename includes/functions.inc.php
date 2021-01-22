<?php

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function emptyInputSignup($username, $email, $password, $passwordRepeat)
{
    $result = false;
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUID($username)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat)
{
    $result = false;
    if ($password !== $passwordRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uIDExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE usersUID = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /Project2/pages/signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function isAdmin($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE ((usersUID = ? OR usersEmail = ?) AND usersIsAdmin = 1);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /Project2/pages/signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $password, $admin, $skill, $canRedir, $url)
{
    echo "<p>Inserting user</p>";
    $sql = "INSERT INTO users (usersEmail, usersUID, usersPwd, usersIsAdmin) VALUES (?, ?, ?, ?);";
    $sql2 = "INSERT INTO prousers (proLvl, uID) VALUES (?, ?);";
    $sql3 = "INSERT INTO usersimg (userID, status, url) VALUES (?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /Project2/pages/signup.php?error=stmtfailed");
        exit();
    }

    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("location: /Project2/pages/signup.php?error=stmtfailed");
        exit();
    }

    $stmt3 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt3, $sql3)) {
        header("location: /Project2/pages/signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssi", $email, $username, $hashedPwd, $admin);
    mysqli_stmt_execute($stmt);

    //get users ID
    $sqlReturnUID = "SELECT usersID FROM users WHERE usersEmail LIKE '" . $email . "';";
    if ($result = mysqli_query($conn, $sqlReturnUID)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $uid = $row['usersID'];
            }
            // Free result set
            mysqli_free_result($result);
        } else {
            echo "No records matching your query were found.";
        }
    } else {
        header("location: /Project2/pages/signup.php?error=usernotfound");
        exit();
    }
    // if chechbox checked do following code
    mysqli_stmt_close($stmt);
    //-----------------------------------------------------------------
    //------------Write User to ProUsers DB----------------------------
    if ($skill !== NULL && $skill !== "") {
        mysqli_stmt_bind_param($stmt2, "si", $skill, $uid);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }
    //-----------------------------------------------------------------
    //------------Write User to UsersImg DB----------------------------
    if ($uid !== '') {
        if ($url == '') {
            $imgStat = 0;
        } else {
            $imgStat = 1;
        }
        echo "URL: $url";

        mysqli_stmt_bind_param($stmt3, "iis", $uid, $imgStat, $url);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);
    }

    debug_to_console("Statement closed");
    if ($canRedir == 1) {
        loginUser($conn, $email, $password);
    } else {
        return;
    }
    exit();
}

function deleteUID($conn, $uid, $redir)
{
    $sqlReturnUID = "SELECT * FROM users WHERE usersUID LIKE '" . $uid . "';";
    $id = '';
    if ($result = mysqli_query($conn, $sqlReturnUID)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['usersID'];
            }
            // Free result set
            mysqli_free_result($result);
        } else {
            echo "No records matching your query were found.";
        }
    } else {
        header("location: /Project2/index.php?error=usernotfound");
        exit();
    }

    $sqlDelImg = "SELECT * FROM usersimg WHERE usersimg.userID = " . $id . ";";
    $imgUrl = "";
    if ($result2 = mysqli_query($conn, $sqlDelImg)) {
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $imgUrl = $row2['url'];
                if (!empty($imgUrl)) {
                    //delete image first
                    if (strpos($imgUrl, 'https://') !== true) {
                        //user was manually created and not through api
                        $urlTokens = explode('/', $imgUrl);
                        $trueImgUrl = strtolower(end($urlTokens));
                        unlink("../uploads/" . $trueImgUrl);
                    }
                }
            }
            // Free result set
            mysqli_free_result($result2);
        } else {
            echo "No records matching your query were found.";
        }
    }

    $sql1 = "DELETE FROM prousers WHERE prousers.uID = " . $id . ";";
    $sql2 = "DELETE FROM usersimg WHERE usersimg.userID = " . $id . ";";
    $sql4 = "DELETE FROM comments WHERE comments.uid = " . $id . ";";
    $sql5 = "DELETE FROM userfav WHERE userfav.uid = " . $id . " OR userfav.favuid = " . $id . ";";

    $sql3 = "DELETE FROM users WHERE users.usersID = " . $id . ";";
    echo $sql3;

    $stmt1 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt1, $sql1)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt1failed");
        exit();
    }

    mysqli_stmt_execute($stmt1);

    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt2failed");
        exit();
    }

    mysqli_stmt_execute($stmt2);

    $stmt4 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt4, $sql4)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt4failed");
        exit();
    }

    mysqli_stmt_execute($stmt4);

    $stmt5 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt5, $sql5)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt5failed");
        exit();
    }

    mysqli_stmt_execute($stmt5);

    $stmt3 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt3, $sql3)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt3failed");
        exit();
    }

    mysqli_stmt_execute($stmt3);

    if ($redir !== "") {
        header("Location: " . $redir);
        exit();
    }
    return;
}

function flushDatabase($conn, $user, $spare)
{
    $usersStr = implode(", ", $user);
    $sql = "SELECT usersID FROM users WHERE users.usersID in ($usersStr)";
    echo $sql;

    $sql1 = "DELETE FROM prousers WHERE ";
    $sql2 = "DELETE FROM usersimg WHERE ";
    $sql3 = "DELETE FROM users WHERE ";
    $sql4 = "DELETE FROM comments WHERE ";
    $sql5 = "DELETE FROM userfav WHERE ";
    $sqlDelImg = "SELECT * FROM usersimg WHERE ";
    $i = 0;

    foreach ($user as $id) {
        if ($spare == 1) {
            if ($i != 0) {
                $sql1 .= " AND prousers.uID != $id";
                $sql2 .= " AND usersimg.userID != $id";
                $sql3 .= " AND users.usersID != $id";
                $sql4 .= " AND comments.uID != $id";
                $sql5 .= " AND (userfav.uid != $id OR userfav.favuid = $id)";
                $sqlDelImg .= " AND usersimg.userID != $id";
            } else {
                $sql1 .= "prousers.uID != $id";
                $sql2 .= "usersimg.userID != $id";
                $sql3 .= "users.usersID != $id";
                $sql4 .= "comments.uID != $id";
                $sql5 .= "(userfav.uid != $id OR userfav.favuid != $id)";
                $sqlDelImg .= "usersimg.userID != $id";
                $i++;
            }
        } else if ($spare == 0) {
            if ($i != 0) {
                $sql1 .= " OR prousers.uID = $id";
                $sql2 .= " OR usersimg.userID = $id";
                $sql3 .= " OR users.usersID = $id";
                $sql4 .= " OR comments.uID = $id";
                $sql5 .= " OR userfav.uid = $id OR userfav.favuid = $id";
                $sqlDelImg .= " OR usersimg.userID = $id";
            } else {
                $sql1 .= "prousers.uID = $id";
                $sql2 .= "usersimg.userID = $id";
                $sql3 .= "users.usersID = $id";
                $sql4 .= "comments.uID = $id";
                $sql5 .= "(userfav.uid = $id OR userfav.favuid = $id)";
                $sqlDelImg .= "usersimg.userID != $id";
                $i++;
            }
        }
    }

    $sql1 .= ";";
    $sql2 .= ";";
    $sql3 .= ";";
    $sql4 .= ";";
    $sql5 .= ";";
    $sqlDelImg .= ";";

    $imgUrl = "";
    if ($result2 = mysqli_query($conn, $sqlDelImg)) {
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $imgUrl = $row2['url'];
                if (!empty($imgUrl)) {
                    //delete image first
                    if (strpos($imgUrl, 'https://') !== true) {
                        //user was manually created and not through api
                        $urlTokens = explode('/', $imgUrl);
                        $trueImgUrl = strtolower(end($urlTokens));
                        unlink("../uploads/" . $trueImgUrl);
                    }
                }
            }
            // Free result set
            mysqli_free_result($result2);
        } else {
            echo "No records matching your query were found.";
        }
    }

    $stmt1 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt1, $sql1)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt1failed");
        exit();
    }
    mysqli_stmt_execute($stmt1);

    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt2failed");
        exit();
    }
    mysqli_stmt_execute($stmt2);

    $stmt4 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt4, $sql4)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt2failed");
        exit();
    }
    mysqli_stmt_execute($stmt4);

    $stmt5 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt5, $sql5)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt2failed");
        exit();
    }
    mysqli_stmt_execute($stmt5);

    $stmt3 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt3, $sql3)) {
        header("location: /Project2/pages/admin_panel.php?error=stmt3failed");
        exit();
    }
    mysqli_stmt_execute($stmt3);
}

function randomStr($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function postComment($conn, $uid, $txt)
{
    $sql = "INSERT INTO comments (uid, commentValue) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /Project2/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is", $uid, $txt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    debug_to_console("Statement closed");
    header("location: /Project2/index.php");
    exit();
}

function emptyInputLogin($email, $password)
{
    $result = false;
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $password)
{
    $emailExists = uIDExists($conn, $email, $email);

    $isAdmin = isAdmin($conn, $email, $email);

    if ($emailExists === false) {
        header("location: /Project2/pages/login.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $emailExists["usersPwd"];
    $checkPwd = password_verify($password, $passwordHashed);

    if ($checkPwd === false) {
        header("location: /Project2/pages/login.php?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $emailExists["usersID"];
        $_SESSION["useruid"] = $emailExists["usersUID"];
        $_SESSION["isadmin"] = $isAdmin["usersIsAdmin"];
        $_SESSION["useremail"] = $emailExists["usersEmail"];
        $_SESSION["login_time_stamp"] = time();
        header("location: /Project2/index.php");
        exit();
    }
}

function uploadImage($conn, $file, $url)
{
    if (empty($url)) {
        //a file was given
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
    } else {
        //url was given
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
    }


    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { //5MB
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDest = '/Project2/uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDest);
                // alter img table
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