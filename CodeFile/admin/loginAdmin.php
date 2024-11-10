<?php
require_once('../admin/includes/dataAccess.php');
require_once('../admin/includes/utils.php');
require_once('../admin/includes/jwt-helper.php');

// error_reporting(0);
    $conn = createDb();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['login'])){
            $username = santize($_POST['username']);
            $password = santize($_POST['password']);
            $rememberMe = isset($_POST['rememberMe']) ? true : false;
            // var_dump($rememberMe, $username, $password);
            $stmt = $conn->prepare("SELECT id, username, password FROM Users WHERE username = ? AND role = 'admin'");
            if (!$stmt) {
                die("Failed: " . $conn->error);
            }
            
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $userId = $user['id'];
                $hashedPassword = $user['password'];
    
                if (password_verify($password, $hashedPassword)) {
                    if ($rememberMe) {
                        $jwt = createJWT($userId);
                        setcookie('auth_token', $jwt, [
                            'expires' => time() + (60 * 60 * 24), // 24 giờ
                            'path' => '/',
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]);
                        if($isRemember != ""){
                            if(!isset($_POST['login'])){
                                setcookie('login', $cookie_value, [
                                    'expires' => $expire_time,
                                    'path' => $path,
                                    // 'domain' => null, 
                                    'httponly' => $httponly,
                                    'samesite' => $samesite
                                ]);
                            }
                        }
                    } else {
                        $_SESSION['login'] = $userId;
                    }
                    echo "<script>alert('Logged in successfully');</script>";
                    $extra = "dashboard.php";
                    $host = $_SERVER['HTTP_HOST'];
                    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    header("Location: http://$host$uri/$extra");
                    exit();
                } else {
                    echo "<script>alert('Username or password incorrect');</script>";
                    $extra = "loginAdmin.php";
                    $host = $_SERVER['HTTP_HOST'];
                    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    header("Location: http://$host$uri/$extra");
                    exit();
                }
            } else {
                echo "<script>alert('Username or password incorrect');</script>";
                $extra = "loginAdmin.php";
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri/$extra");
                exit();
            }
            $stmt->close();
        }
    }

    if ((isset($_SESSION['login']) && $_SESSION['login'] === true) ||
        (isset($_COOKIE['login']) && $_COOKIE['login'] === true)
    ) {
        header("Location: dashboard.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--JAVASCRIPT Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!--jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../admin/css/style.css">
</head>

<body>
    <form name="login" class="wrapper fadeInDown" method="post" enctype="multipart/form-data">
        <div id="formContent">
            <div class="fadeIn first">
                <div class="image-container">
                    <img src="../admin/images/logohappygame.png" />
                </div>
            </div>
            <h2 class="active">Admin Login</h2>
            <p><i>Please fill in your credentials to login.</i></p>
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != "") : ?>
                <p style="color:red;"><?php echo $_SESSION['error']; ?></p>
                <?php $_SESSION['error'] = ""; ?>
            <?php endif; ?>
            <label>Username <span>*</span></label>
            <input value="" type="text" class="fadeIn second" name="username" placeholder="Enter username" required>
            <label>Password <span>*</span></label>
            <input value="" type="password" id="password" class="fadeIn third" name="password" placeholder="Enter password" required><br>
            <input type="checkbox" id="showpassword" name="showpassword">Show password
            <br>
            <input type="checkbox" id="rememberMe" name="rememberMe" value="rememberMe"> Remember me!</input>
            <input name="login" type="submit" class="fadeIn fourth" value="Log In">
            <br>
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div>
        </div>
    </form>
    <script src="../admin/js/scriptAdmin.js"></script>
</body>

</html>