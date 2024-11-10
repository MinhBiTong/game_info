<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('includes/header.php');
    $error = '';
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        if($id > 0){
            $sql = "SELECT * from Location where id =?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("i", $id);
            $stmt -> execute();
            $result = $stmt -> get_result();
            if($result -> num_rows > 0){
                $row = $result -> fetch_assoc();
                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $latitude = $row['latitude'];
                $longitude = $row['longitude'];
                $geolocation = $row['geolocation'];
                $avatar = $row['avatar'];
            }else{
                echo "Error: ". $sql. "<br>". $conn -> error;
            }
            $stmt -> close();
        }
    }
    elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $geolocation = $_POST['geolocation'];
        $avatar = '';

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
            $avatarFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $avatarFileSize = $_FILES['avatar']['size'];
            $allowed_types = ['png', 'gif', 'jpeg', 'jpg', 'webp', 'svg'];
            if (!in_array($avatarFileType, $allowed_types)) {
                echo $error = "Sorry, only PNG, GIF, JPEG, JPG, WEBP, SVG files are allowed for avatar.";
            }
            if ($avatarFileSize > 6 * 1024 * 1024) { 
                echo $error = 'This upload file is larger than 6MB.';
            }
            if(empty($error)){
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $avatar = $target_file;
                } else {
                    echo $error = 'Error uploading file.';
                }
            }
            
        }else{
            $avatar = '';
        }
        if($error){
            echo '<div id="error-alert" class="alert alert-danger">'.$error.'</div>';
            // exit();
        }

        if(empty($error)){
            $sql = "SELECT * from Location where id = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("i", $id);
            $stmt -> execute();
            $result = $stmt -> get_result();
            if($result -> num_rows > 0){
                $row = $result->fetch_assoc();
                if(empty($avatar)){
                    $avatar = $row['avatar'];
                }
            $sqlCreate = "UPDATE Location SET name = ?, description = ?, latitude = ?, longitude = ?, geolocation = ?, avatar = ? WHERE id = ?";
            $stmtCreate = $conn -> prepare($sqlCreate);
            $stmtCreate -> bind_param("ssiissi",$name, $description, $latitude, $longitude, $geolocation, $avatar, $id );
            if($stmtCreate -> execute()){
                header('Location: location-index.php');
            }else{
                echo $error = "Error: ". $sqlCreate. "<br>". $conn -> error;
                header('Location: location-index.php');
            }
            $stmtCreate->close();
            }else{
                $error = "Error: " . $sqlCreate . "<br>" . $conn->error;
            }
            $stmt -> close();
        } 

    }
?>
<?php include_once('includes/header.php');  ?>
<body>
    <main>
      <?php include_once('includes/sidebar.php');  ?>
      <div class="container">
        <div class="form-container">
            <h2>Edit Location</h2>
            <form action="editLocation.php" enctype="multipart/form-data" method="post">
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" placeholder="Enter name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required><?php echo htmlspecialchars($row['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo htmlspecialchars($row['latitude'] ?? ''); ?>" placeholder="Enter latitude" required>
                </div>
                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo htmlspecialchars($row['longitude'] ?? ''); ?>" placeholder="Enter longitude" required>
                </div>
                <div class="mb-3">
                    <label for="geolocation" class="form-label">Geolocation</label>
                    <input type="text" class="form-control" id="geolocation" name="geolocation" value="<?php echo htmlspecialchars($row['geolocation'] ?? ''); ?>" placeholder="Enter geolocation" required>
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*"><br>
                    <div id="avatar-preview"></div>
                    <img src="<?php echo htmlspecialchars($avatar); ?>" id="current-avatar" class="avatar" name="avatar" alt="Current Avatar" class="img-thumbnail mt-3" style="width: 200px;"><br>
                    <span style="color:red; font-size:12px;">Only PNG, GIF, JPEG, JPG, WEBP, SVG format allowed.</span>
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="location-index.php" class="btn btn-secondary">Go back</a>
            </form>
        </div>
      </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
    <script>
        function previewAvatar(input){
            var reader = new FileReader();
            reader.onload = function(e) {
                var avatarPreview = document.getElementById('avatar-preview');
                var currentAvatar = document.getElementById('current-avaar');
                avatarPreview.innerHTML = '<img src="' + e.target.result + '" class="avatar" style="width: 150px; height: 150px">';
                currentAvatar.src.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('avatar').addEventListener('change', function() {
            previewAvatar(this);
        });
    </script>
</body>
 