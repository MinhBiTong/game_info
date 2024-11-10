<?php
    require_once('./includes/dataAccess.php');
    require_once('./includes/utils.php');
    $conn = createDb();

    if (isset($_POST['login'])) {
        $username = santize($_POST['username']);
        $password = santize($_POST['password']);

        $stmt = $conn->prepare("SELECT id, username, password FROM Users WHERE role = 'user' AND username = ?");
        if (!$stmt) {
            die("Failed: " . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['login'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                $userIp = $_SERVER['REMOTE_ADDR'];
                $_SESSION['error'] = "";

                $stmt = $conn->prepare("INSERT INTO Userlog (userId, username, userIp) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $_SESSION['id'], $_SESSION['login'], $userIp);
                $stmt->execute();
                $stmt->close();

                header("location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password";
                header("location: userlog.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("location: userlog.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/style.css">
</head>

<body>
    <form name="login" class="wrapper fadeInDown" method="post" enctype="multipart/form-data">
        <div id="formContent">
            <div class="fadeIn first">
                <div class="image-container">
                    <img src="admin/images/logohappygame.png" />
                </div>
            </div>
            <h2 class="active">User Login</h2>
            <p><i>Please fill in your credentials to login.</i></p>
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
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
            <i>You don't have an account yet, right?</i><a href="signup.php">Sign up</a>
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div>
        </div>
    </form>
    <script src="admin/js/scriptAdmin.js"></script>
</body>

</html>
