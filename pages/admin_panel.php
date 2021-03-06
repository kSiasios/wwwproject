<?php
session_start();
?>

<?php
$title = "Admin Panel - Konstantinos Siasios";
$style = "";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 1;
include_once '../header.php';
if (!isset($_SESSION['userid'])) {
    echo "<script>window.location = '/index.php';</script>";
    // header('Location: /index.php');
    exit();
}
include_once '../navbar.php';
?>
<!-- HERE GOES THE CONTENT OF THE PAGE -->
<script src="/Project2/js/populateDB.js"></script>
<div class="container-fluid padding">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4">You have admin rights.</h1>
        </div>
        <div class="col-12">
            <div id="initDB"></div>
            <button class="btn btn-success" id="init-btn">Initialize Database</button>
        </div>
        <div class="col-12">
            <div id="flushDB"></div>
            <button class="btn btn-danger" id="flush-btn">Flush Database<i class="fas fa-trash-alt"
                    style="margin-left: 10px; "></i></button>
        </div>
    </div>
    <hr>
</div>

<script>
function deleteU(userToDelete) {
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
}
</script>

<script src="../js/loadUsers.js"></script>

<div class="container">
    <ul id="users">
        <table style="border-spacing: 10px 0; border-collapse: separate;">
            <tr>
                <th>Users</th>

            </tr>

            <?php
            include_once '../includes/dbh.inc.php';

            $newLimit = 2;

            $sql = "SELECT * FROM users ORDER BY usersID DESC LIMIT " . $newLimit . ";";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';

                    echo "<td>";
                    echo "<p style='margin-left: 15px;'>";
                    echo $row['usersUID'];
                    echo "</p>";
                    echo "</td>";
                    echo '<td><button class="btn btn-danger" onclick="deleteU(\'' . $row['usersUID'] . '\')"
                    style="margin-bottom: 20px;"><i class="fas fa-trash-alt"></i></button></td>';
                    echo "</tr>";
                }
            } else {
                echo "No users found!";
            }
            ?>
        </table>
    </ul>
    <button class="btn btn-outline-secondary" id="loadUsers" style="margin: 20px;">Load
        More User</button>
</div>

<!-- HERE ENDS THE CONTENT OF THE PAGE -->
<?php
include_once '../footer.php';
?>
