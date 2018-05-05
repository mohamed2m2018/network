<!--This is where we handle user login-->

<?php

$admin_error="";

if(isset($_POST['admin_submit'])){
    $admin_email=$_POST['admin_email'];
    $admin_password=$_POST['admin_password'];
    if($admin_email=="admin@gmail.com" && $admin_password=="root"){
        $_SESSION['email']=$admin_email;
        $_SESSION['id']='admin';
        header("Location: people.php");
        }
    else {
        $admin_error="The email or the password are incorrect";
    }
}
