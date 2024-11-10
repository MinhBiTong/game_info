<?php
    include_once'./includes/header.php';

    
?>
<body>
    <div class="container">
    <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            if($id > 0){
                $sql= 'SELECT i.*,i.name as itinerary_name, i.description as itinerary_description, l.*, l.name as location_name, g.name as game_name, im.image as game_images, g.image as game_image
                FROM Games as g
                INNER JOIN Itineraries as i on g.id = i.game_id
                INNER JOIN Location as l on i.location_id = l.id
                INNER JOIN Categories as c on g.id_category = c.id
                INNER JOIN Images as im on g.id = im.game_id
                WHERE i.id = ?';
                if($stmt = $conn -> prepare($sql)){
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){?>

                        <?php }
                    }
                    
                }
            }
        }

        $file_path = '../admin/uploads/';

        if (file_exists($file_path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Content-Length: ' . filesize($file_path));

            // Read and output the file content
            readfile($file_path);
        } else {
            echo "File not found.";
        }
    ?>
    </div>
    <a href=""
        download="logo">
        <div id="download">Download Video</div>
    </a>
    <img src="" alt="File review" style="height:100px; width:300px">
</body>
<?php
    include_once'./includes/header.php';
?>


