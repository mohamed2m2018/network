<?php
require 'php/db_init.php';
class User {
	public $user_id='';
	 public function __construct() {
	 	 $argv = func_get_args();
        if( func_num_args()==1 ) {
                self::__construct1($argv[0]);
		 }
		 
		elseif(func_num_args()==2)
		{
			self::__construct2($argv[0],$argv[1]);

		}
	 
         else
         {
        $this->user_id='';
    	}
}
   // to construct an object using user's id
   public function __construct1($id) {
	 	$this->user_id=$id;
	 
	}
   /* to construct an object using any information about him 
	 it will be useful in case you want to search for another user
	 and you don't have his id ,but you have a certain
	 information about him
   */ 

	public function __construct2($field_in_user_table,$value ) {
		$query="SELECT id from users where $field_in_user_table ='$value'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		if($query_run)
		$this->user_id=$query_run["id"];	
		else
		{
		echo 'No such user has been found !!';
		exit();
		}
	}
		
	
	public function get($columnName)
	{
		$query="SELECT $columnName from users where id='$this->user_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run[$columnName];
	}
	public function getAll()
	{
		$query="SELECT * FROM users where id='$this->user_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run;
	}
	public function getAllPosts()
	{
		$query="SELECT * FROM posts where owner='$this->user_id'";
		$query_run=mysql_query($query);
		return $query_run;
	}
	public function update($columname,$value)
	{
		$query="UPDATE users SET $columname = $value WHERE users.id ='$this->user_id'";
		$query_run=mysql_query($query);
		if($query_run)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function add($user_info)
	{
		$query="INSERT INTO users (id, first_name, last_name, email, password, age, num_posts, num_likes,profile_name,education,profile_image, friend_array) VALUES (NULL, '$user_info[0]', '$user_info[1]', '$user_info[2]', '$user_info[3]', '$user_info[4]', NULL, NULL,NULL,NULL,NULL, ',')";
		$query_run=mysql_query($query);
		if($query_run)
		{
			$query="SELECT id from users where email='$user_info[2]'";
			$query_run=mysql_fetch_assoc(mysql_query($query));
			$this->user_id=$query_run['id'];
			// the part below is to add the profile name to the data base
			//profile name should be like firstname.id
			$query="SELECT first_name from users where email='$user_info[2]'";
			$query_run=mysql_fetch_assoc(mysql_query($query));
			$first_name=strtolower($query_run['first_name']);

			//Setting profile_name
			$query="UPDATE users SET profile_name = '$first_name$this->user_id' WHERE id ='$this->user_id'";
			mysql_query($query);

			//Setting profile image
			$rand=rand(1,16);
			$profile_image="assets/images/profile_pics/defaults/{$rand}.png";

			$query="UPDATE users SET profile_image = '$profile_image' WHERE id ='$this->user_id'";
			mysql_query($query);

			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function remove($id)
	{
		$query="DELETE FROM `users` WHERE id='$id'";
		$query_run=mysql_query($query);
		if($query_run)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function remove1()
	{
		$query="DELETE FROM `users` WHERE id='$this->user_id'";
		$query_run=mysql_query($query);
		if($query_run)
		{
			
			return 1;
		}
		else
		{
			
			return 0;
		}
	}

	public function isFriend($id_to_check){
		$idComma = "," . $id_to_check . ",";

		$query="SELECT friend_array from users where id='$this->user_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		$friend_array = $query_run['friend_array'];

        if((strstr($friend_array, $idComma) /*|| $id_to_check==$this->user_id*/)) {
            return true;
        }
        else {
            return false;
        }
	}
	
	public function isMe($id_to_check) {
		if($id_to_check==$this->user_id){
			return true;
		}
		else {
			return false;
		}
	}

	public function didReceiveRequest($user_from){
		$user_to = $this->user_id;
		$query="SELECT * from friend_requests WHERE user_to='$user_to' AND user_from='$user_from'";
		$check_request_query=mysql_query($query);
		if(mysql_num_rows($check_request_query)>0){ //a request received from this person exists
			return true;
		}
		else {	//a request received from this person doesn't exist
			return false;
		}
	}

	public function didSendRequest($user_to){
		$user_from = $this->user_id;
		$query="SELECT * from friend_requests WHERE user_to='$user_to' AND user_from='$user_from'";
		$check_request_query=mysql_query($query);
		if(mysql_num_rows($check_request_query)>0){ //a request send to this person exists
			return true;
		}
		else {	//a request sent to this person doesn't exist
			return false;
		}
	}

	public function removeFriend($user_to_remove){
		$current_user_id=$_SESSION['id'];
		$query= mysql_query("SELECT friend_array from users WHERE id='$current_user_id'");
		$row = mysql_fetch_array($query);
		$friend_array_username=$row['friend_array'];

		$user_id=$_SESSION['id'];
    	$current_user= new User($current_user_id);
		$current_user_friend_array = $current_user->get('friend_array');

		$that_user_id=$user_to_remove;
    	$that_user= new User($that_user_id);
		$that_user_friend_array = $that_user->get('friend_array');

		$new_friend_array = str_replace($user_to_remove . ',', "", $current_user_friend_array);
		$remove_friend = mysql_query("UPDATE users SET friend_array = '$new_friend_array' WHERE id=$current_user_id");

		$new_friend_array = str_replace($current_user_id . ',', "", $that_user_friend_array);
		$remove_friend = mysql_query("UPDATE users SET friend_array = '$new_friend_array' WHERE id=$user_to_remove");
	}


	public function sendRequest($user_to){
		$current_user_id=$_SESSION['id'];
		$query= mysql_query("INSERT INTO friend_requests VALUES('', '$user_to', '$current_user_id')");
	}

	public function removeUserPosts(){
		require 'php/classes/post.php';		
		$post=new Post();
		$query = mysql_query("SELECT * FROM posts WHERE owner=$this->user_id");
		while($row = mysql_fetch_array($query)){
			$post->remove1($row['post_id']);
		}
	}

	public function removeUserComments(){
		require 'php/classes/comment.php';		
		$comment=new Comment();
		$query = mysql_query("SELECT * FROM comments WHERE owner=$this->user_id");
		while($row = mysql_fetch_array($query)){
			$comment->remove1($row['comment_id']);
		}
	}

	public function removeUserFriendRequests(){
		$query = mysql_query("SELECT * FROM friend_requests WHERE user_from=$this->user_id");
		while($row = mysql_fetch_array($query)){
			$id=$row['id'];
			$query_remove=mysql_query("DELETE FROM friend_requests WHERE id='$id'");
		}
	}

}


/*
this is user class 
class methodes
1.get(string anything_about_the_user)
2.update(columnName,value)
3.add(array user_info)
4.remove(user_id)
5.getAll()
6.getAllPosts()
*/