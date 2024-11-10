<?php
    include_once'./includes/header.php';

    
?>
<body>
    <div>
        <?php
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
                if($id > 0){
                    $sql= 'SELECT i.*,i.name as itinerary_name, i.description as itinerary_description, l.*, l.name as location_name, g.name as game_name, im.image as game_images, g.image as game_image
                    FROM Itineraries as i
                    INNER JOIN Location as l on i.location_id = l.id
                    INNER JOIN Games as g on i.game_id = g.id
                    JOIN Images as im on g.id = im.game_id
                    WHERE i.id = ?';
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <div class="row">
                                        <div class="col-4">
                                            <span style="font-size: 16px;">
                                                 <!-- <i class="far fa-image"></i> -->
                                                 <img src="./admin/<?php echo htmlspecialchars($row['game_image']); ?>" style="height: 400; width:450px;" class="img-full-width" class="card-img-top" alt="Product 1">
                                             </span>
                                        </div>
                                        <div class="col-8">
                                            <h2>
                                                <i class="fa fa-person-running nav-icon"></i>
                                                <?php echo htmlspecialchars($row['itinerary_name']);?>
                                            </h2>
                                             
                                             <br>
                                             <h3>
                                                <i class="fas fa-gamepad"></i>
                                                <?php echo htmlspecialchars($row['game_name']);?>
                                             </h3>
                                             
                                             <br>
                                             <a href="location.php?itinerary_id=<?php echo htmlspecialchars($id); ?>&location_id=<?php echo htmlspecialchars($row['location_id']); ?>">
                                                <h3>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo htmlspecialchars($row['location_name']);?>
                                                </h3>
                                             </a>
                                             <br>
                                             <span style="font-size: 16px;">
                                                <i class="fa-solid fa-circle-info"></i>  
                                                <?php echo htmlspecialchars($row['itinerary_description']);?>
                                             </span>
                                             <br>
                                             <button class="btn btn-primary"><a href="itinerary.php" style="color: white;">Go back</a></button>
                                        </div>
                                </div>
                            <?php }
                        } else {
                            echo "No records found.";
                        }
                        $stmt->close();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }

                
            } else {
                echo "Invalid Itinery.";
            }
        ?>
    </div>
</body>
<?php
    include_once'./includes/footer.php'
?>
