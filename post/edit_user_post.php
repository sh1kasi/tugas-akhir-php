<?php

require_once('../function/helper.php');
require_once('../function/connection.php');

    $id = $_GET['id'];

    $query = mysqli_query($connect, "SELECT * FROM username where id = " . $id);
    $data = mysqli_fetch_object($query);

    $username = $_POST['name'];

    if ($password === "") {
        // dd("a");
        $password = $data->password;
        $password_confirmation = $data->password;
    } else {
        $password = md5($_POST['password']);
        $password_confirmation = md5($_POST['password_confirmation']);
    }

    // dd($password);

    $rand = rand();

    $files = $_FILES['image'];
    $image = $files['name'];
    $size = $files['size'];
    $ext_array = explode('.',$image);
    $max_size = 10485760;
    $allowed_extension = array('png', 'jpg', 'jpeg');
    $extension = end($ext_array);


    // dd($files);

    session_start();

    if (isset($username) && isset($password) && isset($password_confirmation)) {
        if ($password === $password_confirmation) {
                if ($files['name'] != "") {
                    if (in_array($extension,  $allowed_extension)) {
                        if ($size <= $max_size) {
                            $pepe = $rand.'_'.$image;
                            unlink('../assets/image/' . $data->image);
                            move_uploaded_file($files['tmp_name'], "../assets/image/".$rand."_".$image);
                            $query = mysqli_query($connect, "UPDATE username SET username='$username', password='$password', image='$pepe' WHERE id=" . $id);
                            $_SESSION['success'] = "Berhasil mengedit data!";
                            redirect("../user.php");
                        }
                    } else {
                        $_SESSION['error'] = "Format yang anda upload tidak didukung!";
                        redirect("../edit_user.php?id=$id");
                    }
                } else {
                    $_SESSION['success'] = "Berhasil mengedit data!";
                    $query = mysqli_query($connect, "UPDATE username SET username='$username', password='$password' WHERE id=" . $id);
                    redirect("../user.php");
                }
            
        } else {
            $_SESSION['error'] = "Password tidak sama!";
            redirect("../edit_user.php?id=$id");
        }
    } else {
        $_SESSION['error'] = "Harap isi form dengan lengkap!";
        redirect("../edit_user.php?id=$id");

    }

?>