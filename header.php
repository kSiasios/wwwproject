<!DOCTYPE html>

<script>
// var x = ;
var theme = localStorage.getItem("theme");
var htmlTag = document.getElementsByTagName("html")[0];
var attribute = document.createAttribute("data-theme");

if (theme === "dark") {
    attribute.value = "dark";
} else {
    attribute.value = "light";
}

htmlTag.setAttributeNode(attribute);
</script>
<html lang='en'>

<head onload="themeSet();">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo "<title>" . $title . "</title>";
    ?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <?php
    $navbarStyle = "/Project2/css/navbar.css";
    $globalStyle = "/Project2/css/global.css";
    echo '<link rel="stylesheet" href="' . $resetStyle . '">';
    if ($useGlobal !== 0) {
        echo '<link rel="stylesheet" href="' . $globalStyle . '">';
    }
    echo "<link rel='stylesheet' href='" . $style . "'>";
    echo "<link rel='stylesheet' href='" . $navbarStyle . "'>";
    ?>
</head>