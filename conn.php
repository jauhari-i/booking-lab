<?php
    date_default_timezone_set("Asia/Bangkok");
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "booking";

    $myDB = mysqli_connect($host,$user,$pass,$db_name);

    if(mysqli_connect_error($myDB))
    {
        echo "Errors While Connect to database";
    }

?>