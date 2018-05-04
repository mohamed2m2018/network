<?php
    session_start();     
    include 'partials/header.php';
    include 'partials/display_posts.php';
    include 'php/profile_handling.php';
?>
<html>
<head>
    <title>others profile</title>
    <link rel="stylesheet" type="text/css" href="styles/profile.css">
   </head>
<body>
<!--The structure that holds the info is: $profile_user_info-->
This is the profile of <?=$profile_user_info['first_name']?> <?=$profile_user_info['last_name']?>


<!--Add friend button-->

<form method="POST">
    <?php
        if($current_user->isMe($profile_user_info['id'])){ //If it is me
            echo "Welcome to your profile";
        }
        else if($current_user->isFriend($profile_user_info['id'])){ //If it is a friend
            echo '<input type="submit" name="remove_friend" value="Remove Friend"><br>';
        }
        else if($current_user->didReceiveRequest($profile_user_info['id'])){ //If it is a stranger
            echo '<input type="submit" name="respond_request" value="Respond to Friend Request"><br>';
        }
        else if($current_user->didSendRequest($profile_user_info['id'])){ //If it is a stranger
            echo '<input type="submit" name="" value="Request sent"><br>';
        }
        else if($_SESSION['id']!="admin") {
            echo '<input type="submit" name="add_friend" value="Add Friend"><br>';            
        }
    
    ?>
</form>


<?php
if($profile_user_info['education']!=NULL)
    {
        echo"<br>";
        echo 'his education is: '.$profile_user_info['education'];
    }
?>


<!--The place where the user posts appear-->
<div class="posts_area">
    <?php
        if($current_user->isMe($profile_user_info['id'])){ //If it is me
            echo "
            <!--The form where the user submits his new post-->
            <div>
                <form action='index.php' method='POST'>
                    <input type='text' placeholder='Wanna Change The World ?!' name='post_value'>
                    <input type='submit' value='Post' name='Post'>            
                </form>
            </div>
            ";
            $post=new Post($profile_user_info['id']);
            $post->loadMyPosts();
        }
        else if ($current_user->isFriend($profile_user_info['id'])||$_SESSION['id']=="admin"){ //If it is my friend
            $post=new Post($profile_user_info['id']);
            $post->loadMyPosts();
        }
        else { //If it is a stranger
            echo "<h2>Become friends with {$profile_user_info['first_name']} to see his/her posts!</h2>";
        }
        
    ?>
</div>




</body>
</html>