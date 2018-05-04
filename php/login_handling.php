<!--This is where we handle user login-->

<?php

    $log_error="";

    if(isset($_POST['log_submit'])){
        $log_email=$_POST['log_email'];
        $log_password=$_POST['log_password'];  
        $query_run= mysql_query( "SELECT * from users where email='$log_email' AND password='$log_password'");     
        $users=mysql_fetch_assoc($query_run);
        $num_users=mysql_num_rows($query_run);
        if($num_users==0){
            $log_error="The email or the password are incorrect";
        }
        else {
            $_SESSION['email']=$log_email;
            $_SESSION['id']=$users['id'];
            header("Location: index.php");
        }
    }