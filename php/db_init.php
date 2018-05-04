<?php
    mysql_connect("localhost", "root", "" );
    $connection = mysql_select_db("network");
    if(mysql_errno()){
        echo "Can't connect to the database";
    }
