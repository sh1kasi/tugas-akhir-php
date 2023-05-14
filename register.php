<?php 
    require_once('function/helper.php'); 
    require_once('function/connection.php');

    if (isset($_COOKIE['authenticated_user'])) {
        if (isset($_COOKIE['authenticated_user'])) {
            redirect("user.php");
        }
    } else {
        $_COOKIE['authenticated_user'] = 0;
    }   

?>
<!DOCTYPE html>
<html id="register_page" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/style.css' ?>">
    <script src="<?= BASE_URL . 'assets/template/jquery.js' ?>"></script>

</head>

<body>
    <div class="register_container">
        <h2 class="login">Register</h2>
        <div class="form">
            <form action="<?= BASE_URL . 'post/register_post.php' ?>" method="POST">
                <div class="username">
                    <label for="username" id="label_username" style="font-weight: bold;">Username</label> <br>
                    <input type="text" id="username" class="inputan" name="username" style="width: 100%;"
                        placeholder="Username" required >
                </div>
                <div class="password" style="margin-top: 15px;">
                    <label for="password" style="font-weight: bold;">Password</label> <br>
                    <input type="password" id="password" class="inputan" name="password" style="width: 100%;"
                        placeholder="Password" required >
                </div>
                <div class="password" style="margin-top: 15px;">
                    <label for="password" style="font-weight: bold;">Konfirmasi Password</label> <br>
                    <input type="password" id="password_confirmation" class="inputan" name="password_confirmation"
                        style="width: 100%;" placeholder="Konfirmasi Password" required >
                </div>
                <div class="error">
                    <p id="err_message" style="color: red; font-weight: 12px;"></p>
                </div>
                <div class="submit login_submit">
                    <button class="success btn" id="submit" type="submit" name="submit" style="margin-top: 15px; width: 200px;">Daftar</button>
                    <button class="secondary btn" id="button"
                        style="margin-top: 15px; width: 200px; margin-left: 7px;">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>


<?php
session_start();

    if (isset($_SESSION['error'])) {
        // var_dump($_SESSION['error']);
        // die();
        echo "<script>
                $(document).ready(function () {
                    $('#err_message').append('$_SESSION[error]').hide().show('slow');
                });
              </script>";
        session_unset();
    }


    
?>

<script>

    $(".secondary").click(function (e) {
        e.preventDefault();
        window.location = 'login.php';
    });
</script>

</html>