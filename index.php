<!DOCTYPE html>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<Title>Virtual Learning Environment</Title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
</head>  
<body>  
    <?php include "navbar.php"; ?>
<div id="main">
    
    <?php



    require_once('init.php');
    $connection=db_connect();
	

    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        ?>
        <!--allow user to access the main page-->
        <h1>Member Area</h1>
        <p> You are logged in as <code><?=$_SESSION['Username']?></code>.</p>
        <a href="logout.php">Logout</a>
        <?php
    }
    elseif(!empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = md5(mysqli_real_escape_string($connection, $_POST['password']));
        
     
        $checklogin = mysqli_query($connection, "SELECT * FROM students WHERE username = '".$username."' AND password = '".$password."'");
      
        if(mysqli_num_rows($checklogin) == 1)
        {
            $row = mysqli_fetch_array($checklogin);
            
         
            $_SESSION['Username'] = $username;
            $_SESSION['uid']=$row['id'];
			$_SESSION['gid']=$row['fk_group'];
			$_SESSION['admin']=$row['admin'];
            $_SESSION['LoggedIn'] = 1;
         
            echo "<h1>Success</h1>";
            echo "<p>We are now redirecting you to the member area.</p>";
            echo "<meta http-equiv='refresh' content='=2;account.php' />";
        }   
    else
    {
        echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
    }
}
    
    else
    {
    ?>
        
           <h1>Member Login</h1>
     
            <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
     
    <form method="post" action="index.php" name="loginform" id="loginform">
    <fieldset>
        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <input type="submit" name="login" id="login" value="Login" />
    </fieldset>
    </form>
     
   
        
        
        
        <?php
    }
    ?>

</main>
</body>
</html>
