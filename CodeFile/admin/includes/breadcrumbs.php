<?php
$breadcrumbs = array(
    'categories-index' => 'Category',
    'editCategories' => 'Edit Category',
    'contact-index' => 'Contact',
    'editContact' => 'Edit Contact',
    'itineraries-index' => 'Itinerary',
    'games-index' => 'Games',
    'editGames' => 'Edit Games',
);

$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
        <?php
        foreach ($breadcrumbs as $key => $value) {
            if ($key == $current_page) {
                echo '<li class="breadcrumb-item active" aria-current="page">' . $value . '</li>';
            } else {
                echo '<li class="breadcrumb-item"><a href="' . $key . '.php">' . $value . '</a></li>';
            }
        }
        ?>
    </ol>
</nav>
