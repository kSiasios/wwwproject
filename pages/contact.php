<?php
session_start();
?>

<?php
$title = "Contact - Konstantinos Siasios";
$style = "/Project2/css/contact.css";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 1;
include_once '../header.php';
if (!isset($_SESSION['userid'])) {
    header('Location: /Project2/index.php');
}

if (isset($_GET["contactID"])) {
    if (!($_GET["contactID"] == "0")) {
        require_once '../includes/functions.inc.php';
        if (invalidEmail($_GET["contactID"]) !== false) {
            header("location: /Project2/index.php?error=invalidContact");
            exit();
        }
    }
}

include_once '../navbar.php';
?>

<!-- HERE GOES THE CONTENT OF THE PAGE -->

<div class="container-fluid">
    <form method="post" style="margin: 50px; margin-top: 100px">
        <?php
        if (isset($_GET["contactID"])) {
            if ($_GET["contactID"] == "0") {
                echo '<label for="email-address" style="padding: 5px; margin-left: 15px;">Contact Email Address:</label>';
                echo '<input type="text" id="email-address" name="email-address" value="email@myemail.com" readonly
                style="border: none; border-radius: 3px; width: auto; max-width: 1000px; padding: 5px; margin: 5px; bottom: 0;"><br>';
            } else {
                require_once '../includes/functions.inc.php';
                if (!(invalidEmail($_GET["contactID"]) !== false)) {
                    echo '<label for="email-address" style="padding: 5px; margin-left: 15px;">Contact Email Address:</label>';
                    echo '<input type="text" id="email-address" name="email-address" value="' . $_GET["contactID"] . '" readonly
                        style="border: none; border-radius: 3px; width: auto; max-width: 1000px; padding: 5px; margin: 5px; bottom: 0;"><br>';
                }
            }
        }
        ?>
        <!-- <input type="text" id="email-address" name="email-address" value="email@myemail.com" readonly
            style="border: none; border-radius: 3px; width: auto; max-width: 1000px; padding: 5px; margin: 5px; bottom: 0;"><br> -->

        <label for="user-email-address" style="padding: 5px; margin-left: 15px;">Your Email Address:</label>
        <?php
        if (isset($_SESSION['useremail'])) {
            echo '<input type="text" id="user-email-address" name="user-email-address" value="' . $_SESSION['useremail'] . '"
            style="border: none; border-radius: 3px; width: auto; max-width: 1000px; padding: 5px; margin: 5px; bottom: 0;"><br>';
        } else {
            echo '<input type="text" id="user-email-address" name="user-email-address" placeholder="email@myemail.com"
            style="border: none; border-radius: 3px; width: auto; max-width: 1000px; padding: 5px; margin: 5px; bottom: 0;"><br>';
        }
        ?>
        <textarea type="text" name="email-content" id="email-content" cols="80" rows="2" placeholder="Your Message..."
            style="border: none; border-radius: 3px; width: 70vw; max-width: 1000px; padding: 5px; margin-left: 15px; bottom: 0;"></textarea>

        <input class="login-btn" style="margin: 15px;" type="button" value="Send Email"
            onclick="alert('Not implemented!')" />
    </form>
</div>

<!-- HERE ENDS THE CONTENT OF THE PAGE -->
<?php
include_once '../footer.php';
?>