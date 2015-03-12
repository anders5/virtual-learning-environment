<!DOCTYPE html>

 
<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<main>
    <?php


    require_once('init.php');
	$connection=db_connect();


if(!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = md5(mysqli_real_escape_string($connection, $_POST['password']));
    
     
     $checkusername = mysqli_query($connection, "SELECT * FROM students WHERE username = '".$username."'");
      
     if(mysqli_num_rows($checkusername) == 1)
     {
        echo "<h1>Error</h1>";
        echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
     }
     else
     {
        $registerquery = mysqli_query($connection, "INSERT INTO students (username, password) VALUES('".$username."', '".$password."')");
        if($registerquery)
        {
            echo "<h1>Success</h1>";
            echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
        }
        else
        {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }       
     }
}
else
{
    ?>
     
   <h1>Register</h1>
     
   <p>Please enter your details below to register.</p>
     
    <form method="post" action="register.php" name="registerform" id="registerform">
    <fieldset>
        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        
        <input type="submit" name="register" id="register" value="Register" />
    </fieldset>
    </form>
     
    <?php
}
?>
 
</main>
</body>
</html>