<?php

require_once('../admin/includes/dataAccess.php');
require_once('../admin/includes/utils.php');

error_reporting();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = santize($_POST['username']);
    $password = santize($_POST['password']);
    $phone = santize($_POST["phone"]);
    $email = santize($_POST["email"]);

    $sql = "SELECT * FROM Users WHERE role = 'user' and username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Users (username, password, phone, email, role) VALUES (?, ?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashedPassword, $phone, $email);
        if ($stmt->execute()) {
            echo "Register successfully <br>";
            header("Location: userlog.php");
            exit;
        } else {
            echo "Register failed: " . $stmt->error;
        }
    }
    $stmt->close();
}
$conn->close();
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
    <form class="wrapper fadeInDown" method="POST" action="" enctype="multipart/form-data">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <div class="image-container">
                    <img src="../admin/images/logohappygame.png" />

                </div>

            </div>
            <!-- Sign up Form -->
            <form>
                <h2 class="active">Sign up</h2>
                <p><i>Please fill in your credentials to sign up.</i></p>
                <form action="" method="post"></form>
                <input type="text" id="login" class="fadeIn second" name="username" placeholder="Enter username " required>
                <input type="text" id="email" class="fadeIn second" name="email" placeholder="Enter email">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Enter password" required>
                <input type="text" id="phone" class="fadeIn third" name="phone" placeholder="Enter phone">
                <input type="submit" class="fadeIn fourth" value="Sign Up">
            </form>
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="../index.php">Back Home</a>
            </div>
        </div>
    </form>
    <script src="../admin/js/scriptAdmin.js"></script>
</body>

</html>