<?php

require_once('../function/helper.php');
require_once('../function/connection.php');

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $password_confirmation = md5($_POST['password_confirmation']);

    // dd(is_null($username));

    session_start();

    if (isset($username) && isset($password) && isset($password_confirmation)) {
        if ($password === $password_confirmation) {
            $_SESSION['success'] = "Berhasil membuat akun!";
            $query = mysqli_query($connect, "insert into admins(username, password) values ('$username', '$password')");
            redirect("../login.php");
        } else {
            $_SESSION['error'] = "Password tidak sama!";
            redirect("../register.php");
        }
    } else {
        $_SESSION['error'] = "Harap isi form dengan lengkap!";
        redirect("../register.php");

    }

?>