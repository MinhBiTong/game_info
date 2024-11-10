<?php
    error_reporting(0);
    require_once('../admin/includes/dataAccess.php');
    require_once('../admin/includes/utils.php');
    $conn = createDb();

    $_SESSION['last_activity'] = time();
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 600) {
        session_unset(); 
        session_destroy();
        header("Location: loginAdmin.php");
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    
    <div class="wrap-header">
  <header class="header">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">  
            <a href="./dashboard.php">
                <img src="./uploads/mywebsite-paint.png" style="height: 100px; width: 100px; background-color: rgb(208, 96, 26);">
            </a>
        </div>
    </nav>
  </header>
</div>
</body>
</html>
