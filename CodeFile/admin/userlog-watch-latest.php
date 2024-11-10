<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('../admin/includes/dataAccess.php');
    require_once('../admin/includes/utils.php');
    $conn = createDb();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--JAVASCRIPT Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!--jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body bgcolor="#d6c2c2">
    <p><a href="dashboard.php">Go back</a>| <a href="logout.php">Logout</a> </p>
    <table class="table table-striped table-borderd">
        <tr>
            <th>No.</th>
            <th>User Id</th>
            <th>User Name</th>
            <th>User Ip</th>
            <th>Login Time</th>
        </tr>
        <?php 
            $sql = "SELECT * FROM UserLog WHERE userId= ?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result-> num_rows > 0){
                $count = 1;
                while ($row = mysqli_fetch_array($result)) {
                
        ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['userId']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['userIp']; ?></td>
                <td><?php echo $row['loginTime'];?></td>
            </tr>
        <?php $count = $count + 1;
                }
            } ?>
    </table>
</body>

</html>
<?php
    }
?>
