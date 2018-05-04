<!--This is the profile of the user as others see it-->
<?php include 'php/profile_handling.php'; ?>
<html>
<head>
    <title>others profile</title>
    <link rel="stylesheet" type="text/css" href="styles/profile.css">
    <link href="https://fonts.googleapis.com/css?family=Hi+Melody" rel="stylesheet">
  
   </head>
<body>
<?php
    $the_other_user=new user('profile_name',$_GET['id']);
    $the_other_user_info=$the_other_user->getAll();//getting everything about this user based on his id in $user_id
    $the_other_user_posts=$the_other_user->getAllPosts();//getting an sql query of all posts that user have based on owner_id which is a column in the posts table that enabes us to know  which post is for whom
    if($_GET['id']!=$the_other_user_info['profile_name'])
    {
        echo ' No such user ';
        exit();
    }
    
?>


This is the profile of <?=$the_other_user_info['first_name']?> <?=$the_other_user_info['last_name']?>


<?php
if($current_user_info['education']!=NULL)
    {
        echo"<br>";
        echo 'his education is: '.$current_user_info['education'];
    }
 include 'partials/display_posts.php';
 posts($the_other_user);

?>


<!--form to log out-->
<form action="index.php" method="POST">
    <input type="submit" value="Log out" name="logout">            
</form>

</body>
</html>