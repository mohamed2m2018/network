<?php
class Post {
	public $owner_id;
	public $post_id;
	 public function __construct() {
	 	 $argv = func_get_args();
        if( func_num_args() ) {
        	switch (func_num_args()) {
        		case 1:
        			self::__construct1($argv[0]);
        			break;
        		
        		case 2:
        			self::__construct2($argv[0],$argv[1]);
        			break;
        	}
                
         }
         else
         {
        $this->owner_id='';
        $this->post_id='';
    	}
	}
   public function __construct1($id) {
        $this->owner_id=$id;
    }
    public function __construct2($id,$post_id) {
        $this->owner_id=$id;
        $this->post_id=$post_id;
    }
	public function get($columnName)//get one property of that post like num_likes or num_shares ...etc
	{
		$query="SELECT $columnName from posts where post_id='$this->post_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run['$columnName'];
	}
	public function getAll()//get all post info like ,post_id,owner_id,post,likes...etc
	{
		$query="SELECT * from posts where post_id='$this->post_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run;
	}
	public function update($columname,$value)//update a certain property in the post like num_likes,shares..etc
	{
		$query="UPDATE posts SET $columname = $value WHERE posts.post_id ='$this->post_id'";
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
	public function add($post_text)//add new post to the table posts
	{
		$date_added = date("Y-m-d H:i:s");
		$query="INSERT INTO posts (owner, post, date_added) VALUES ('$this->owner_id', '$post_text', '$date_added')";
		$query_run=mysql_query($query);
		//Increment the number of posts for the owner
		$owner_of_post=new User($this->owner_id);
		$num_posts=$owner_of_post->get("num_posts");
		$num_posts+=1;
		$owner_of_post->update("num_posts",$num_posts);
		if($query_run)
		{
			//here we successfully added the post so we need to get its id and save it in $this->post_id
			$post_data=mysql_fetch_assoc(mysql_query("SELECT post_id FROM posts WHERE owner=$this->owner_id"));
			$this->post_id=$post_data['post_id'];	
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function remove()//remove that post from the table 
	{
		$query="DELETE FROM posts WHERE post_id='$this->post_id'";
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
	public function remove1($id)//deleting a post from database according to a known post_id no matter if this post belongs to this user_id or not 
	{
		$query="DELETE FROM posts WHERE post_id='$id'";
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
	public function loadPostsFriends(){
        require 'comment.php';        
		$str = ""; //String to return
        $data=mysql_query("SELECT * FROM posts ORDER BY post_id DESC");
		while($row = mysql_fetch_assoc($data)){
            $id=$row['post_id'];
            $body=$row['post'];
            $added_by=$row['owner'];
            $date_time=$row['date_added'];          
            if(isset($_POST["delete{$id}"]))
               {
                $query="DELETE FROM posts WHERE post_id='$id'";
                $query_run=mysql_query($query);
                header("Refresh:0");
               }
            $user_logged_obj = new User($_SESSION['id']);
            if($user_logged_obj->isFriend($added_by) || $user_logged_obj->isMe($added_by)||$_SESSION['id']=="admin"){
            	$postComments_obj=new Comment($added_by,$id);
            	$comments=$postComments_obj->loadPostsComments();//returns an html string conains all comments of that post
                $user_details_query = mysql_query("SELECT first_name, last_name, profile_image, profile_name FROM users where id='$added_by'");
                $user_row=mysql_fetch_assoc($user_details_query);
                $first_name=$user_row['first_name'];
                $last_name=$user_row['last_name'];
                $profile_pic=$user_row['profile_image'];
                $profile_name=$user_row['profile_name'];
                //Timeframe
                $start_date = new DateTime($date_time); //Time of post
                $end_date = new DateTime("now"); //Current time
                $interval = $start_date->diff($end_date); //Difference bet dates
                if($interval->y>=1){
                    if($interval == 1)
                        $time_message = $interval->y . " year ago"; // 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // 1+ year ago                    
                }
                else if($interval->m>=1){
                    if($interval->d == 0){
                        $days = " ago";
                    }
                    else if($interval->d==1){
                        $days = $interval->d . " day ago";
                    }
                    else{
                        $days = $interval->d . " days ago";
                    }
                    if($interval-> m ==1){
                        $time_message = $interval->m . " month". $days;
                    }
                    else {
                        $time_message = $interval->m . " months". $days;
                    }
                }
                else if($interval->d>=1){
                    if($interval->d==1){
                        $time_message = "Yesterday";
                    }
                    else{
                        $time_message = $interval->d . " days ago";
                    }
                }
                else if($interval->h>=1){
                    if($interval->h==1){
                        $time_message = $interval->h . " hour ago";
                    }
                    else{
                        $time_message = $interval->h . " hours ago";
                    }
                }
                else if($interval->i>=1){
                    if($interval->i==1){
                        $time_message = $interval->i . " minutes ago";
                    }
                    else{
                        $time_message = $interval->i . " minutes ago";
                    }
                }
                else {
                    if($interval->h<30){
                        $time_message = "Just now";
                    }
                    else{
                        $time_message = $interval->s . " seconds ago";
                    }
                }
                if($_SESSION['id']!="admin")
                    $form_str="<form method='POST'>
                    <input type='text' placeholder='Add Comment' name='comment_value'>
                    <input type='submit' value='Comment' name='comment'>  
                    <input type='hidden' name='post_id' value='$id'>
                    </form>";
                else
                    $form_str="<form method='POST'>
                    <input class='delete_post_button' type='submit' value='Delete Post' name='delete{$id}'>  
                    <input type='hidden' name='post_id' value='$id'>
                    </form>";
                $str .= "<div class='status_post'>
                                <div class='post_profile_pic'>
                                    <img src='$profile_pic' width='50'>
                                </div>
                                <div class='posted_by' style='color:#ACACAC;'>
                                    <a href='$profile_name'>$first_name $last_name</a>&nbsp;&nbsp;&nbsp;&nbsp; $time_message
                                </div>
                                <div id='post_body'>
                                    $body
                                    <br>
                                </div>
                                ".$form_str."
                                <h4>Comments:</h4>
                                ".$comments."
                        </div>
                        
                ";
            }
        }
        if ($str==""){
            echo "<h3>There are no posts!</h3>";
        }
        else {
            echo $str;
        }
    }
    
    public function loadMyPosts(){
        require 'php/classes/Comment.php';
		$str = ""; //String to return
        $data=mysql_query("SELECT * FROM posts ORDER BY post_id DESC");
		while($row = mysql_fetch_assoc($data)){
            $id=$row['post_id'];
            $body=$row['post'];
            $added_by=$row['owner'];
            $date_time=$row['date_added'];          
           
            if(isset($_POST["delete{$id}"]))
               {
                $query="DELETE FROM posts WHERE post_id='$id'";
                $query_run=mysql_query($query);
                header("Refresh:0");
               }
            $user_logged_obj = new User($this->owner_id);
            if($user_logged_obj->isMe($added_by)){
            	$postComments_obj=new Comment($added_by,$id);
            	$comments=$postComments_obj->loadPostsComments();//returns an html string conains all comments of that post
                $user_details_query = mysql_query("SELECT first_name, last_name, profile_image, profile_name FROM users where id='$added_by'");
                $user_row=mysql_fetch_assoc($user_details_query);
                $first_name=$user_row['first_name'];
                $last_name=$user_row['last_name'];
                $profile_pic=$user_row['profile_image'];
                $profile_name=$user_row['profile_name'];
                //Timeframe
                $start_date = new DateTime($date_time); //Time of post
                $end_date = new DateTime("now"); //Current time
                $interval = $start_date->diff($end_date); //Difference bet dates
                if($interval->y>=1){
                    if($interval == 1)
                        $time_message = $interval->y . " year ago"; // 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // 1+ year ago                    
                }
                else if($interval->m>=1){
                    if($interval->d == 0){
                        $days = " ago";
                    }
                    else if($interval->d==1){
                        $days = $interval->d . " day ago";
                    }
                    else{
                        $days = $interval->d . " days ago";
                    }
                    if($interval-> m ==1){
                        $time_message = $interval->m . " month". $days;
                    }
                    else {
                        $time_message = $interval->m . " months". $days;
                    }
                }
                else if($interval->d>=1){
                    if($interval->d==1){
                        $time_message = "Yesterday";
                    }
                    else{
                        $time_message = $interval->d . " days ago";
                    }
                }
                else if($interval->h>=1){
                    if($interval->h==1){
                        $time_message = $interval->h . " hour ago";
                    }
                    else{
                        $time_message = $interval->d . " hours ago";
                    }
                }
                else if($interval->i>=1){
                    if($interval->i==1){
                        $time_message = $interval->i . " minutes ago";
                    }
                    else{
                        $time_message = $interval->i . " minutes ago";
                    }
                }
                else {
                    if($interval->h<30){
                        $time_message = "Just now";
                    }
                    else{
                        $time_message = $interval->d . " seconds ago";
                    }
                }
                if($_SESSION['id']!="admin")
                    $form_str="<form method='POST'>
                    <input type='text' placeholder='Add Comment' name='comment_value'>
                    <input type='submit' value='Comment' name='comment'>  
                    <input type='hidden' name='post_id' value='$id'>
                    </form>";
                else
                    $form_str="<form method='POST'>
                    <input type='text' placeholder='Add Comment' name='comment_value'>
                    <input type='submit' value='Delete' name='delete{$id}'>  
                    <input type='hidden' name='post_id' value='$id'>
                    </form>";    
                  
            
 						$str .= "<div class='status_post'>
                                <div class='post_profile_pic'>
                                    <img src='$profile_pic' width='50'>
                                </div>
                                <div class='posted_by' style='color:#ACACAC;'>
                                    <a href='$profile_name'>$first_name $last_name</a>&nbsp;&nbsp;&nbsp;&nbsp; $time_message
                                </div>
                                <div id='post_body'>
                                    $body
                                    <br>
                                </div>
                                ".$form_str."
                                <h4>Comments:</h4>
                                ".$comments."
                        </div>
                        
                ";
            }
        }
        if ($str==""){
            echo "<h3>There are no posts!</h3>";
        }
        else {
            echo $str;
        }
	}
}
?>
