<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('includes/header.php');

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
    if($id > 0){
        $sql = "SELECT * from contact where id =?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $address = $row['address'];
            $phone = $row['phone'];
            $email = $row['email'];
        }else{
            echo "Error: ". $sql. "<br>". $conn -> error;
        }
        $stmt -> close();
    }
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    $sql = "SELECT * from contact where id = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("i", $id);
    $stmt -> execute();
    $result = $stmt -> get_result();
    if($result -> num_rows > 0){
       $sqlCreate = "UPDATE contact SET name = ?, address = ?, phone = ?, email = ? WHERE id = ?";
       $stmtCreate = $conn -> prepare($sqlCreate);
       $stmtCreate -> bind_param("ssssi",$name, $address, $phone, $email, $id );
       if($stmtCreate -> execute()){
        header('Location: contact-index.php');
       }else{
        echo "Error: ". $sqlCreate. "<br>". $conn -> error;
        header('Location: contact-index.php');
       }
    }else{
       
    }     
    $stmt -> close(); 
}
?>
<?php include_once('includes/header.php');  ?>
<body>
    <main>
      <?php include_once('includes/sidebar.php');  ?>
      <div class="container">
        <div class="form-container">
            <h2>Edit Contact</h2>
            <form action="editContact.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['name']); ?>" name="name" class="form-control" placeholder="Enter name" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['address']); ?>" name="address" class="form-control" placeholder="Enter address" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" value="<?php echo htmlspecialchars($row['phone']); ?>" name="phone" class="form-control" placeholder="Enter phone">
                </div>
                <br>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['email']); ?>" name="email" class="form-control" placeholder="Enter email">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="contact-index.php" class="btn btn-secondary">Go back</a>
                <br><br>
            </form>
        </div>
    </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
</body>
