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
            <div class="col-sm-12">
                <br>
                <h1>CRUD LOCATION</h1>
                <div class="table-responsive">
                    <table id="location-tbl" class="table table-striped table-borderd" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Geolocation</th>
                                <th>Avatar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * from Location";
                            $result = $conn->query($sql);
                            if($result -> num_rows > 0){
                                while($row = $result -> fetch_assoc()){
                                    // $stmt->close();
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['latitude']); ?></td>
                                        <td><?php echo htmlspecialchars($row['longitude']); ?></td>
                                        <td><?php echo htmlspecialchars($row['geolocation']); ?></td>
                                        <td>
                                            <?php 
                                            if (!empty($row['avatar'])) {
                                                echo '<img src="' . htmlspecialchars($row['avatar']) . '" alt="Avatar" style="width: 50px; height: 50px;">';
                                            } else {
                                                echo 'No avatar';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="edit-btn btn btn-primary"><a style="color: white" href="editLocation.php?id=<?php echo $row['id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button> <br>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete-id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="delete-btn btn btn-danger" onclick="return confirm('Do you really want to Delete ?');"></a><i class="fa-solid fa-trash"></i></button>
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
        </div>
        <div class="form-container">
            <?php

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                    $id = intval($_POST['id']);
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $latitude = $_POST['latitude'];
                    $longitude = $_POST['longitude'];
                    $geolocation = $_POST['geolocation'];
                    $avatar = "";

                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                        $target_dir = "uploads/";
                        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
                        $avatarFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $avatarFileSize = $_FILES['avatar']['size'];
                        $allowed_types = ['png', 'gif', 'jpeg', 'jpg', 'webp', 'svg'];
                        if (!in_array($avatarFileType, $allowed_types)) {
                            $error .= "Sorry, only PNG, GIF, JPEG, JPG, WEBP, SVG files are allowed for avatar.";
                        }
                        if ($avatarFileSize > 6 * 1024 * 1024) { 
                            echo $error .= 'This upload file is larger than 6MB.';
                        }
                        if (empty($error)) {
                            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                                $avatar = $target_file; 
                            } else {
                                $error = 'Error uploading file.';
                                // $avatar = null;
                            }
                        }

                    } 
                    if($error){
                        echo '<div id="error-alert" class="alert alert-danger">'. $error. '</div>';
                    }
                    
                    if(empty($error)){
                        $sql = "SELECT * from Location where id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            echo "The location already exists";
                            header('Location: location-index.php');
                            exit();
                        } else {
                            $sqlCreate = "INSERT INTO Location (name, description, latitude, longitude, geolocation, avatar) VALUES ( ?, ?, ?, ?, ?, ?)";
                            $stmtCreate = $conn->prepare($sqlCreate);
                            $stmtCreate->bind_param("ssiiss", $name, $description, $latitude, $longitude, $geolocation, $avatar);
                            if ($stmtCreate->execute()) {
                                echo "<script>alert('Location is added successfully');</script>";
                                header('Location: location-index.php');
                                exit();
                            } else {
                                echo "Error: " . $sqlCreate . "<br>" . $conn->error;
                            }
                            $stmtCreate->close();
                        }
                        $stmt->close();
                    }
                    if (!empty($error)) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                    
                }else{
                    $avatar = '';
                }
                // if(isset($_POST['submit'])){
                //     $name = $_POST['name'];
                //     $description = $_POST['description'];
                //     $latitude = $_POST['latitude'];
                //     $longitude = $_POST['longitude'];
                //     $geolocation = $_POST['geolocation'];
                //     $avatar = $_POST['avatar']['name'];
                //     $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
                //     $allowed_extensions = array(".jpg","jpeg",".png",".gif");
                //     if(!in_array($extension,$allowed_extensions)){
                //         echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
                //     }else{
                //         $avatarnewfile = md5($avatar).$extension;
                //         move_uploaded_file($_FILES["avatar"]["tmp_name"],"uploadeddata/".$avatarnewfile);
                //     }
                // }
                
            ?>
            <form id="form-location" action="" method="post" enctype="multipart/form-data" shadow rounded bg-light>
                <h2>Add new</h2>    
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="id" name="id" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                </div>
                <br>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                </div>
                <br>
                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude" required>
                </div>
                <br>
                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude" required>
                </div>
                <br>
                <div class="mb-3">
                    <label for="geolocation" class="form-label">Geolocation</label>
                    <input type="text" class="form-control" id="geolocation" name="geolocation" placeholder="Enter geolocation" required>
                </div>
                <br>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*"><br>
                    <div id="avatar-preview"></div>
                    <span style="color:red; font-size:12px;">Only PNG, GIF, JPEG, JPG, WEBP, SVG format allowed.</span>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Add New</button>
                <br><br>
            </form>
        </div>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-id'])) {
                    $id = intval($_POST['delete-id']);
                    $sql = "DELETE FROM Location WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        echo "<script>alert('Location is deleted ');</script>";
                        header('Location: location-index.php');
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
         $('#location-tbl').DataTable();
        });
    </script>
    <script>
        function previewAvatar(input){
            var reader = new FileReader();
            reader.onload = function(e) {
                var avatarPreview = document.getElementById('avatar-preview');
                avatarPreview.innerHTML = '<img src="' + e.target.result + '" class="avatar" style="width: 150px; height: 150px">';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('avatar').addEventListener('change', function() {
            previewAvatar(this);
        });
    </script>
<?php
    ob_end_flush();
?>



