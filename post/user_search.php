<?php

require_once('../function/helper.php');
require_once('../function/connection.php');

$name = $_POST['searchVal'];
$per_page = $_POST['per_page'];
$start = $_POST['start'];

$search = "%" . $name . "%";
// dd($name);
if ($name === "") {
    $query = mysqli_query($connect, "SELECT * FROM username LIMIT $start, $per_page");
} else {
    $query = mysqli_query($connect, "SELECT * FROM username where username LIKE '$search' OR password LIKE '$search'");
}

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

// dd($data);

echo json_encode($data);

?>