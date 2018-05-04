<!--This page is just a part of the register page-->

<div class="log">
    <h2>I have an account</h2>
    <form action="register.php" method="POST">
        <input type="email" placeholder="Email" name="log_email">
        <input type="password" placeholder="Password" name="log_password">
        <input type="submit" value="Enter" name="log_submit">
        <?php
            if(isset($log_error)){
                echo $log_error;
            }
        ?>
    </form>
</div>