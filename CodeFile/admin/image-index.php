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
                    <h1>CRUD IMAGE</h1>
                    <div class="table-responsive">
                        <table id="images-tbl" class="table table-striped table-borderd" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Game</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                $sql = "SELECT * from Images";
                                $result = $conn->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result -> fetch_assoc()){
                                        $sqlGetGame = "SELECT name from Games where id = ?";
                                        $stmtGetGame = $conn->prepare($sqlGetGame);
                                        $stmtGetGame->bind_param("i", $row['game_id']);
                                        $stmtGetGame->execute();
                                        $resultGetGame = $stmtGetGame->get_result();
                                        if($gameRow = $resultGetGame->fetch_assoc()){
                                            $gameName = $gameRow['name'];
                                        }
                                        $stmtGetGame->close();
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($gameName);?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
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
                                                <button class="edit-btn btn btn-primary"><a style="color: white" href="editImage.php?id=<?php echo $row['id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button> <br>
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
                            <label for="game_id">Game</label>
                            <select name="game_id" id="game_id">
                                <?php 
                                    $sql = "SELECT * 
                                    FROM Games
                                    WHERE id in (SELECT min(id)
                                                FROM Games
                                                GROUP BY name);
                                    ";
                                    $result = $conn->query($sql);
                                    if($result -> num_rows > 0){
                                        while($row = $result -> fetch_assoc()){
                                            echo "<option value='". htmlspecialchars($row['id']). "'>". htmlspecialchars($row['name']). "</option>";
                                        }
                                    }
                                    $result -> close();
                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
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
                    $game_id = isset($_POST['game_id']) ? intval($_POST['game_id']) : 0;
                    $name = isset($_POST['name']) ? $_POST['name'] : '';
                    $image = $_FILES['image']['name'] ?? '';
                    
                    $image = null;

                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                        $target_dir = "uploads/";
                        $image = uniqid() . '-' . basename($_FILES['image']['name']); // Thay đổi tên file
                        $target_file_image = $target_dir . $image;
                        $imageFileType = strtolower(pathinfo($target_file_image, PATHINFO_EXTENSION));
                        $imageFileSize = $_FILES['image']['size'];
                        $uploadOk = 1;
                
                        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];
                        if (!in_array($imageFileType, $allowedImageTypes)) {
                            $error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image.<br>";
                            $uploadOk = 0;
                        }
                
                        if ($imageFileSize > 2 * 1024 * 1024) { // Giới hạn 2MB
                            $error .= "This upload file is larger than 2MB.<br>";
                            $uploadOk = 0;
                        }
                
                        if ($uploadOk) {
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file_image)) {
                                $image = $target_file_image;
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }else{
                        $image = null;
                    }
                    if($error){
                        echo '<div id="error-alert" class="alert alert-danger">'.$error.'</div>';
                    }
                    if(empty($error)){
                        $sql = "SELECT * from Images where id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            echo "The game already exists";
                            header('Location: image-index.php');
                            exit();
                        } else {
                            $sqlCheck = "SELECT id FROM Games WHERE id = ?";
                            $stmtCheck = $conn->prepare($sqlCheck);
                            $stmtCheck->bind_param("i", $game_id);
                            $stmtCheck->execute();
                            $resultCheck = $stmtCheck->get_result();
                            if($resultCheck->num_rows > 0) {
                                $sqlCreate = "INSERT INTO Images (name, game_id, image) VALUES (?, ?, ?)";
                                $stmtCreate = $conn->prepare($sqlCreate);
                                $stmtCreate->bind_param("sis", $name, $game_id, $image);
                                if ($stmtCreate->execute()) {
                                    echo "<script>alert('Image is added successfully');</script>";
                                    header('Location: image-index.php');
                                    exit();
                                } else {
                                    echo "Error: " . $sqlCreate . "<br>" . $conn->error;
                                }
                                $stmtCreate->close();
                            }else {
                                echo "Invalid game ID";
                            }
                            $stmtCheck->close();
                        }
                        $stmt->close();
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-id'])) {
                    $id = intval($_POST['delete-id']);
                    $sql = "DELETE FROM Images WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        echo "<script>alert('Image is deleted ');</script>";
                        header('Location: image-index.php');
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
         $('#images-tbl').DataTable();
        });
    </script>
    <script>
        function previewImage(input) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = document.getElementById('image-preview');
                image.innerHTML = '<img src="' + e.target.result + '" class="image">';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('image').addEventListener('change', function() {
            previewImage(this);
        });

    </script>
<?php
    ob_end_flush();
?>
