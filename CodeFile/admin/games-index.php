<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    ob_start();
    $error = "";
?>

  <style>
    .table-responsive{
      overflow-x: scroll;
      max-width: 100%;
      overflow-y: auto;
      margin-bottom: 15px;
      background-color: #f9f9f9;
      padding: 20px;
      box-shadow: 0px 0px 5px #999;
      /* max-height: 700%; */
    }
    .container {
       display: flex;
       justify-content: center;
       align-items: center;
       /* height: 100vh;  */
       background-color: #f9f9f9;
     }
  </style>
<?php include_once('includes/header.php');  ?>
<body>
    <main>
      <?php include_once('includes/sidebar.php');  ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-">
                </div>
                <div class="col-sm-12">
                    <br>
                    <h1>CRUD GAMES</h1>
                    <div class="table-responsive">
                        <table id="games-tbl" class="table table-striped table-borderd" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Instructions</th>
                                <th>Video</th>
                                <th>Material</th>
                                <th>Time Required</th>
                                <th>Document url</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                $sql = "SELECT * from games";
                                $result = $conn->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result -> fetch_assoc()){
                                        $sqlGetCate = "SELECT type from categories where id = ?";
                                        $stmtGetCate = $conn->prepare($sqlGetCate);
                                        $stmtGetCate->bind_param("i", $row['id_category']);
                                        $stmtGetCate->execute();
                                        $resultGetCate = $stmtGetCate->get_result();
                                        if($cateRow = $resultGetCate->fetch_assoc()){
                                            $cateType = $cateRow['type'];
                                        }
                                        $stmtGetCate->close();
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['instructions'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['video_url'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['materials'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['time_required']); ?></td>
                                            <td><?php echo htmlspecialchars($row['document_url'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($cateType); ?></td>
                                            <td>
                                                <?php 
                                                if (!empty($row['image'])) {
                                                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Image" style="width: 50px; height: 50px;">';
                                                } else {
                                                    echo 'No image';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button class="edit-btn btn btn-primary"><a style="color: white" href="editGames.php?id=<?php echo $row['id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button> <br>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="delete-id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="delete-btn btn btn-danger" onclick="return confirm('Do you really want to Delete ?');"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>          
                                        </tr>
                                        <?php
                                    }
                                }
                                $result -> close();
                                ?>
                                
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-container">
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h2 class="mb-4">Add new</h2>
                        
                        <div class="form-group">
                            <input type="hidden" name="id" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="instructions">Instructions</label>
                            <textarea name="instructions" class="form-control" placeholder="Enter instructions"></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="video_url">Video</label>
                            <input value="<?php echo htmlspecialchars($row['video_url']) ?>" type="file" name="video_url" class="form-control-file" accept=".mp4" required><br>
                            <span style="color:red; font-size:12px;">Only MP4  format allowed.</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="materials">Materials</label>
                            <textarea name="materials" class="form-control" placeholder="Enter materials"></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="time_required">Time Required</label>
                            <input type="number" name="time_required" class="form-control" placeholder="Enter time" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="document_url">Document</label>
                            <input type="file" name="document_url" class="form-control-file" accept=".pdf,.doc,.docx,.txt" required><br>
                            <span style="color:red; font-size:12px;">Only PDF, DOC, DOCX, TXT format allowed.</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="id_category">Category</label>
                            <select name="id_category" id="id_category">
                                <?php 
                                    $sql = "SELECT * 
                                    FROM categories
                                    WHERE id in (SELECT min(id)
                                                FROM categories
                                                GROUP BY type);
                                    ";
                                    $result = $conn->query($sql);
                                    if($result -> num_rows > 0){
                                        while($row = $result -> fetch_assoc()){
                                            echo "<option value='". htmlspecialchars($row['id']). "'>". htmlspecialchars($row['type']). "</option>";
                                        }
                                    }
                                    $result -> close();
                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"><br>
                            <div id="image-preview"></div>
                            <span style="color:red; font-size:12px;">Only PNG, GIF, JPEG, JPG, WEBP, SVG format allowed.</span>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Add new</button>
                        <br>
                        <br>
                    </form>
                </div>
            </div>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = intval($_POST['id']);
                    $name = isset($_POST['name']) ? $_POST['name'] : '';
                    $instructions = isset($_POST['instructions']) ? $_POST['instructions'] : '';
                    $video_url =  isset($_FILES['video_url']['name']) ? $_FILES['video_url']['name'] : '';
                    $materials = isset($_POST['materials']) ? $_POST['materials'] : '';
                    $time_required = isset($_POST['time_required']) ? $_POST['time_required'] : '';
                    $document_url = isset($_FILES['document_url']['name']) ? $_FILES['document_url']['name'] : '';
                    $id_category = isset($_POST['id_category']) ? $_POST['id_category'] : '';
                    $image = isset($_POST['image']) ? $_POST['image'] : '';
                    // $image = isset($_POST['current_image']) ? $_POST['current_image'] : '';
                    // $image = $_FILES['image']['name'] ?? '';
                    
                    $video_url = null;
                    $document_url = null;
                    // $image = null;

                    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
                        $target_dir = "uploads/";
                        $video_url = uniqid() . '-' . basename($_FILES['video_url']['name']); // Thay đổi tên file
                        $target_file_video = $target_dir . $video_url;
                        $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));
                        $videoFileSize = $_FILES['video_url']['size'];

                        if ($videoFileType != "mp4") {
                            $error .= "Sorry, only MP4 files are allowed for video.<br>";
                        }

                        if ($videoFileSize > 6 * 1024 * 1024) { 
                            $error .= "This upload file is larger than 6MB.<br>";
                        }

                        if (!move_uploaded_file($_FILES["video_url"]["tmp_name"], $target_file_video)) {
                            $error .= "Sorry, there was an error uploading your video file.<br>";                        }
                    }

                    if (isset($_FILES['document_url']) && $_FILES['document_url']['error'] == 0) {
                        $target_dir = "uploads/";
                        $document_url = uniqid() . '-' . basename($_FILES['document_url']['name']); // Thay đổi tên file
                        $target_file_document = $target_dir . $document_url;
                        $documentFileType = strtolower(pathinfo($target_file_document, PATHINFO_EXTENSION));
                        $documentFileSize = $_FILES['document_url']['size'];
                        $allowedDocumentTypes = ['pdf', 'doc', 'docx', 'txt'];
                        if (!in_array($documentFileType, $allowedDocumentTypes)) {
                            $error .= "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for document.<br>";
                        }

                        if ($documentFileSize > 6 * 1024 * 1024) { 
                            $error .= "This upload file is larger than 6MB.<br>";
                        }
                        if (!move_uploaded_file($_FILES["document_url"]["tmp_name"], $target_file_document)) {
                            $error .= "Sorry, there was an error uploading your document file.<br>";
                        }
                    }
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                        $target_dir = "uploads/";
                        $image = uniqid() . '-' . basename($_FILES['image']['name']); 
                        $target_file_image = $target_dir . $image;
                        $imageFileType = strtolower(pathinfo($target_file_image, PATHINFO_EXTENSION));
                        $imageFileSize = $_FILES['image']['size'];
                        $uploadOk = 1;
                
                        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];
                        if (!in_array($imageFileType, $allowedImageTypes)) {
                            $error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image.<br>";
                            $uploadOk = 0;
                        }
                
                        if ($imageFileSize > 2 * 1024 * 1024) { 
                            $error .= "This upload file is larger than 2MB.<br>";
                            $uploadOk = 0;
                        }
                
                        if ($uploadOk) {
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file_image)) {
                                $image = $target_file_image;
                            } else {
                                $error .=  "Sorry, there was an error uploading your file.";
                            }
                        }
                    }else{
                        $image = null;
                    }
                    if($error){
                        echo '<div id="error-alert" class="alert alert-danger">'.$error.'</div>';
                    }
                    if(empty($error)){
                        $sql = "SELECT * from games where id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            echo "The game already exists";
                            header('Location: games-index.php');
                            exit();
                        } else {
                            $sqlCheck = "SELECT id FROM categories WHERE id = ?";
                            $stmtCheck = $conn->prepare($sqlCheck);
                            $stmtCheck->bind_param("i", $id_category);
                            $stmtCheck->execute();
                            $resultCheck = $stmtCheck->get_result();
                            if($resultCheck->num_rows > 0) {
                                $sqlCreate = "INSERT INTO games (name, instructions, video_url, materials, time_required, document_url, id_category, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmtCreate = $conn->prepare($sqlCreate);
                                $stmtCreate->bind_param("ssssisis", $name, $instructions, $video_url, $materials, $time_required, $document_url, $id_category, $image);
                                if ($stmtCreate->execute()) {
                                    echo "<script>alert('Game is added successfully');</script>";
                                    header('Location: games-index.php');
                                    exit();
                                } else {
                                    echo "Error: " . $sqlCreate . "<br>" . $conn->error;
                                }
                                $stmtCreate->close();
                            }else {
                                echo "Invalid category ID";
                            }
                            $stmtCheck->close();
                        }
                        $stmt->close();
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-id'])) {
                    $id = intval($_POST['delete-id']);
                    $sql = "DELETE FROM games WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        echo "<script>alert('Game is deleted ');</script>";
                        header('Location: games-index.php');
                        exit();
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                }
            ?>
        </div>
    </main>
    <?php include_once('includes/footer.php'); }?>
</body>


   
    
    <script>
        // new DataTable('#categories-tbl');
        $(document).ready(function() {
         $('#games-tbl').DataTable();
        });
    </script>

<?php
    ob_end_flush();
?>
