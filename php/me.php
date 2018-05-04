<!--This is the profile of the user as he sees it-->
<?php include 'php/profile_handling.php'; ?>
<html lang="en">
    <head>
        <title>My profile</title>
        <link rel="stylesheet" type="text/css" href="styles/profile.css">
        <link href="https://fonts.googleapis.com/css?family=Hi+Melody" rel="stylesheet">
  
    </head>
    <body>

        This is your profile Mr. <?=$current_user_info['first_name']?> <?=$current_user_info['last_name']?>
       
        <!--The form where the user submits his new post inside his profile-->
        <form action="profile.php" method="POST">
                <input type="text" placeholder="Wanna Change The World ?!" name="post_value">
            <input type="submit" value="Post" name="Post">            
        </form> 
       
        <?php



        if($current_user_info['education']==NULL)
            {
            echo 'please fill your education information ';
            echo '<br>'; 
            echo'<form action="profile.php" method="POST">
            <input type="text" placeholder="your education" name="education_value">
            <input type="submit" value="Post" name="education_submit">            
            </form> ';  
            if(isset($_POST['education_value']))
                {
                $education_value=$_POST['education_value'];       
                $query = "UPDATE users set education='$education_value' WHERE id='$user_id'";
                $right=mysql_query($query); 
                if($right) 
                echo 'your education is submitted sucessefully! ';
                }  
                else{
                    echo 'Something went terribly wrong! ';
  
                }            
        }else{
            echo 'you education is: '.$current_user_info['education'];

        }
            include 'partials/display_posts.php';
            //calling the function defined in the included file above
            posts($current_user);
            

        ?>
<!--form to log out-->
        <form action="index.php" method="POST">
            <input type="submit" value="Log out" name="logout">            
        </form>  
    </body>
</html>