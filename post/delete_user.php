<?php 

require_once('../function/helper.php');
require_once('../function/connection.php');

    session_start();


$user_id = $_GET['user_id'];
$query = mysqli_query($connect, "DELETE from username WHERE id = " . $user_id);
$_SESSION['success'] = "ID " . $user_id . " Berhasil terhapus!";
redirect("../user.php");


?>