<?php
session_start();
include 'includes/dbh.inc.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
$title = "Home Page - WWW Project";
$style = "/css/style.css";
$resetStyle = "/css/reset.css";
$useGlobal = 1;
include_once 'header.php';
include_once 'navbar.php';
?>
<!-- <script src="js/loadCom.js"></script> -->
<script>
    $(document).ready(function() {
        $("#cardContainer").load("/includes/frontpageInit.php");
        var commentCount = 4;
        $("#loadCom").click(function() {
            $("#comments").load("includes/loadcomments.php", {
                commentNewCount: commentCount,
            });
            commentCount = commentCount + 2;
        });
    });
</script>
<!--- Images --->
<div class="container-fluid padding">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4">Book a professional graphic designer now!</h1>
        </div>
        <div class="col-12">
            <h5 class="display-12">Find the best among many today!</h5>
        </div>
    </div>
    <hr>
</div>
<!--- Cards --->
<script>

    function addToFav(favid) {
        var x = document.getElementById("favbtn-" + favid).getAttribute("value");
        var obj = {
            table: []
        };

        obj.table.push({
            uid: favid
        });

        var json = JSON.stringify(obj);

        var xhr = new XMLHttpRequest();

        if (x === "0") {
            document.getElementById("favbtn-" + favid).style.opacity = "0.5";
            document.getElementById("favbtn-" + favid).setAttribute("value", "1");
            xhr.open("POST", "/includes/removeFromFav.php");
        } else {
            document.getElementById("favbtn-" + favid).style.opacity = "1";
            document.getElementById("favbtn-" + favid).setAttribute("value", "0");
            xhr.open("POST", "/includes/addToFav.php");
        }

        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
    }

    function deleteU(userToDelete) {
        // alert("Hey");
        var obj = {
            table: []
        };

        obj.table.push({
            uid: userToDelete,
            redir: "/index.php"
        });

        var json = JSON.stringify(obj);

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "/includes/deleteUser.php");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
        // alert("Database Flushed Successfully");
        // console.log("Clicked!");
        // window.location.reload(true)
    }
</script>
<div class="container-fluid padding" id="cardContainer">
</div>

<hr class="light">
<!--- Comment Section --->
<script>
    function deleteCom(comID) {
        var obj = {
            table: []
        };

        obj.table.push({
            id: comID
        });

        var json = JSON.stringify(obj);

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "/includes/deleteCom.php");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
        setTimeout(function() {
            window.location.href = "/index.php?deletedCommentSuccessfully";
        }, 500);
        // location = '/index.php?deletedCommentSuccessfully';
    }
</script>
<div class="container-fluid padding">
    <div class="col-12 text-center">
        <h2>Comments</h2>
    </div>
    <div class="comment-section row padding">
        <div class="col-12">
            <div id="comments">
                <?php
                include_once 'includes/dbh.inc.php';
                $commentNewCount = 2;
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
                ?>
            </div>
            <button class="btn btn-outline-secondary" id="loadCom">Load More Comments</button>
        </div>
        <form action="/includes/addcomment.inc.php" method="POST">
            <div class="add-new-comment" style="display: block; align-items: center;">
                <textarea type="text" name="user-comment" id="user-comment" cols="80" rows="2" placeholder="Write a comment" style="border: none; border-radius: 3px; width: 70vw; max-width: 1000px; padding: 15px; margin: 5px; bottom: 0;"></textarea>
                <button type="submit" name="submit" class="btn btn-outline-secondary">Post Comment</button>
            </div>
        </form>

    </div>
</div>

<hr class="light">
<!--- Connect --->
<div class="container-fluid padding">
    <div class="row text-center padding">
        <div class="col-12">
            <h2>Connect</h2>
        </div>
        <div class="col-12 social padding">
            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>
