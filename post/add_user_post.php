<?php

require_once('../function/helper.php');
require_once('../function/connection.php');

    $username = $_POST['name'];
    $password = md5($_POST['password']);
    $password_confirmation = md5($_POST['password_confirmation']);

    $rand = rand();

    $files = $_FILES['image'];
    $image = $files['name'];
    $size = $files['size'];
    $ext_array = explode('.',$image);
    $max_size = 10485760;
    $allowed_extension = array('png', 'jpg', 'jpeg');
    $extension = end($ext_array);



    session_start();

    if (isset($username) && isset($password) && isset($password_confirmation)) {
        if ($password === $password_confirmation) {
            if (in_array($extension,  $allowed_extension)) {
                if ($size <= $max_size) {
                    $pepe = $rand.'_'.$image;
                    move_uploaded_file($files['tmp_name'], "../assets/image/".$rand."_".$image);
                    $_SESSION['success'] = "Berhasil menambahkan data!";
                    $query = mysqli_query($connect, "insert into username(username, password, image) values ('$username', '$password', '$pepe')");
                    redirect("../user.php");
                }
            } else {
                $_SESSION['error'] = "Format yang anda upload tidak didukung!";
                redirect("../add_user.php");
            }
        } else {
            $_SESSION['error'] = "Password tidak sama!";
            redirect("../add_user.php");
        }
    } else {
        $_SESSION['error'] = "Harap isi form dengan lengkap!";
        redirect("../add_user.php");

    }

?>