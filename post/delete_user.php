<?php 

require_once('../function/helper.php');
require_once('../function/connection.php');

    session_start();


$user_id = $_GET['user_id'];
$query2 = mysqli_query($connect, "SELECT * from username WHERE id =" . $user_id);
$data = mysqli_fetch_object($query2);
// dd($data);
$query = mysqli_query($connect, "DELETE from username WHERE id = " . $user_id);
unlink('../assets/image/' . $data->image);
// dd($query);
$_SESSION['success'] = "ID " . $user_id . " Berhasil terhapus!";
redirect("../user.php");


?>