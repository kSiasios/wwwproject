<?php
$title = "Sign Up - Konstantinos Siasios";
$style = "/Project2/css/signup.css";
$resetStyle = "/Project2/css/reset.css";
$useGlobal = 0;
include_once '../header.php';
?>

<body>
    <section class="signup-form">
        <div class="container signup-form-form">
            <div class="row">
                <div class="col">
                    <a href="/Project2/index.php"><img src="/Project2/images/logo.png"></a>
                    <h3>Create your account</h3>
                    <form action="/Project2/includes/signup.inc.php" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="name" placeholder="Username" class="form-control">
                            </div>
                        </div>
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
                                <input type="password" name="passwordRepeat" placeholder="Repeat Password"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="toggle-container">
                            <ul class="status list-unstyled">
                                <li class="statusli">
                                    <input type="checkbox" id="isPro" name="isPro" class="isPro" value="isPro">
                                    <label id="isProLabel" for="isPro">
                                        <p>Looking for employment? What's your skill level?</p>
                                    </label>
                                </li>

                                <div id="proWrapper">
                                    <li>
                                        <input type="radio" id="Amateur" name="skill" value="Amateur">
                                        <label class="checkProLabel" for="Amateur">
                                            <p>Amateur</p>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="Intermediate" name="skill" value="Intermediate">
                                        <label class="checkProLabel" for="Intermediate">
                                            <p>Intermediate</p>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="Pro" name="skill" value="Pro">
                                        <label class="checkProLabel" for="Pro">
                                            <p>Pro</p>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="Master" name="skill" value="Master">
                                        <label class="checkProLabel" for="Master">
                                            <p>Master</p>
                                        </label>
                                    </li>
                                </div>
                                <script>
                                $("#proWrapper").hide();
                                </script>
                            </ul>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <button type="submit" name="submit" class="signupbtn">Sign Up</button>
                            </div>
                        </div>
                        <p>Already have an account?<a href="/Project2/pages/login.php"> Log In</a></p>
                    </form>
                </div>
            </div>
            <div class="toggle-container">
                <i class="fas fa-moon"></i>
                <input type="checkbox" id="switch" name="theme"><label id="switchThemeLabel" for="switch">Toggle</label>
            </div>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all the fields</p>";
                } else if ($_GET["error"] == "invaliduid") {
                    echo "<p>Something's wrong with your username</p>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<p>Something's wrong with your email</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>Repeat the password correctly!</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p>Try again pls. This server is stupid.</p>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<p>Man you gotta think of a more unique username</p>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<p>Finally! Someone with the skill to correctly sign up</p>";
                }
            }
            ?>
        </div>
    </section>

    <script src="/Project2/js/themeSwitch.js">

    </script>

    <script>
    $(function() {
        $(".isPro").change(function() {
            if ($(".isPro").is(':checked')) {
                $("#proWrapper").show();
            } else {
                $("#proWrapper").hide();
            }
        });

    });
    </script>
</body>

</html>