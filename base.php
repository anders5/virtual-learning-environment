<?php

require_once("init.php");

  
    $host = "eu-cdbr-azure-north-b.cloudapp.net";
    $user = "b71a879e88f712";
    $pwd = "6c9071b0";
    $db = "vledatabase";
    // Connect to database.
    $connection = mysqli_connect($host,$user,$pwd,$db) or die("MySQL Error: " . mysql_error());
    
    ?>

