<?php
session_start();
?>

<?php
$title = "My Favourites - Konstantinos Siasios";
$style = "/Project2/css/favourites.css";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 1;
include_once '../header.php';
if (!isset($_SESSION['userid'])) {
    header('Location: /Project2/index.php');
}
include_once '../navbar.php';
?>

<script>
$(document).ready(function() {
    $("#cardContainer").load("/Project2/includes/loadFav.php");
});

function removeFromFav(favid) {
    var obj = {
        table: []
    };

    obj.table.push({
        uid: favid
    });

    var json = JSON.stringify(obj);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "/Project2/includes/removeFromFav.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(json);
}
</script>
<div>
    <div class="container-fluid padding">

        <a href="/Project2/pages/profile.php?profileID=<?php echo $_SESSION['userid']; ?>" class="login-btn"
            style="top:250px; width: 120px; text-decoration: none; margin: 20px;"><i
                class="fas fa-arrow-left"></i>back</a>
    </div>

    <div class="container-fluid padding" id="cardContainer">
    </div>

</div>
<?php
include_once '../footer.php';
?>