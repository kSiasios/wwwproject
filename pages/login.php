<?php
$title = "Login - Konstantinos Siasios";
$style = "/Project2/css/login.css";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 0;
include_once '../header.php';
?>

<body>
    <section class="login-form">
        <div class="container">

            <div class="row">
                <div class="col">
                    <a href="/Project2/index.php"><img src="/Project2/images/logo.png"></a>
                    <h3>Sign into your account</h3>
                    <form action="/Project2/includes/login.inc.php" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="email" placeholder="Email Address" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <button type="submit" name="submit" class="loginbtn">Login</button>
                            </div>
                        </div>
                        <a href="#">Forgot password</a>
                        <p>Don't have an account yet?<a href="/Project2/pages/signup.php"> Register Now</a></p>
                    </form>
                </div>
            </div>
            <div class="toggle-container">
                <i class="fas fa-moon"></i>
                <input type="checkbox" id="switch" name="theme"></i><label for="switch">Toggle</label>
            </div>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<div style=\"margin-top: 25px;\"><p>Fill in all the fields</p></div>";
                } else if ($_GET["error"] == "wronglogin") {
                    echo "<div style=\"margin-top: 25px;\"><p>Man you gotta put your credentials correctly</p></div>";
                }
            }
            ?>
        </div>
    </section>
    <script src="/Project2/js/themeSwitch.js">

    </script>
</body>

</html>