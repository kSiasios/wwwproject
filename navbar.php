<body>

    <script>
    function contact(contactID) {
        var url = "/Project2/pages/contact.php?contactID=" + contactID;
        window.location.href = url;
    }
    </script>

    <?php

    // To check if session is started. 
    if (isset($_SESSION["useruid"])) {
        $minutes = 30;
        $timeToExpire = $minutes * 60;
        if (time() - $_SESSION["login_time_stamp"] > $timeToExpire) { // session expires minutes * seconds
            session_unset();
            session_destroy();
            header("Location: /Project2/index.php");
        }
    }
    ?>
    <!--- Navigation --->
    <nav class="navbar navbar-expand-md navbar-light sticky-top">
        <div class="container-fluid">
            <a href="/Project2/index.php" class="navbar-brand"><img src="/Project2/images/logo.png"></a>
            <div class="toggle-container">
                <i class="fas fa-moon"></i>
                <input type="checkbox" id="switch" name="theme"></i>
                <label class="switch" for="switch">Toggle</label>
            </div>

            <div class="hamburger d-block d-md-none">
                <input type="checkbox" id="toggle" data-toggle="collapse" data-target="#navbarResponsive">
                <label class="toggle" for="toggle"></label>
            </div>
            <div class="collapse navbar-collapse navbar-toggleable-xs" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false) {
                        echo '<li class="nav-item"><a href="/Project2/index.php" class="nav-link active">Home</a></li>';
                    } else {
                        echo '<li class="nav-item"><a href="/Project2/index.php" class="nav-link">Home</a></li>';
                    }
                    echo '<li class="nav-item"><a href="#" class="nav-link" id="myBtn">About</a></li>';
                    if (isset($_SESSION["useruid"])) {
                        if (strpos($_SERVER['REQUEST_URI'], 'contact.php') !== false) {
                            echo '<li class="nav-item"><a href="/Project2/pages/contact.php?contactID=0" class="nav-link active">Contact</a></li>';
                        } else {
                            echo '<li class="nav-item"><a href="/Project2/pages/contact.php?contactID=0" class="nav-link">Contact</a></li>';
                        }
                        if (strpos($_SERVER['REQUEST_URI'], 'profile.php') !== false) {
                            echo '<li class="nav-item"><a href="/Project2/pages/profile.php?profileID=' . $_SESSION['userid'] . '" class="nav-link active">Profile</a></li>';
                        } else {
                            echo '<li class="nav-item"><a href="/Project2/pages/profile.php?profileID=' . $_SESSION['userid'] . '" class="nav-link">Profile</a></li>';
                        }
                        if (isset($_SESSION["isadmin"])) {
                            if (strpos($_SERVER['REQUEST_URI'], 'admin_panel.php') !== false) {
                                echo "<li class='nav-item'><a href='/Project2/pages/admin_panel.php' class='nav-link active'>ADMIN</a></li>";
                            } else {
                                echo "<li class='nav-item'><a href='/Project2/pages/admin_panel.php' class='nav-link'>ADMIN</a></li>";
                            }
                        }

                        echo "<li class='nav-item'><button class='login-btn' onclick='document.location=\"/Project2/includes/logout.inc.php\"'>Log Out</button></li>";
                    } else {
                        echo "<li class='nav-item'><button class='login-btn' onclick='document.location=\"/Project2/pages/login.php\"'>Log In</button></li>";
                    }

                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php

    echo    '<div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
        <p style="padding: 5px; margin-left: 15px; bottom: 0;">This is a website developed by <b>Konstantinos Siasios</b> as a project for the course of WWW Technologies for the University of Thessaly.</p>
        </div>

    </div>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>';
    ?>
    <script src="/Project2/js/themeSwitch.js">
    </script>