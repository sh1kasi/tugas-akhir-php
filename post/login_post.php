<?php

require_once('../function/helper.php');
require_once('../function/connection.php');


$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($connect, "SELECT * FROM admins where username = '$username' AND password = '$password'");
$data = mysqli_fetch_object($query);
// dd($query);
session_start();

if ($query->num_rows == 1) {
    $_SESSION['user'] = mysqli_fetch_assoc($query);
    $_SESSION['success'] = "Berhasil Login, selamat datang!";
    setcookie('authenticated_user', $data->id, time()+3600*3, "/");
// setcookie('user', json_encode(mysqli_fetch_assoc($query)), time()+60*60*24*30, "/");
    // dd(mysqli_fetch_assoc($query));
    redirect("../user.php");
} else {
    $_SESSION['failed'] = "Username atau Password Salah!";
    redirect("../login.php");
}




?>