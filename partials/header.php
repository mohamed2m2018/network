<!--This page is just a part of all the pages, except register.php-->
<?php
    
    require 'php/classes/User.php';
    

    //let's take user info from the database and put them in the $current_user_info variable
    //so this information will be available to any page that has the 'header' part
    //we will get this info using the '$_SESSION['id'] variable that we created when the login process succeeded
    $user_id=$_SESSION['id'];
    $current_user= new User($user_id);//creating an instance of this user so we can perfectly control its own data
    
    $current_user_info = $current_user->getAll();//getting everything about this user based on his id in $user_id
    $current_user_posts=$current_user->getAllPosts();//getting an sql query of all posts that user have based on owner_id which is a column in the posts table that enabes us to know  which post is for whom

    //Now, at any page that has the header, we can access these info:
    //$current_user_info['first_name'], $current_user_info['last_name'], $current_user_info['id'], $current_user_info['age'], $current_user_info['email']... etc (database column names)
?>

<link rel="stylesheet" type="text/css" href="styles/header.css">


<div class="header">
    
    <span class="header_logo"><a href="index.php">Change Makers</a></span>
    <span class="header_buttons"><a href=<?=$current_user_info['profile_name']?>>My Profile</a></span>
    <button class="friend_req_button"><a href="requests.php">Show my friend requests</a></button>
    <button class="people_button"><a href="people.php">Check other Change Makers</a></button>

    <!--form to log out-->
    <form action="index.php" method="POST">
        <input type="submit" value="Log out" name="logout">            
    </form>
    <br><br><br><br><br><br>
</div>