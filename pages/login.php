<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location:/theshoesbox/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The ShoesBox</title>
    <link rel="icon" type="/theshoesbox/assets/images/png" sizes="16x16" href="/theshoesbox/assets/images/logo1.png">

    <!-- Font Icon -->
    <link rel="stylesheet" href="/theshoesbox/assets/css/login-style/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="/theshoesbox/assets/css/login-style/css/style.css">
    <link rel="stylesheet" href="/theshoesbox/assets/css/bootstrap/bootstrap.min.css">
</head>

<body>
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="/theshoesbox/assets/css/login-style/images/login-img.png" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <!-- <form method="POST" class="register-form" id="login-form" action="./database/login.php"> -->
                        <div class="form-group">
                            <label for="your_email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="email" id="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password" />
                        </div>
                        <div class="my-3" id="errorDiv"></div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit me-3" value="Log in" />
                            <a href="/theshoesbox/index.php" class="form-submit" style="text-decoration: none;">Cancel</a>
                        </div>
                        <!-- </form> -->
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="https://www.facebook.com/"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="https://accounts.google.com/"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- JS -->
    <script src="/theshoesbox/assets/css/login-style/vendor/jquery/jquery.min.js"></script>
    <script src="/theshoesbox/assets/css/login-style/js/main.js"></script>
    <script src="/theshoesbox/assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Ajax -->
    <script>
        $("#document").ready(function() {
            $("#signin").on("click", function() {
                var email = $("#email").val()
                var password = $("#password").val()
                $.ajax({
                    type: "POST",
                    url: "/theshoesbox/processes/login-process.php",
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(res) {
                        if (res == "Success") window.location.href = "/theshoesbox/index.php"
                        else $("#errorDiv").html(`
                        <div class="alert alert-danger" role="alert">
                            ${res}
                        </div>
                        `)
                    }
                });
            });
        });
    </script>

</body>

</html>