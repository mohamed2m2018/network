<!--This is the registeration and login page, the main page to which the user is directed when he is not signed in-->
<?php
    session_start();     
   // require 'php/db_init.php';
    require 'php/register_handling.php';
    require 'php/login_handling.php';  
    require 'php/admin_handling.php'; 
?>

<html lang="en">
    <head>
        <title>World Changers</title>
        <link rel="stylesheet" type="text/css" href="styles/register.css">
        <link href="https://fonts.googleapis.com/css?family=Hi+Melody" rel="stylesheet">
    </head>
    <body>
        <div class="reg_header">
            <div class="reg_header_logo"><a href="index.php">Change Makers</a></div>
        </div>
        <br>
        
        <div class="grid">

            <!--LOGIN PART-->
            <?php
                include 'partials/login.php';
            ?>

                       
            <!--REGISTRATION PART-->
            <div class="reg">
                <h2>I am a new user</h2>
                <form action="register.php" method="POST">
                    <input type="text" placeholder="First Name" name="reg_first_name"><br>
                    <input type="text" placeholder="Last Name" name="reg_last_name"><br>
                    <input type="email" placeholder="Email" name="reg_email"><br>
                    <input type="password" placeholder="Password" name="reg_password"><br>
                    <input type="password" placeholder="Password (again)" name="reg_password2"><br>
                    <input type="submit" value="Submit" name="reg_submit">
                    <br>
                    <?php
                        if(isset($reg_error)){
                            echo $reg_error;
                        }
                        if(isset($reg_success)){
                            echo $reg_success;
                        }
                    ?>
                </form>
            </div>
        </div>


    </body>
</html>