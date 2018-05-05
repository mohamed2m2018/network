<?php
    session_start();
    include 'partials/header.php';
?>
<html lang="en">
<head>
    <title>Others</title>
    <style>body {text-align:center}</style>
</head>
<body>

<div>
        <h4>Our amazing other members in the community</h4>

        <?php
            $query = mysql_query("SELECT * FROM users");
            if(mysql_num_rows($query)==0){
                echo "There are no users!";
            }
            else {
                while($row = mysql_fetch_array($query)){
                    $user_id=$row['id'];
                    $user = new User($user_id);
                    if($_SESSION['email']=="admin@gmail.com")
                    {
                        if(isset($_POST[$user_id])){ //if we want to delete this particular user who has this id
                            $user = new User($user_id);
                            $user->remove($user_id); //remove this particular user
                            $user->removeUserPosts();
                            $user->removeUserComments();
                            $user->removeUserFriendRequests();
                            header("Location: people.php");
                        }   
                   
                    echo "
                    <a href={$user->get('profile_name')}>
                    <img src={$user->get('profile_image')}>
                    <h2>{$user->get('first_name')}" . " " . "{$user->get('last_name')}</h2>
                    </a>
                    <form action='people.php' method='POST'>
                    <input type='submit' name='$user_id' value='Delete User'>
                    <br>(His/her posts and comments will be deleted, too)  
                    <!--notice that the 'name' of the input is dynamic-->
                     </form>                    
                     <br><br>
                    ";
                   
                    } else if(!$current_user->isMe($user_id)) {
                    $user_id=$row['id'];
                    $user = new User($user_id);
                    echo "
                    <a href={$user->get('profile_name')}>
                    <img src={$user->get('profile_image')}>
                    <h2>{$user->get('first_name')}" . " " . "{$user->get('last_name')}</h2>
                    </a>
                    <br><br>
                    ";

                    }

                }
               
            }

        ?>
          
    </div>
    
</body>
</html>