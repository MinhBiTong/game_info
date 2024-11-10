<?php
    include_once'./includes/header.php';
    $images = [
        "https://th.bing.com/th/id/OIP.fxiaNM2Bd9jweGVcTGX5MAAAAA?rs=1&pid=ImgDetMain",
        "https://i.pinimg.com/736x/05/5f/ea/055fea426d77ea842d0b7be4f671be18.jpg",
        "https://www.clipartkey.com/mpngs/m/36-366710_pusheen-cat-clipart-planner-cute-baby-anime-fox.png",
        "https://th.bing.com/th/id/R.446fc59011336711838dc0e0685b0132?rik=RELlwwtgqNepMg&riu=http%3a%2f%2fgetdrawings.com%2fimage%2fkawaii-dog-drawing-61.jpg&ehk=miO%2f%2fPggFRCQcONYK0ss7eHjd53BZGN4xwSgoDQA6Ic%3d&risl=&pid=ImgRaw&r=0",
        "https://toigingiuvedep.vn/wp-content/uploads/2022/05/hinh-nen-ga-cute-de-thuong-nhat.jpg"
    ];
    include_once'./includes/header.php'
?>
<body>
    <br>
    <div>
        <b>Giới thiệu Thành Viên</b>
    </div>
    <p></p>
    <p></p>
    <br>
    <div class="container">
        <div class="text-wrapper">
            <?php
              $sql="SELECT username, email, phone FROM Users WHERE role = 'admin';";
              $stmt = $conn -> prepare($sql);
              $stmt->execute();
              $i = 0;
              $result = $stmt->get_result();

              if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                <div class="thong-tin-thanh-vien">
                    <div class="thong-tin">
                        <p><i>Name:</i> <?php echo htmlentities($row['username']); ?></p>
                        <p><i>Phone:</i> <?php echo htmlentities($row['phone']); ?></p>
                        <p><i>Email:</i> <?php echo htmlentities($row['email']); ?></p>
                    </div>
                    <div class="img">
                        <img src="<?php echo $images[$i++ % count($images)]; ?>" alt="Description of the image">
                    </div>
                </div>
            <?php }} ?>

        </div>
    </div>
<?php 
    include_once'./includes/footer.php' 
?>