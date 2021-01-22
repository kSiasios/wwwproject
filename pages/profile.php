<?php
session_start();
?>

<?php
$title = "My Profile - Konstantinos Siasios";
$style = "/Project2/css/profile.css";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 1;
include_once '../header.php';
if (!isset($_SESSION['userid'])) {
    header('Location: /Project2/index.php');
}
include_once '../navbar.php';
?>

<script>
function deleteU(userToDelete) {
    // alert("Hey");
    var obj = {
        table: []
    };

    obj.table.push({
        uid: userToDelete
    });

    var json = JSON.stringify(obj);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "/Project2/includes/deleteUser.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(json);
    window.location = '/Project2/index.php';
    // alert("Database Flushed Successfully");
    // console.log("Clicked!");
}
</script>

<div class="container">
    <table style="border-spacing: 0 20px; border-collapse: separate;">
        <div class="row">
            <div class="profile-content col-12">
                <?php

                include '../includes/dbh.inc.php';
                if (isset($_SESSION['userid'])) {
                    $sql1 = "SELECT * FROM users WHERE users.usersID = " . $_SESSION['userid'];

                    $result = mysqli_query($conn, $sql1);
                    // echo '<div class="row">';
                    $imgUrl = "";
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            $sql2 = "SELECT * FROM usersimg WHERE usersimg.userID = " . $row['usersID'] . ";";

                            $result2 = mysqli_query($conn, $sql2);

                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $imgUrl = $row2['url'];
                                    $status = $row2['status'];
                                    if ($status == 0) {
                                        //no image uploaded
                                        //set image to default image
                                        $imgUrl = '/Project2/uploads/blank.png';
                                    } else {
                                        if ($imgUrl == "") {
                                            $imgUrl = '/Project2/uploads/profile' . $_SESSION['userid'];
                                        }
                                    }
                                }
                            }
                        }
                        echo       '<tr><td align="center"><img class="card-img-top" style="border-radius: 5px; width: 360px;" 
                            src="' . $imgUrl . '"></td></tr>';
                    } else {
                        echo "No users yet!";
                    }
                    // echo '</div>';
                }

                // <!-- <i class="fas fa-user" style="font-size:200px"></i> -->

                if (isset($_SESSION['userid'])) {
                    echo '<tr><td style="text-align: center;"><p class="profile-name" style="font-size:50px">' . $_SESSION['useruid'] . '</p></td></tr>';
                }
                ?>
                <tr>
                    <td style="text-align: center;">
                        <form action='/Project2/includes/upload.php' method='POST' enctype='multipart/form-data'
                            style="display: block;">
                            <!-- <label class="browse"> -->
                            <input type='file' name='file' />
                            <!-- </label> -->

                            <button class='btn btn-primary' type='submit' name='submit'>Upload<i class="fas fa-upload"
                                    style="margin-left: 10px;"></i></button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="/Project2/pages/favourites.php<?php echo "?id=" . $_SESSION['userid']; ?>"
                            class="fav-link" style="font-size:30px;">MyFavourites</a>
                    </td>
                </tr>
            </div>
        </div>
        <div class="row">
            <div class="btn-container col-12">
                <?php
                if (isset($_SESSION['userid'])) {
                    echo '<tr><td style="text-align: center;"><button class="btn btn-danger" style="margin-bottom: 20px;" onclick="deleteU(\'' . $_SESSION['useruid'] . '\')">Delete
                Account<i class="fas fa-trash-alt" style="margin-left: 10px;"></i></button></td></tr>';
                }
                ?>
            </div>
        </div>
    </table>
</div>

<?php
include_once '../footer.php';
?>