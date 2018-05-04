<?php
    session_start();     
    include 'partials/header.php';
?>
<html lang="en">
<head>
    <title>Friend Requests</title>
</head>
<body>
    <div>
        <h4>Friend Requests</h4>

        <?php
            $current_user_id=$current_user_info['id'];
            $query = mysql_query("SELECT * FROM friend_requests WHERE user_to='$current_user_id'");
            if(mysql_num_rows($query)==0){
                echo "You have no friend requests at this time!";
            }
            else {
                while($row = mysql_fetch_array($query)){
                    $user_from=$row['user_from'];
                    $user_from_obj = new User($user_from);
                    $user_from_profile_name=$user_from_obj->get('profile_name');
                    echo "<a href='$user_from_profile_name'>{$user_from_obj->get('first_name')}" . " " . "{$user_from_obj->get('last_name')}</a>" . " Sent you a request<br>";
                    
                    $user_from_friend_array = $user_from_obj->get('friend_array');

                    $current_user_id=$_SESSION['id'];

                    if(isset($_POST['accept_request' . $user_from])){
                        $add_friend_query = mysql_query("UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE id='$current_user_id'");
                        $add_friend_query = mysql_query("UPDATE users SET friend_array=CONCAT(friend_array, '$current_user_id,') WHERE id='$user_from'");                        
                        
                        $delete_query = mysql_query("DELETE from friend_requests WHERE user_to='$current_user_id' and user_from='$user_from'");
                        echo "You are now friends!";
                        header("Location: requests.php");
                    }
                    if(isset($_POST['ignore_request' . $user_from])){
                        $delete_query = mysql_query("DELETE from friend_requests WHERE user_to='$current_user_id' and user_from='$user_from'");
                        echo "Request Ignored";
                        header("Location: requests.php");
                    }
                    ?>
                    <form action="requests.php" method="POST">
                        <input type="submit" name="accept_request<?= $user_from; ?>" value="Accept">
                        <input type="submit" name="ignore_request<?= $user_from; ?>" value="Ignore">
                    </form>
                    <br><br>
                    <?php

                }
            }

        ?>
          
    </div>
</body>
</html>