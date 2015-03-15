<?php include "base.php"; ?>

<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
    <h1>Edit Account Details</h1>
    <a href="account.php"> Account. </a>
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        $username = $_SESSION['Username'];
        $userinfo = mysqli_query($connection, "SELECT * FROM students WHERE username = '".$username."' ");
        $row = mysqli_fetch_array($userinfo);
        if(!empty($_POST['newusername'])) {
            $newusername = mysqli_real_escape_string($connection, $_POST['newusername']);
            $checkusername = mysqli_query($connection, "SELECT * FROM STUDENTS WHERE username = '".$newusername."'");
            if(mysqli_num_rows($checkusername) == 1)
                {
                    echo "<h1>Error</h1>";
                    echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
                }
                else {
            $updateusername = mysqli_query($connection, "UPDATE students SET username = '".$newusername."' WHERE username = '".$username."'");
            $_SESSION['Username'] = $newusername;
            $username = $_SESSION['Username'];
                echo "<p>Username changed.</p>";
                }
        }
        
        if(!empty($_POST['newfirstname'])) {
            $newfirstname = mysqli_real_escape_string($connection, $_POST['newfirstname']);
            $updatefirstname = mysqli_query($connection, "UPDATE students SET first_name = '".$newfirstname."' WHERE username = '".$username."'");
            echo "<p>First name updated.</p>";
        }
        if(!empty($_POST['newlastname'])) {
            $newlastname = mysqli_real_escape_string($connection, $_POST['newlastname']);
            $updatelastname = mysqli_query($connection, "UPDATE students SET last_name = '".$newlastname."' WHERE username = '".$username."'");
            echo "<p>Last name updated.</p>";
        }
        if(!empty($_POST['newpassword'])) {
            if(!empty($_POST['oldpassword'])) {
                $newpassword = md5(mysqli_real_escape_string($connection, $_POST['newpassword']));
                $oldpassword = md5(mysqli_real_escape_string($connection, $_POST['oldpassword']));
                $checkpassword = mysqli_query($connection, "SELECT * FROM students WHERE username = '".$username."' AND password = '".$oldpassword."'");
                if(mysqli_num_rows($checkpassword) == 1) {
                    $updatepassword = mysqli_query($connection, "UPDATE students SET password = '".$newpassword."' WHERE username = '".$username."'");
                    echo "<p>Password changed.</p>";
                } else { echo "<p>Old password incorrect.</p>"; };
            } else {echo "<p>Must enter old password.</p>"; };
        }
        
        
        ?>
    <form method="post" action="editaccount.php" name="accountform" id="accountform">
    <fieldset>
        <label for="username">Edit username:</label><input type="text" name="newusername" id="newusername" /><br />
        <label for="username">Edit first name:</label><input type="text" name="newfirstname" id="newfirstname" /><br />
        <label for="username">Edit last name:</label><input type="text" name="newlastname" id="newlastname" /><br />
        <label for="password">New password:</label><input type="password" name="newpassword" id="newpassword" /><br />
        <label for="password">Old password:</label><input type="password" name="oldpassword" id="oldpassword" /><br />
        <input type="submit" name="Submit" id="login" value="Submit" />
    </fieldset>
    </form>
        
        <?php
    }
    else
    {
        ?>
        <p> You have been logged out. <a href="index.php"> Login. </a> </p>
        <?php
    }
        ?>

    
    
    
















</div>
</body>
</html>