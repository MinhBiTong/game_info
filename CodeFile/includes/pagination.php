<?php

    function pagination($page_no, $total_records, $total_records_per_page, $base_url) {
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";

        echo "<div style='margin: 0 auto;padding-top: 15px;; border-top: dotted 1px #CCC;'>";
        echo "<strong>Page $page_no of $total_no_of_pages</strong>";
        echo "</div>";

        echo "<ul class='pagination' style='padding-left:80%'>";
        if ($page_no <= 1) {
            echo "<li class='disabled'><a>Previous</a></li>";
        } else {
            echo "<li><a href='$base_url?page_no=$previous_page' style='margin:6px'>Previous</a></li>";
        }

        if ($total_no_of_pages <= 10) {
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                    echo "<li class='active'><a>$counter</a></li>";
                } else {
                    echo "<li><a href='$base_url?page_no=$counter'>$counter</a></li>";
                }
            }
        } elseif ($total_no_of_pages > 10) {
            if ($page_no <= 4) {
                for ($counter = 1; $counter < 8; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                    } else {
                        echo "<li><a href='$base_url?page_no=$counter'>$counter</a></li>";
                    }
                }
                echo "<li><a>...</a></li>";
                echo "<li><a href='$base_url?page_no=$second_last'>$second_last</a></li>";
                echo "<li><a href='$base_url?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                echo "<li><a href='$base_url?page_no=1'>1</a></li>";
                echo "<li><a href='$base_url?page_no=2'>2</a></li>";
                echo "<li><a>...</a></li>";
                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                    } else {
                        echo "<li><a href='$base_url?page_no=$counter'>$counter</a></li>";
                    }
                }
                echo "<li><a>...</a></li>";
                echo "<li><a href='$base_url?page_no=$second_last'>$second_last</a></li>";
                echo "<li><a href='$base_url?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            } else {
                echo "<li><a href='$base_url?page_no=1'>1</a></li>";
                echo "<li><a href='$base_url?page_no=2'>2</a></li>";
                echo "<li><a>...</a></li>";
                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                    } else {
                        echo "<li><a href='$base_url?page_no=$counter'>$counter</a></li>";
                    }
                }
            }
        }

        if ($page_no >= $total_no_of_pages) {
            echo "<li class='disabled'><a>Next</a></li>";
        } else {
            echo "<li><a href='$base_url?page_no=$next_page' style='margin:6px'>Next</a></li>";
        }

        if ($page_no < $total_no_of_pages) {
            echo "<li><a href='$base_url?page_no=$total_no_of_pages' style='margin:6px'>Last &rsaquo;&rsaquo;</a></li>";
        }

        echo "</ul>";
    }
?>
