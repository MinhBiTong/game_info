<?php
    include_once'./includes/header.php';
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;
    $total_records_per_page = 4;
    $offset = ($page_no - 1) * $total_records_per_page;

    $count_sql = "SELECT COUNT(*) AS total_records
              FROM Itineraries as i
              INNER JOIN Location as l on i.location_id = l.id
              INNER JOIN Games as g on i.game_id = g.id
            ";

    $stmt = $conn->prepare($count_sql);
    $stmt->execute();
    $result_count = $stmt->get_result();
    $total_records = $result_count->fetch_array()['total_records'];
    $stmt->close();

    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2"; 

    $data_sql = "SELECT i.*, i.name as itinerary_name, g.image as game_image
             FROM Itineraries as i
             INNER JOIN Location as l on i.location_id = l.id
             INNER JOIN Games as g on i.game_id = g.id
             LIMIT ?, ?
             ";
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <?php
            if(isset($_POST['search'])){
                $searchdata = $_POST['searchdata'] ;
                $searchdata = "%" . $conn->real_escape_string($_POST['searchdata']) . "%";
                $search_sql = $conn->prepare("
                    SELECT i.*, i.name as itinerary_name, g.name, l.name, g.image as game_image
                    FROM Itineraries as i
                    INNER JOIN Location as l on i.location_id = l.id
                    INNER JOIN Games as g on i.game_id = g.id
                    WHERE i.name LIKE ? 
                    OR i.description LIKE ?
                    OR g.name LIKE ?
                    OR l.name LIKE ?
                ");
                $search_sql->bind_param('ssss', $searchdata, $searchdata, $searchdata, $searchdata);
                $search_sql->execute();
                $result_search = $search_sql->get_result();
                $num = $result_search->num_rows;
                if($num>0){
                    $count=1;
                    while ($row_search = $result_search->fetch_array()) {?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <a href="itinerary-detail.php?id=<?php echo htmlspecialchars($row_search['id']); ?>">
                                <div class="card custom-card">
                                    <img src="./admin/<?php echo htmlspecialchars($row_search['game_image']); ?>" class="img-full-width card-img-top" alt="Product Image">
                                    <div class="card-body text-center">
                                        <h2 class="card-title">
                                            <i class="fa fa-person-running nav-icon"></i>
                                            <?php echo htmlspecialchars($row_search['itinerary_name']); ?>
                                        </h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    <?php }
                    $count=$count+1;
                }else{
                    echo "No results found for your search.";
                }
                $search_sql->close();
            }  
            else{
                if ($stmt = $conn->prepare($data_sql)) {
                    $stmt->bind_param("ii", $offset, $total_records_per_page);
                    $stmt->execute();
                    $records_on_a_page = $stmt->get_result();
                    if ($records_on_a_page->num_rows > 0) {
                        $count = 0;
                        while ($row = $records_on_a_page->fetch_assoc()) {
                            if ($count > 0 && $count % 4 == 0) { 
                                echo '</div>
                                <div class="row">';
                            }
                            ?>
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="itinerary-detail.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                        <div class="card custom-card">
                                            <img src="./admin/<?php echo htmlspecialchars($row['game_image']); ?>"  class="img-full-width card-img-top" alt="Product 1">
                                            <div class="card-body text-center">
                                                <h2 class="card-title">
                                                    <i class="fa fa-person-running nav-icon"></i>
                                                    <?php echo htmlspecialchars($row['itinerary_name']);?>
                                                </h2>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            $count++;
                        }
                    } else {
                        echo "No records found.";
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>
        </div>
    </div>
    <?php
        include_once'./includes/pagination.php';
        pagination($page_no, $total_records, $total_records_per_page, "itinerary.php");
    ?>
   