<?php
    if(isset($_POST['search'])){
        $searchdata = $_POST['searchdata'] ;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="">
        <input id="searchdata" type="text" name="searchdata" required="true" class="form-control">
        <button class="btn-primary btn" type="submit" name="search">Search</button>
    </form>
 
</body>
</html>