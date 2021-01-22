<?php
include 'dbh.inc.php';

$newLimit = $_POST['newlimit'];

$sql = "SELECT * FROM users ORDER BY usersID DESC LIMIT " . $newLimit . ";";

$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    echo '<table style="border-spacing: 10px 0; border-collapse: separate;">
                <tr>
                    <th>Users</th>';
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
    echo '</table>';
} else {
    echo "No users found!";
}