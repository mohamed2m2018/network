<!--This Div shows all the posts of a specefic user  -->
<div>
    <?php 
    //function that takes user as a parameter and print all his posts 
     function posts($specefic_user){ 
        $specefic_user_posts=$specefic_user->getAllPosts();
        if(mysql_num_rows($specefic_user_posts))
            {
                echo " <h3> posts: </h3>";
                while ($post=mysql_fetch_assoc($specefic_user_posts)) 
                {
                //tool mnta btla2y 7ot   
                echo "<label> <h4> ".$post['post']." <h4></label>";
                }
            }
    }

    ?>  
</div>