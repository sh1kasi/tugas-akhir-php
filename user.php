<?php 
    require_once('function/helper.php'); 
    require_once('function/connection.php');

    session_start();


    if (isset($_COOKIE['authenticated_user'])) {
        // dd($_COOKIE);
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

    // $query = mysqli_query($connect, "SELECT * FROM username");

        
    $per_page = 2;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $per_page) - $per_page : 0;
    $result = mysqli_query($connect, "SELECT * FROM username");
    $total_data = mysqli_num_rows($result);
    $pages = ceil($total_data/$per_page);
    $query = mysqli_query($connect, "SELECT * FROM username LIMIT $start, $per_page");
    
    // dd($start);
    $data = [];
    while($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    // dd($page);
    // dd(json_encode($query));
    // dd(count($data));

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | <?= ucfirst($user->username); ?></title>
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/style.css' ?>">
    <script src="<?= BASE_URL . 'assets/template/jquery.js' ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> -->
        <script src="<?= BASE_URL . 'assets/template/feather.min.js' ?>"></script>

    
</head>
<body id="user_body">

<input type="hidden" id="start" value="<?= $start; ?>">
<input type="hidden" id="per_page" value="<?= $per_page; ?>">
    
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
    <div class="alert s-mess">
        <span id="succ_message"></span>
    </div>
    <div class="dashboard-body">
        <!-- <div class="main-dashboard"></div> -->
        <div class="sidebar-container">
            <div class="sidebar">
                <ul>
                    <a href="#"><li><i data-feather="user"></i> &nbsp; CRUD</li></a>
                </ul>
                <ul>
                    <a href="?logout=true"><li><i data-feather="log-out"></i> &nbsp; Logout</li></a>
                </ul>
            </div>
            <div class="shadow d-none">

            </div>    
        </div>
       <div class="user_main">
            <div class="header-button">
                <div class="add_button">
                    <a class="btn success" href="add_user.php" style="text-decoration: none;" type="button">Add</a>
                </div>
                <div class="search-filter">
                    <!-- <form action="" method="get"> -->
                            <label for="search_filter" style="color: white; font-weight: bold">Search: </label>
                            <input type="text" id="search_filter" placeholder="Cari Data">
                     <!-- </form> -->
                </div>
            </div>
           <div class="table">
                <table cellspacing="5" cellpadding="7">
                    <thead border="1">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Password</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody id="user_data">
                            <?php
                            if (count($data) != 0) { ?>
                                <?php  
                                foreach ($data as $value) : ?>
                                    <tr align="center">
                                        <td><?= $value["id"]; ?></td>
                                        <td><?= $value["username"]; ?></td>
                                        <td><?= $value["password"]; ?></td>
                                        <td><img src="assets/image/<?= $value["image"]  ?>" width="50px" alt="gaada"></td>
                                        <td style="text-align: center;">
                                            <a style="color: white;" id="edit_btn" href="edit_user.php?id=<?= $value['id'] ?>"><i data-feather="edit"></i></a>
                                            <a style="color: white;" href="detail_user.php?id=<?= $value['id'] ?>"><i data-feather="info"></i></a> 
                                            <a href="#" onclick="deleteUser(<?= $value['id']; ?>)" style="color: white;" ><i data-feather="trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?> 
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" align="center">Tidak Ada data</td>
                                </tr>
                            <?php } ?>
                            
                            
                            
                        </tbody>
                </table>
           </div>
           <div class="pagination">
            <div class="info">
                <?php if (count($data) != 0) : ?>
                    <p><?= $page; ?> dari <?= $pages; ?> halaman</p>
                <?php endif; ?>
            </div>
            <div class="page">
                <?php if (count($data) != 0 && $total_data > count($data)) :?>
                    <?php if (isset($_GET['page']) && $_GET['page'] != 1) : ?>
                        <a href="?page=<?= $page - 1; ?>"><</a>
                    <?php endif; ?>
                    <?php for ($i=1; $i <= $pages; $i++) : ?>
                        <a href="?page=<?= $i; ?>"><?= $i; ?></a>
                    <?php endfor; ?>
                    <?php if (isset($_GET['page']) && $_GET['page'] != $pages) : ?>
                        <a href="?page=<?= $page + 1; ?>">></a>
                    <?php elseif (!isset($_GET['page'])) : ?>
                        <a href="?page=<?= $page + 1; ?>">></a>
                    <?php endif; ?>
                    <?php else : ?>
                        
                <?php endif; ?>
            </div>
           </div>
       </div>

        <!-- Delete Modal -->
            <div class="delete_container d-none">
                <div class="delete_bg"></div>
                <div class="delete_window">
                    <div class="delete_content">
                        <div class="delete_header">
                           <p><svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg></p>
                        </div>
                        <div class="delete_body">
                            <h1>Anda Yakin?</h1>
                            <p id="delete_info"></p>
                        </div>
                        <div class="delete_footer">
                            <button class="btn danger" id="cancel_delete">Batal</button>
                            <button class="btn success" id="confirm_delete">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End -->

    </div>
</div>
</body>

<?php 

// dd($_SESSION);

if (isset($_SESSION['success'])) {
    echo "<script>
            $(document).ready(function () {
                $('#succ_message').append('$_SESSION[success]');
                $('.alert').toggleClass('visible')

                setTimeout(() => {
                    $('.alert').toggleClass('visible')
                }, 2500);
            });
          </script>";
    unset($_SESSION['success']);
} 

?>

<script>
    $(document).ready(function () {

        $("#search_filter").keyup(function (e) { 
            var searchVal = $(this).val();
            var pathname = window.location.pathname;
            var start = $("#start").val();
            var per_page = $("#per_page").val();
            
            $.ajax({
                type: "POST",
                url: "post/user_search.php",
                data: {
                    searchVal: searchVal,
                    start: start,
                    per_page: per_page,
                },
                dataType: "json",
                success: function (response) {
                    $("#user_data").html("");

                    console.log(response);

                    $(response).each(function (key, user) {
                        $("#user_data").append(`
                        <tr align="center">
                            <td>${user.id}</td>
                            <td>${user.username}</td>
                            <td>${user.password}</td>
                            <td><img src="assets/image/${user.image}" width="50px" alt="gaada"></td>
                            <td>
                                <a style="color: white;" id="edit_btn" href="edit_user.php?id=${user.id}"><i data-feather="edit"></i></a>
                                <a style="color: white;" href="detail_user.php?id=${user.id}"><i data-feather="info"></i></a> 
                                <a href="#" onclick="deleteUser(${user.id})" style="color: white;" ><i data-feather="trash"></i></a>
                            </td>
                        </tr>
                        `);
                        feather.replace();

                    });

                    // $("#user_data").append(append);
                    
                }
            });
        });

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

        $(".delete_bg").click(function (e) { 
            e.preventDefault();
            $(".delete_container").addClass("d-none");
        });


    });

    function deleteUser(id) {
        $(document).ready(function () {
            $(".delete_container").removeClass("d-none");
            $("#cancel_delete").click(function (e) { 
                e.preventDefault();
                $(".delete_container").addClass("d-none");
            });
            $("#delete_info").html(`Data dengan ${id} akan terhapus!`);
            $("#confirm_delete").click(function (e) { 
                e.preventDefault();
                window.location = `/tugasphp/post/delete_user.php?user_id=${id}`;
            });
        });
    }

</script>

</html>