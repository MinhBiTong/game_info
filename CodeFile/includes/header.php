<?php
    require_once('dataAccess.php');
    require_once('utils.php');
    $conn = createDb();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
      <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--GOOGLE FONT-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- <header class="header d-grid">
        <nav class="navbar mt-30  fw-light navbar-expand-lg bg-body-tertiary">
            <div class="  container-fluid">  
                <button id="toggleButton"  class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
                </button>
                <div class="collapse  navbar-collapse" id="navbarSupportedContent">
                    <ul id="content" class="navbar-nav  me-auto mb-2 mb-lg-0">
                        <li class="nav-item  pl-5">
                            <a class="nav-link hover btn-nav active" aria-current="page" href="#">HOME</a>
                        </li>
                        <li class="nav-item pl-4">
                            <a class="nav-link btn-nav hover" href="#"> ITINERARY</a>
                        </li>
                        <li class="nav-item pl-4 dropdown">
                            <a class="nav-link hover" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                CATEGORY
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="listGame.php?type=Outdoor">OutDoor</a></li>
                                <li><a class="dropdown-item" href="listGame.php?type=Indoor">Indoor</a></li>
                                <li><a class="dropdown-item" href="listGame.php?type=Male">Male</a></li>
                                <li><a class="dropdown-item" href="listGame.php?type=Female">Female</a></li>
                                <li><a class="dropdown-item" href="listGame.php?type=Family">Family</a></li>
                                <li><a class="dropdown-item" href="listGame.php?type=Kid">Kid</a></li>
                            </ul>

                        </li>
                        <li class="nav-item pl-4 dropdown">
                            <a class="nav-link hover" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                CONTACT
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="contact.php">Contact</a></li>
                                <li><a class="dropdown-item" href="#">About Us </a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="  d-flex justify-content-center">
        <div class="logo">
            <img src="./admin/uploads/mywebsite-paint.png">
        </div>
        </div>

        <div class=" mt-30 search">
            <form class="d-flex border-bottom" role="search">
                <input class="form-control me-2 no-border-radius" type="search" placeholder="Search...." aria-label="Search">
                <button class="btn-nav" type="submit"><i class=" fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    
    </header> -->
</body>
</html>
<?php
    include 'search.php';
    
    $_SESSION['last_activity'] = time();
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 600) {
        session_unset(); 
        session_destroy();
        header("Location: loginAdmin.php");
       }
       $_SESSION['last_activity'] = time(); // update last activity time stamp
?>