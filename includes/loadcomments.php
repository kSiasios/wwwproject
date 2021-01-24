<?php
include 'dbh.inc.php';

$commentNewCount = $_POST['commentNewCount'];
if ($commentNewCount == NULL) {
    header("location: /Project2/index.php?commentLoadingFailed");
}

$sql = "SELECT * FROM comments ORDER BY id DESC LIMIT " . $commentNewCount . ";";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sql2 = "SELECT * FROM users WHERE users.usersID = " . $row['uid'] . ";";

        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                echo "<div class='comment-container'>";
                if (isset($_SESSION['useruid'])) {
                    if ($row2['usersUID'] == $_SESSION['useruid'] || $_SESSION['isadmin'] == 1) {
                        echo '<button class="btn btn-danger" onclick="deleteCom(' . $row['id'] . ')"
                        style="float: right;"><i class="fas fa-trash-alt"></i></button>';
                    }
                }
                echo "<p><b>";
                echo $row2['usersUID'];
                echo "</p></b>";
                echo "<p class='comment-message'>";
                echo $row['commentValue'];
                echo "</p>";
                echo "</div>";
            }
        }
    }
} else {
    echo "No comments yet!";
}
