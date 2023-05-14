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
        <div class="login_container">
            <h2 class="login">Edit <?= $user->username; ?></h2>
            <div class="form">
                <form action="<?= BASE_URL . 'post/edit_user_post.php?id=' . $id ?>" method="post" enctype="multipart/form-data">
                    <div class="username">
                        <label for="name" style="font-weight: bold">Nama</label> <br>
                        <input type="text" id="name" value="<?= $user->username; ?>" class="inputan" name="name" required style="width: 100%;">
                    </div>
                    <div class="password" style="margin-top: 15px;">
                        <label for="password" style="font-weight: bold">Password</label> <br>
                        <input type="password" id="password" class="inputan" required name="password" style="width: 100%;">
                    </div>
                    <div class="password_confirmation" style="margin-top: 15px;">
                        <label for="password_confirmation" style="font-weight: bold">Password Konfirmasi</label> <br>
                        <input type="password" required id="password_confirmation" 
                     class="inputan" name="password_confirmation" style="width: 100%;">
                    </div>
                    <div class="gambar" style="margin-top: 15px;">
                        <label for="gambar" style="font-weight: bold">Gambar</label> <br>
                        <input type="text" value="" hidden>
                        <input type="file" id="gambar" value="" onchange="getImagePreviewEdit(event)" class="inputan" name="image" style="width: 100%; padding: 6px 6px !important">

                        <?php if ($user->image) : ?>
                            <img class="previewEdit" onchange="getImagePreviewEdit(event)" id="previewEdit" style="margin-left: 140px; margin-top: 15px; max-width: 200px;" src="assets/image/<?= $user->image ?>" alt="">
                            <div class="preview" id="preview" style="margin-left: 140px; margin-top: 15px;">
                                <!-- <img src="assets\image\1193451540_siswa2.jpg" alt=""> -->
                            </div>
                        <?php else : ?>
                            <div class="preview" onchange="getImagePreview(event)" id="preview" style="margin-left: 140px; margin-top: 15px; max-width: 200px;">
                                <!-- <img src="assets\image\1193451540_siswa2.jpg" alt=""> -->
                            </div>
                        <?php endif; ?>
                       
                    </div>
                    <div class="error">
                        <p id="err_message" style="color: red; font-weight: 12px;"></p>
                    </div>
                    <div class="submit login_submit">
                        <button class="success btn" id="submit" style="margin-top: 15px; width: 200px;">Simpan</button>
                    </div>
                </form>
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

        $("#gambar").change(function (e) { 
            e.preventDefault();
            var gambar = $("#gambar").val()
            // console.log(gambar.split());
        });
    });

    function getImagePreview(event)
    {
     var image=URL.createObjectURL(event.target.files[0]); 
      var imagediv=document.getElementById('preview');
     var newimg=document.createElement('img');
     imagediv.innerHTML='';
     newimg.src=image;
     newimg.style.width="200px";
     imagediv.appendChild(newimg);
    }

    function getImagePreviewEdit(event) {
        $("#previewEdit").remove();
     var image=URL.createObjectURL(event.target.files[0]); 
     var imagediv=document.getElementById('preview');
     var newimg=document.createElement('img');
     imagediv.innerHTML='';
     newimg.src=image;
     newimg.style.width="200px";
     imagediv.appendChild(newimg);
    }

</script>

</html>