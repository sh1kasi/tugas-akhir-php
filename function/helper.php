<?php
    define("BASE_URL", "http://localhost:8080/tugasphp/");
    require_once('connection.php');
    // $server = "localhost";
    // $username = "root";
    // $password = "";
    // $table_name = "crud_php_native";
    
    // $connect = mysqli_connect($server, $username, $password, $table_name) or die("Database tidak terhubung!");


    function dd($var) {
        var_dump($var);
        die;
    }

    function redirect($url) {
        header("Location: " . $url);
    }

?>