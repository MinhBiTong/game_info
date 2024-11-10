<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('includes/header.php');
    $error = "";
 
 if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
    if($id > 0){
        $sql = "SELECT * from games where id =?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $instructions = $row['instructions'];
            $video_url = isset($row['video_url']) ? $row['video_url'] : '';
            $materials = $row['materials'];
            $time_required = $row['time_required'];
            $document_url = isset($row['document_url']) ? $row['document_url'] : '';
            $id_category = $row['id_category'];
            $image = isset($row['image']) ? $row['image'] : '';

        }else{
            echo $error = "Error: ". $sql. "<br>". $conn -> error;
        }
        $stmt -> close();
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $instructions = $_POST['instructions'];
    $video_url = isset($_POST['video_url']) ? $_POST['video_url'] : '';
    $materials = $_POST['materials'];
    $time_required = $_POST['time_required'];
    $document_url = isset($_POST['document_url']) ? $_POST['document_url'] : '';
    $id_category = $_POST['id_category'];
    $image = isset($_POST['image'])? $_POST['image'] : '';
    $image = '';

    $video_url = null;
    $document_url = null;
    // Kiểm tra và xử lý video file
    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
        $target_dir = "uploads/";
        $video_url = uniqid() . '-' . basename($_FILES['video_url']['name']); // Thay đổi tên file
        $target_file_video = $target_dir . $video_url;
        $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));
        $videoFileSize = $_FILES['video_url']['size'];
        if ($videoFileType != "mp4") {
            echo $error = "Sorry, only MP4 files are allowed for video.";
        }
        if ($videoFileSize > 6 * 1024 * 1024) { 
            echo $error = 'This upload file is larger than 6MB.';
        }
        if (!move_uploaded_file($_FILES["video_url"]["tmp_name"], $target_file_video)) {
            echo $error = "Sorry, there was an error uploading your video file.";
        }
    }

    if (isset($_FILES['document_url']) && $_FILES['document_url']['error'] == 0) {
        $target_dir = "uploads/";
        $document_url = uniqid() . '-' . basename($_FILES['document_url']['name']); // Thay đổi tên file
        $target_file_document = $target_dir . $document_url;
        $documentFileType = strtolower(pathinfo($target_file_document, PATHINFO_EXTENSION));
        $allowedDocumentTypes = ['pdf', 'doc', 'docx', 'txt'];
        $documentFileSize = $_FILES['document_url']['size'];
        if (!in_array($documentFileType, $allowedDocumentTypes)) {
            echo $error = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for document.";
        }
        if ($documentFileSize > 6 * 1024 * 1024) { // 6MB in bytes
            echo $error = 'This upload file larger than 6MB.'; 
        }
        // Kiểm tra và xử lý document fil
        if (!move_uploaded_file($_FILES["document_url"]["tmp_name"], $target_file_document)) {
            echo $error = "Sorry, there was an error uploading your document file.";
        }

    }
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
                $error = 'Error uploading file.';
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
        $sql = "SELECT * from games where id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
           $sqlCreate = "UPDATE games SET name = ?, instructions = ?, video_url= ?, materials = ?, time_required = ?, document_url = ?, id_category = ?, image = ? WHERE id = ?";
           $stmtCreate = $conn -> prepare($sqlCreate);
           $stmtCreate -> bind_param("ssssisisi",$name, $instructions, $video_url, $materials, $time_required, $document_url, $id_category , $image, $id );
           if($stmtCreate -> execute()){
            header('Location: games-index.php');
           }else{
            echo "Error: ". $sqlCreate. "<br>". $conn -> error;
            header('Location: games-index.php');
           }
        }else{
           $error  = "Not find game information";
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
            <h2>Edit Game</h2>
            <form action="editGames.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" name="name" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="instructions">Instructions</label>
                    <textarea name="instructions" class="form-control"><?php echo htmlspecialchars($row['instructions'] ?? ''); ?></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="video_url">Video URL</label>
                    <input type="file" value="<?php echo htmlspecialchars($row['video_url']); ?>" name="video_url" class="form-control" accept=".mp4" required><br>
                    <span style="color:red; font-size:12px;">Only MP4 format allowed.</span>
                </div>
                <br>
                <div class="form-group">
                    <label for="materials">Materials</label>
                    <textarea name="materials" class="form-control"><?php echo htmlspecialchars($row['materials'] ?? ''); ?></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="time_required">Time Required</label>
                    <input type="number" name="time_required" value="<?php echo htmlspecialchars($row['time_required'] ?? ''); ?>" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="document_url">Document URL</label>
                    <input type="file" value="<?php echo htmlspecialchars($row['document_url']); ?> name="document_url" class="form-control" accept=".pdf,.doc,.docx,.txt" required>
                    <span style="color:red; font-size:12px;">Only PDF, DOC, DOCX, TXT format allowed.</span>
                </div>
                <br>
                <div class="form-group">
                    <label for="id_category">Category</label>
                    <select name="id_category" id="id_category" class="form-control">
                        <?php
                        $sql = "SELECT DISTINCT  * FROM categories";
                        $result = $conn -> query($sql);
                        if ($result -> num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['type'];?></option>
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
                <a href="games-index.php" class="btn btn-secondary">Go back</a>
                <br><br>
            </form>
        </div>
      </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
</body>