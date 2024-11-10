
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Kiểm tra xem hàm file_get_contents có hoạt động hay không
    if (!ini_get('allow_url_fopen')) {
        die('Error: allow_url_fopen is disabled. Please enable it in php.ini.');
    }
    $ip_address=$_SERVER['REMOTE_ADDR'];
    /*Get user ip address details with geoplugin.net*/
    $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
    $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
    /*Get City name by return array*/
    $city = $addrDetailsArr['geoplugin_city'];
    /*Get Country name by return array*/
    $country = $addrDetailsArr['geoplugin_countryName'];
    /*Comment out these line to see all the posible details*/
    /*echo '<pre>';
    print_r($addrDetailsArr);
    die();*/
    if(!$city){
        $city='Not Define';
    }if(!$country){
        $country='Not Define';
    }
    echo '<strong>IP Address</strong>:- '.$ip_address.'<br/>';
    echo '<strong>City</strong>:- '.$city.'<br/>';
    echo '<strong>Country</strong>:- '.$country.'<br/>';

    include_once'./includes/header.php';
    if (isset($_GET['itinerary_id']) && is_numeric($_GET['itinerary_id']) && isset($_GET['location_id']) && is_numeric($_GET['location_id'])) {
        $itinerary_id = $_GET['itinerary_id'];
        $location_id = $_GET['location_id'];
        var_dump($itinerary_id, $location_id);
        if($location_id > 0){
            $sql = 'SELECT l.*, l.name as location_name, l.description as location_description,
                        l.latitude as location_latitude, l.longitude as location_longitude, l.geolocation as location_geolocation, l.avatar as location_avatar,
                        i.name as itinerary_name, g.name as game_name
                FROM Location as l
                INNER JOIN Itineraries as i on l.id = i.location_id
                INNER JOIN Games as g ON i.game_id = g.id
                WHERE l.id = ?; 
        ';
        }
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $location_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="row">
                            <div class="col-4">
                                <img src="./admin/<?php echo htmlspecialchars($row['location_avatar']); ?>" class="img-full-width card-img-top" alt="Avatar Location">
                            </div>
                            <div class="col-8">
                                <h2>
                                    <i class="fa fa-person-running nav-icon"></i>
                                    <?php echo htmlspecialchars($row['itinerary_name']); ?>
                                </h2>
                                <h3>
                                    <i class="fas fa-gamepad"></i>
                                    <?php echo htmlspecialchars($row['game_name']); ?>
                                </h3>
                                <span style="font-size: 16px;">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <?php echo htmlspecialchars($row['location_description']); ?>
                                </span>
                                <br>
                                <span style="font-size: 16px;">
                                    <i class="fa-solid fa-location-arrow"></i>
                                    Latitude: <?php echo htmlspecialchars($row['location_latitude']); ?>, Longitude: <?php echo htmlspecialchars($row['location_longitude']); ?>
                                </span>
                                <br>
                                <span style="font-size: 16px;">
                                    <i class="fa-solid fa-map-marker-alt"></i>
                                    Geolocation: <?php echo htmlspecialchars($row['location_geolocation']); ?>
                                </span>
                                <br>
                                <button class="btn btn-primary"><a href="itinerary-detail.php?id=<?php echo htmlspecialchars($itinerary_id); ?>"; style="color: white";>Go back</a></button>
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
    include_once'./includes/footer.php';
?>

