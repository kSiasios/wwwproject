<?php
session_start();
include 'dbh.inc.php';

$sql1 = "SELECT * FROM users ORDER BY users.usersID DESC";

$myObj = new \stdClass();

$result = mysqli_query($conn, $sql1);
echo '<div class="row">';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $sql2 = "SELECT * FROM usersimg WHERE usersimg.userID = " . $row['usersID'] . ";";

        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $sql3 = "SELECT * FROM prousers WHERE prousers.uID = " . $row2['userID'] . ";";

                $result3 = mysqli_query($conn, $sql3);

                if (mysqli_num_rows($result3) > 0) {
                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        if ($row2['userID'] == $row3['uID']) {
                            echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card" 
                            style="box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.3);
                                box-shadow: -10px -10px 50px rgba(0, 0, 0, 0.3);">';

                            $myObj->un = $row['usersUID'];
                            $myObj->em = $row['usersEmail'];
                            $myObj->img = $row2['url'];
                            $myObj->lvl = $row3['proLvl'];

                            $status = $row2['status'];
                            if ($status == 0) {
                                //no image uploaded
                                //set image to default image
                                $myObj->img = '/Project2/uploads/blank.png';
                            }

                            echo       '<img class="card-img-top" style="border-top-left-radius: 5px; border-top-right-radius: 5px;" 
                            src="' . $myObj->img . '">';
                            if (isset($_SESSION['userid'])) {
                                $sqlFav = "SELECT * FROM userfav WHERE userfav.uid = 
                                    " . $_SESSION['userid'] . " AND userfav.favuid = " . $row['usersID'] . ";";

                                $resultFav = mysqli_query($conn, $sqlFav);

                                if (mysqli_num_rows($resultFav) > 0) {
                                    while ($rowFav = mysqli_fetch_assoc($resultFav)) {
                                        echo '<button class="fav-btn" value="0" id="favbtn-' . $row['usersID'] . '" onclick = "addToFav(' . $row['usersID'] . ')" style="opacity: 1;"><i class="fas fa-heart"></i></button>';
                                    }
                                } else {
                                    echo '<button class="fav-btn" value="1" id="favbtn-' . $row['usersID'] . '" onclick = "addToFav(' . $row['usersID'] . ')" ><i class="fas fa-heart"></i></button>';
                                }
                                if ($_SESSION['isadmin'] == 1) {
                                    echo '<button class="del-btn" value="1" id="delbtn-' . $row['usersID'] . '" onclick = "deleteU(\'' . $row['usersUID'] . '\')" ><i class="fas fa-trash-alt"></i></button>';
                                }
                            } else {
                                echo '<button class="fav-btn" value="-1" id="favbtn-' . $row['usersID'] . '" onclick = "addToFav(' . $row['usersID'] . ')" ><i class="fas fa-heart"></i></button>';
                            }
                            echo '<div class="card-body">
                                    <h3 class="card-title">' . $myObj->un . '</h3>
                                    <h5 class="card-text">' . $myObj->lvl . '</h5>
                                    <p class="card-text">' . $myObj->em . '</p>
                                </div>
                                <div class="view-img" 
                                    style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                    <button class="btn btn-outline-secondary" value="' . $myObj->em . '" onclick = "contact(\'' . $myObj->em . '\')">Contact Pro</button>
                                </div>
                            </div>
                        </div>';
                        }
                    }
                }
            }
        }
    }
} else {
    echo "No users yet!";
}
echo '</div>';
