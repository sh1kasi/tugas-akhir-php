<?php 

require_once('function/helper.php'); 
require_once('function/connection.php');

session_start();

if (isset($_COOKIE['authenticated_user'])) {
    // dd($_SESSION);
    $query = mysqli_query($connect, "SELECT * FROM admins WHERE id=".$_COOKIE['authenticated_user']);
    $user = mysqli_fetch_object($query);
} else {
    session_destroy();
    setcookie("authenticated_user", '', time() - 31536000);
    header("Location: login.php");
}

if (isset($_GET['logout'])) {
    // session_unset();
    // session_destroy();

    unset($_COOKIE['authenticated_user']);
    setcookie('authenticated_user', '', time() - 3600, "/");
    // dd($_COOKIE);
    
    header("Location: login.php");
}

$id = $_GET['id'];

$query = mysqli_query($connect, "SELECT * FROM username where id = " . $id);

$user = mysqli_fetch_object($query);

// dd($user->image);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | <?= ucfirst($user->username); ?></title>
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/style.css' ?>">
    <script src="<?= BASE_URL . 'assets/template/jquery.js' ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> -->
        <script src="<?= BASE_URL . 'assets/template/feather.min.js' ?>"></script>

</head>
<body id="user_body">
    
<div class="dashboard">
    <div class="dashboard-header">
        <div class="navbar">
            <nav id="navbar">
                <div class="nav_item1">
                    <button type="button" id="toggle_sidebar" style="border: none; background-color: #3c3f41; padding-top: 10px"><i data-feather="menu" style="color: white;"></i></button>
                </div>
                    <div class="nav_item2" style="top: 10px; right: 0; position: absolute; padding-right: 10px;">
                        <!-- <button type="button" id="toggle_sidebar" style="border: none; background-color: #3c3f41; padding-top: 10px;"> -->
                            <span><?= ucfirst($user->username); ?></span>
                            <i data-feather="user" style="color: white;"></i>
                        </button>
                    </div>
            </nav>
        </div>
    </div>
    <div class="alert s-mess d-none">
        <span id="succ_message"></span>
    </div>
    <div class="alert f-mess">
        <span id="failed_message"></span>
    </div>
    <div class="dashboard-body">
        <!-- <div class="main-dashboard"></div> -->
        <div class="sidebar-container">
            <div class="sidebar">
                <ul>
                    <li><a href="<?= BASE_URL . 'user.php' ?>"><i data-feather="user"></i> &nbsp; CRUD</a></li>
                </ul>
                <ul>
                    <li><a href="?logout=true"><i data-feather="log-out"></i> &nbsp; Logout</a></li>
                </ul>
            </div>
            <div class="shadow d-none">

            </div>    
        </div>
        <div class="login_container" style="width: 630px;">
            <h2 class="login">Detail <?= $user->username; ?></h2>
            <div class="detail" style="padding-bottom: 15px;">
                <div class="image">
                    <img class="previewEdit"id="previewEdit" style="margin-left: 20px; margin-top: 15px; max-width: 200px;" src="assets/image/<?= $user->image ?>" alt="">
                </div>
                <div class="border" style="border-right: 1px solid white;"></div>
                <div class="information_detail" style="display: flex; flex-direction: column;">
                    <div class="data">
                        <div class="username">
                            <p>Username : <?= $user->username; ?></p>
                        </div>
                        <div class="password">
                            <p>Password : <?= $user->password; ?></p>
                        </div>
                    </div>
                    <div class="back_button">
                        <div class="button-back">
                            <button class="btn success" id="back_url" style="width: 100%; font-weight: bold; border-radius: 5px;">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<?php
// session_start();
        if (isset($_SESSION['error'])) {
            echo "<script>
                    $(document).ready(function () {
                        $('#failed_message').append('$_SESSION[error]');
                        $('.f-mess').toggleClass('visible')

                        setTimeout(() => {
                            $('.f-mess').toggleClass('visible')
                        }, 2500);
                        });
                  </script>";
            unset($_SESSION['error']);
        }

    
?>

<script>
    $(document).ready(function () {
        feather.replace();
        $("#toggle_sidebar").click(function (e) { 
            e.preventDefault();
            $(".sidebar").toggleClass('visible');
            $(".shadow").removeClass("d-none");
        });
        $(".shadow").click(function (e) { 
            e.preventDefault();
            // alert("aa");
            $(".sidebar").removeClass("visible");
        });

        $("#back_url").click(function (e) { 
            e.preventDefault();
            window.history.back();
        });

    });


</script>

</html>