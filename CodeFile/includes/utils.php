<?php
    session_start();
    function dd($var){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }

    function santize($val){
        return trim(stripslashes(htmlspecialchars($val)));
    }
?>