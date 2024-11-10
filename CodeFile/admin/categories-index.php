<?php
     if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
     }else{
    ob_start();
    
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
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <br>
                    <h1>CRUD CATEGORY</h1>
                    <div class="table-responsive">
                        <table id="categories-tbl" class="table table-striped table-borderd" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * from categories ";
                                $result = $conn->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result -> fetch_assoc()){
                                        // $stmt->close();
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                                            <td>
                                                <button class="edit-btn btn btn-primary"><a style="color: white" href="editCategories.php?id=<?php echo $row['id'] ?>"><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></a></button> <br>
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
            </div>
            <div class="form-container">
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['type'])) {
                    $id = intval($_POST['id']);
                    $type = $_POST['type'];
                    $name = $_POST['name'];
                
                    $sql = "SELECT * from categories where id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        echo "<script>alert('The product already exists');</script>";
                        header('Location: categories-index.php');
                        exit();
                    } else {
                        $sqlCreate = "INSERT INTO categories (type, name) VALUES (?, ?)";
                        $stmtCreate = $conn->prepare($sqlCreate);
                        $stmtCreate->bind_param("ss", $type, $name);
                        if ($stmtCreate->execute()) {
                            echo "<script>alert('Category is added successfully');</script>";
                            header('Location: categories-index.php');
                            exit();
                        } else {
                            echo "Error: " . $sqlCreate . "<br>" . $conn->error;
                        }
                        $stmtCreate->close();
                    }
                    $stmt->close();
                }
                
            ?>
                 <form action="" method="post" id="form-cate" class=" shadow rounded bg-light">
                        <h2 class="mb-4">Add new</h2>
                        <input type="hidden" name="id" required>
                        <br>
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="Indoor Game">Indoor Game</option>
                            <option value="Outdoor Game">Outdoor Game</option>
                            <option value="Kids Game">Kids Game</option>
                            <option value="Male Game">Male Game</option>
                            <option value="Female Game">Female Game</option>
                            <option value="Family Game">Family Game</option>
                        </select>
                        <br>
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" placeholder="Enter name" required class="form-control">
                        <br>
                    <button type="submit" id="btn-add" class="btn btn-primary">Add new</button>
                    <br>
                    <br>
                </form>
        </div>
        </div>
        
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-id'])) {
                $id = intval($_POST['delete-id']);
                $sql = "DELETE FROM categories WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "<script>alert('Category is deleted ');</script>";
                    header('Location: categories-index.php');
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        ?>
    </main>
    <?php include_once('includes/footer.php'); ?>
</body>
    <script>
        // new DataTable('#categories-tbl');
        $(document).ready(function() {
         $('#categories-tbl').DataTable();
        });
    </script>
<?php
    ob_end_flush();
     }
?>

