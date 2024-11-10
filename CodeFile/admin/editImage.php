<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('includes/header.php');
    $error = "";
 
 if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
    if($id > 0){
        $sql = "SELECT * from Images where id =?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            $id = $row['id'];
            $game_id = $row['game_id'];
            $name = $row['name'];
            $image = isset($row['image']) ? $row['image'] : '';

        }else{
            echo $error = "Error: ". $sql. "<br>". $conn -> error;
        }
        $stmt -> close();
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $game_id = $_POST['game_id'] ? $_POST['game_id'] : '';
    $name = $_POST['name'] ? $_POST['name'] : '';
    $image = isset($_POST['image'])? $_POST['image'] : '';
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $imageFileSize = $_FILES['image']['size'];
        $allowed_types = ['png', 'gif', 'jpeg', 'jpg', 'webp', 'svg'];
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Sorry, only PNG, GIF, JPEG, JPG, WEBP, SVG files are allowed for image.";
        }
        if ($imageFileSize > 6 * 1024 * 1024) { 
            echo $error = 'This upload file is larger than 6MB.';
        }
        if(empty($error)){
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                echo $error = 'Error uploading file.';
            }
        }
        
    }else{
        $image = '';
    }
    if($error){
        echo '<div id="error-alert" class="alert alert-danger">' .$error. '</div>';
        // exit();
    }
    if(empty($error)){
        $sql = "SELECT * from Images where id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
           $sqlCreate = "UPDATE Images SET name = ?, game_id = ?, image = ? WHERE id = ?";
           $stmtCreate = $conn -> prepare($sqlCreate);
           $stmtCreate -> bind_param("sisi", $name, $game_id, $image, $id );
           if($stmtCreate -> execute()){
            header('Location: image-index.php');
           }else{
            echo "Error: ". $sqlCreate. "<br>". $conn -> error;
            header('Location: image-index.php');
           }
        }else{
           $error  = "Not find image information";
        }     
        $stmt -> close(); 
        $result -> close(); 
    }    
}
?>

<?php include_once('includes/header.php');  ?>
<body>
    <main>
      <?php include_once('includes/sidebar.php');  ?>
      <div class="container">
        <div class="form-container">
            <h2>Edit Image</h2>
            <form action="editImage.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" name="name" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="game_id">Game</label>
                    <select name="game_id" id="game_id" class="form-control">
                        <?php
                        $sql = "SELECT DISTINCT * FROM Games";
                        $result = $conn -> query($sql);
                        if ($result -> num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php
                            }
                        }
                       ?>
                    </select>
                </div>
                <br>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" value="<?php echo htmlspecialchars($row['image']); ?> class="form-control" id="image" name="image" accept="image/*"><br>
                    <div id="image-preview"></div>
                    <img src="<?php echo htmlspecialchars($image); ?>" id="current-image" class="image" name="image" alt="Current Image" class="img-thumbnail mt-3" style="width: 200px;"><br>
                    <span style="color:red; font-size:12px;">Only PNG, GIF, JPEG, JPG, WEBP, SVG format allowed.</span>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="image-index.php" class="btn btn-secondary">Go back</a>
                <br><br>
            </form>
        </div>
      </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
</body>