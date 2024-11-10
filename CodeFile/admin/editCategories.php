<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
 require_once('includes/header.php');
 $error = "";

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
    if($id > 0){
        $sql = "SELECT * from categories where id =?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $type = $row['type'];
            // var_dump($id, $name, $type);
        }else{
            echo "Error: ". $sql. "<br>". $conn -> error;
        }
        $stmt -> close();
    }
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    // var_dump($id, $name, $type);
    
    $sql = "SELECT * from categories where id = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("i", $id);
    $stmt -> execute();
    $result = $stmt -> get_result();
    if($result -> num_rows > 0){
       $sqlCreate = "UPDATE categories SET name = ?, type = ? WHERE id = ?";
       $stmtCreate = $conn -> prepare($sqlCreate);
       $stmtCreate -> bind_param("ssi",$name, $type, $id );
       if($stmtCreate -> execute()){
        header('Location: categories-index.php');
       }else{
        echo "Error: ". $sqlCreate. "<br>". $conn -> error;
        header('Location: categories-index.php');
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
                <h2>Edit Categories</h2>
                <form action="editCategories.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="<?php echo $type; ?>">Name <?php echo $type; ?></option>
                            <?php
                                $sqlTypes = "SELECT DISTINCT type FROM categories";
                                $resultTypes = $conn->query($sqlTypes);
                                $types = [];
                                if ($resultTypes->num_rows > 0) {
                                    while ($rowType = $resultTypes->fetch_assoc()) {
                                        $types[] = $rowType['type'];
                                    }
                                }
                                foreach ($types as $itemType) {
                                    if ($itemType !== $type) {
                                        echo '<option value="' . htmlspecialchars($itemType) . '">' . htmlspecialchars($itemType) . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($row['name']) ?>" name="name" class="form-control" placeholder="Enter name" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="categories-index.php" class="btn btn-secondary">Go back</a>
                </form>
            </div>
        </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
