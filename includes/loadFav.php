<?php
session_start();

include 'dbh.inc.php';

if (isset($_SESSION['userid'])) {
    $sql1 = "SELECT * FROM userfav WHERE userfav.uid = " . $_SESSION['userid'] . ";";

    $myObj = new \stdClass();

    $result = mysqli_query($conn, $sql1);
    echo '<div class="row">';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $sql2 = "SELECT * FROM users WHERE users.usersID = " . $row['favuid'] . ";";

            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $sql3 = "SELECT * FROM prousers WHERE prousers.uID = " . $row2['usersID'] . ";";

                    $result3 = mysqli_query($conn, $sql3);

                    if (mysqli_num_rows($result3) > 0) {
                        while ($row3 = mysqli_fetch_assoc($result3)) {

                            $sql4 = "SELECT * FROM usersimg WHERE usersimg.userID = " . $row['favuid'] . ";";
                            $result4 = mysqli_query($conn, $sql4);

                            if (mysqli_num_rows($result4) > 0) {
                                while ($row4 = mysqli_fetch_assoc($result4)) {
                                    if ($row2['usersID'] == $row3['uID']) {
                                        echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card" 
                            style="box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.3);
                                box-shadow: -10px -10px 50px rgba(0, 0, 0, 0.3);">';

                                        $myObj->un = $row2['usersUID'];
                                        $myObj->em = $row2['usersEmail'];
                                        $myObj->img = $row4['url'];
                                        $myObj->lvl = $row3['proLvl'];
                                        $status = $row4['status'];
                                        if ($status == 0) {
                                            //no image uploaded
                                            //set image to default image
                                            $myObj->img = '/Project2/uploads/blank.png';
                                        }

                                        echo '<img class="card-img-top" style="border-top-left-radius: 5px; border-top-right-radius: 5px;" 
                                                    src="' . $myObj->img . '">';
                                        echo '<button class="fav-btn" onclick = "removeFromFav(' . $row2['usersID'] . ')" ><i class="fas fa-trash-alt"></i></button>
                                                <div class="card-body">
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
            }
        }
    } else {
        echo "No users yet!";
    }
    echo '</div>';
}