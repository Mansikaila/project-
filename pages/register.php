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

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <!-- <form method="POST" class="register-form" id="register-form" action="./database/register-process.php"> -->
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="name" id="name" placeholder="Your Name" />
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="phoneno"><i class="zmdi zmdi-phone"></i></label>
                            <input type="number" name="phoneno" id="phoneno" placeholder="Your Phone No." />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password" />
                        </div>
                        <div class="form-group">
                            <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" />
                        </div>
                        <div class="my-3" id="errorDiv"></div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit me-3" value="Register" />
                            <a href="/theshoesbox/index.php" class="form-submit" style="text-decoration: none;">Cancel</a>
                        </div>
                        <!-- </form> -->
                    </div>
                    <div class="signup-image my-1">
                        <figure><img src="/theshoesbox/assets/css/login-style/images/register-img.png" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- JS -->
    <script src="/theshoesbox/assets/css/login-style/vendor/jquery/jquery.min.js"></script>
    <script src="/theshoesbox/assets/css/login-style/js/main.js"></script>


    <!-- Ajax -->
    <script>
        $("#document").ready(function() {
            $("#signup").on("click", function() {
                var name = $("#name").val()
                var email = $("#email").val()
                var phoneno = $("#phoneno").val()
                var password = $("#password").val()
                var re_pass = $("#re_pass").val()
                $.ajax({
                    type: "POST",
                    url: "/theshoesbox/processes/register-process.php",
                    data: {
                        name: name,
                        email: email,
                        phoneno: phoneno,
                        password: password,
                        re_pass: re_pass,
                    },
                    success: function(res) {
                        if (res == "Success") window.location.href = "/theshoesbox/pages/login.php"
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