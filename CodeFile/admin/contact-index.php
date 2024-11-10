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
                <div class="col-sm-1">

                </div>
                <div class="col-sm-10">
                    <br>
                    <h1>CRUD CONTACT</h1>
                    <div class="table-responsive">
                        <table id="contact-tbl" class="table table-striped table-borderd" style="width: 100%" shadow rounded bg-light>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * from contact ";
                                $result = $conn->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result -> fetch_assoc()){
                                        // $stmt->close();
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['address'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                                            <td>
                                                <button class="edit-btn btn btn-primary"><a style="color: white" href="editContact.php?id=<?php echo $row['id'] ?? '' ?>"><i class="fa-regular fa-pen-to-square"></i></a></button> <br>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="delete-id" value="<?php echo $row['id'] ?? ''; ?>">
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
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
                        $id = intval($_POST['id']);
                        $name = $_POST['name'];
                        $address = $_POST['address'];
                        $phone = $_POST['phone'];
                        $email = $_POST['email'];
                    
                        $sql = "SELECT * from Contact where id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            echo "Contact already exists";
                            header('Location: contact-index.php');
                            exit();
                        } else {
                            $sqlCreate = "INSERT INTO contact (name, address, phone, email) VALUES (?, ?, ?, ?)";
                            $stmtCreate = $conn->prepare($sqlCreate);
                            $stmtCreate->bind_param("ssss", $name, $address, $phone, $email);
                            if ($stmtCreate->execute()) {
                                echo "<script>alert('Contact is added successfully');</script>";
                                header('Location: contact-index.php');
                                exit();
                            } else {
                                echo "Error: " . $sqlCreate . "<br>" . $conn->error;
                            }
                            $stmtCreate->close();
                        }
                        $stmt->close();
                    }
                    
                ?>
                <form action="" method="post" shadow rounded bg-light>
                    <h2>Add New</h2>
                    <input type="hidden" name="id" required>
                
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                        <br>
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" placeholder="Enter address" required></textarea>
                        <br>
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone" required>
                        <br>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    <br>
                    <button type="submit" class="btn btn-primary">Add New</button>
                    <br><br>
                </form>
            </div>

        </div>

        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-id'])) {
                $id = intval($_POST['delete-id']);
                $sql = "DELETE FROM contact WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "<script>alert('Contact is deleted ');</script>";
                    header('Location: contact-index.php');
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
         $('#contact-tbl').DataTable();
        });
    </script>
<?php
    ob_end_flush();
    }
?>

