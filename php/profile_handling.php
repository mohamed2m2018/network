<?php
//Redirecting to the register page if the value isset($_SESSION['email']) is not set
//We set that value when the login is successful
// this is just typical to index_handling.php 

require 'php/classes/Post.php';


if(!isset($_SESSION['email'])){
	header("Location: register.php");
}

 if(isset($_POST['logout'])){
    session_destroy();
	header("Location: register.php");
}



$profile_user=new user('profile_name',$_GET['profile_name']);
$profile_user_info=$profile_user->getAll();//getting everything about this user based on his id in $user_id
//$profile_user_posts=$profile_user->getAllPosts();//getting an sql query of all posts that user have based on owner_id which is a column in the posts table that enabes us to know  which post is for whom
if($_GET['profile_name']!=$profile_user_info['profile_name'])
{
	echo ' No such user ';
	exit();
}

if(isset($_POST['remove_friend'])){
	$user= new User($current_user_info['id']);
	$user->removeFriend($profile_user_info['id']);
}

if(isset($_POST['add_friend'])){
	$user= new User($current_user_info['id']);
	$user->sendRequest($profile_user_info['id']);
}

if(isset($_POST['respond_request'])){
	header("Location: requests.php");
}