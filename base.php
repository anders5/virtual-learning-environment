<?php

require_once("init.php");

  
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "virtual_learning_environment";
    // Connect to database.
    $connection = mysqli_connect($host,$user,$pwd,$db) or die("MySQL Error: " . mysql_error());
    
    ?>

