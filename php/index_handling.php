<?php
//Redirecting to the register page if the value isset($_SESSION['email']) is not set
//We set that value when the login is successful
require 'php/classes/Post.php';
if(!isset($_SESSION['email'])){
    header("Location: register.php");    
}
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: register.php");
}
if(isset($_POST['Post']))
{
	//Create a new post in the table posts
	$new_post=new Post($current_user_info['id']);
	$new_post->add($_POST['post_value']);
	//refresh user posts query in the header page 
	$current_user_posts=$current_user->getAllPosts();
	//refresh the page to view the posts
	header("Location: index.php");
}
if(isset($_POST['comment']))
{
	$post_id=$_POST['post_id'];
	$user_id=$_SESSION['id'];
	$newComment=new Comment($user_id,$post_id);
	$newComment->add($_POST['comment_value']);
	//refresh the page to view new comments
	header("Location: index.php");
}
