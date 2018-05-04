<!--This is where we handle user registration-->

<?php
require 'php/classes/user.php';
$reg_error="";
$reg_success="";

if(isset($_POST['reg_submit'])){
    $user_data= array();
    $i=0;
    foreach ($_POST as $key => $value) {
        $user_data[$i]=$value;
        $i++;
    }
 //   print_r($user_data);
    
  /*  $reg_first_name = $_POST['reg_first_name'];
    $reg_last_name = $_POST['reg_last_name'];
    $reg_email = $_POST['reg_email'];
    */

    $reg_password = $user_data[3]; 
    $reg_password2 = $user_data[4];
    
    if($reg_password!=$reg_password2){
        $reg_error="Passwords should be the same!";
    }
    else {
        $new_user= new user();
        $created=$new_user->add($user_data);    
        if($created)
        {
             $reg_error="";
             $reg_success=" \n Congratulations, you can sign in now";
        }
         else
         {
            echo $created ;
             $reg_error=" \n Error.. We can not add this user try again";
         }
       
       
    }
}