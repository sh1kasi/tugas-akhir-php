<?php 
    require_once('function/helper.php'); 
    require_once('function/connection.php');

    // dd($_COOKIE);
    if (isset($_COOKIE['authenticated_user'])) {
        if (isset($_COOKIE['authenticated_user'])) {
            redirect("user.php");
        }
    } else {
        $_COOKIE['authenticated_user'] = 0;
    }   
// 
?>
<!DOCTYPE html>
<html lang="en" id="login_page">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/style.css' ?>">
    <!-- <script src="<?= BASE_URL . 'assets/template/jquery.js' ?>"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="alert s-mess">
        <span id="succ_message"></span>
    </div>
    <div class="alert f-mess">
        <span id="failed_message"></span>
    </div>
    <div class="login_container">
        <h2 class="login">Login User</h2>
        <div class="form">
            <form action="<?= BASE_URL . 'post/login_post.php' ?>" method="POST">
                <div class="username">
                    <label for="username" id="label_username" style="font-weight: bold;">Username</label> <br>
                    <input type="text" id="username" class="inputan" name="username" style="width: 100%;"
                        placeholder="Username" required>
                </div>
                <div class="password" style="margin-top: 15px;">
                    <label for="password" style="font-weight: bold;">Password</label> <br>
                    <input type="password" id="password" class="inputan" name="password" style="width: 100%;"
                        placeholder="Password" required>
                </div>
                <div class="submit login_submit">
                    <button class="success btn" id="submit" type="submit" style="margin-top: 15px; width: 200px;">Login</button>
                    <button class="secondary btn" id="button" style="margin-top: 15px; width: 200px; margin-left: 7px;">Daftar</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    session_start();
        
    
        if (isset($_SESSION['success'])) {
            // dd("A");
            echo "<script>
            $(document).ready(function () {
                $('#succ_message').append('$_SESSION[success]');
                $('.s-mess').toggleClass('visible')

                setTimeout(() => {
                    $('.s-mess').toggleClass('visible')
                }, 2500);
            });
          </script>";
            session_unset();
        } elseif (isset($_SESSION['failed'])) {
            echo "<script>
                    $(document).ready(function () {
                        $('#failed_message').append('$_SESSION[failed]');
                        $('.f-mess').toggleClass('visible')

                        setTimeout(() => {
                            $('.f-mess').toggleClass('visible')
                        }, 2500);
                        });
                  </script>";
            session_unset();
        }
    
    ?>

        
    <script>        
        $(".secondary").click(function (e) { 
            e.preventDefault();
            window.location = 'register.php';
        });
    </script>
    

</body>


</html>