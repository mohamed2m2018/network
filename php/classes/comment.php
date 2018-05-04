<?php
class Comment {
	public $owner_id;
	public $post_id;
	public $comment_id;
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
        		case 3:
        			self::__construct3($argv[0],$argv[1]);
        			break;
        	}
                
         }
         else
         {
        $this->owner_id='';
        $this->post_id='';
        $this->comment_id='';
    	}
	}
   public function __construct1($id) {
        $this->owner_id=$id;
    }
    public function __construct2($id,$post_id) {
        $this->owner_id=$id;
        $this->post_id=$post_id;
    }
    public function __construct3($id,$post_id,$comment_id) {
        $this->owner_id=$id;
        $this->post_id=$post_id;
        $this->comment_id=$comment_id;
    }
    	public function get($columnName)//get one property of that comment like num_likes or num_shares ...etc
	{
		$query="SELECT $columnName from comments where comment_id='$this->comment_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run['$columnName'];
	}
	public function getAll()//get all comment info like ,post_id,owner_id,comment,likes...etc
	{
		$query="SELECT * from comments where comment_id='$this->post_id'";
		$query_run=mysql_fetch_assoc(mysql_query($query));
		return $query_run;
	}
	public function update($columname,$value)//update a certain property in the post like num_likes,shares..etc
	{
		$query="UPDATE comments SET $columname = $value WHERE comments.comment_id ='$this->comment_id'";
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
	public function add($comment_text)//add new post to the table posts
	{
		$date_added = date("Y-m-d H:i:s");
		$query="INSERT INTO comments (owner, post_id , comment, date_added) VALUES ('$this->owner_id',$this->post_id, '$comment_text', '$date_added')";
		$query_run=mysql_query($query);
		if($query_run)
		{
			//here we successfully added the comment so we need to get its id and save it in $this->comment_id
			$comment_data=mysql_fetch_assoc(mysql_query("SELECT comment_id FROM comments WHERE owner=$this->owner_id AND post_id=$this->post_id"));
			$this->comment_id=$comment_data['comment_id'];	
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function remove()//remove that post from the table 
	{
		$query="DELETE FROM comments WHERE comment_id='$this->comment_id'";
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
	public function remove1($id)//deleting a comment from database according to a known comment_id no matter if this comment belongs to this user_id or not 
	{
		$query="DELETE FROM comments WHERE comment_id='$id'";
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
public function loadPostsComments(){
		$str = ""; //String to return
        $data=mysql_query("SELECT * FROM comments WHERE comments.post_id=$this->post_id ORDER BY post_id DESC");
		while($row = mysql_fetch_assoc($data)){
            $id=$row['comment_id'];
            $body=$row['comment'];
            $added_by=$row['owner'];
            $date_time=$row['date_added'];          
            
            
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
                
                $str .= "<span>
                              <a href='$profile_name'>$first_name $last_name</a>: $body
                              <br>
                              &nbsp;&nbsp;&nbsp;&nbsp; ($time_message)
                         </span>
                        <br>
                ";
           
        }
        if($str==""){
            return "No comments";
        }
        else {
            return $str;
        }
        
    }
}
?>
