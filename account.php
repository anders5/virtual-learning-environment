<?php include "base.php"; ?>

<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
    <h1>Your Account</h1>
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        
        $username = $_SESSION['Username'];
        $userinfo = mysqli_query($connection, "SELECT * FROM students WHERE username = '".$username."' ");
        $row = mysqli_fetch_array($userinfo);
        
        ?>
    <a href="editaccount.php"> Edit account. </a>
        <form action="./change.php" method="post"> 
            Username: <code><?=$_SESSION['Username']?></code> <br />
            First name: <code><?=$row['first_name']?></code> <br />
            Last name: <code><?=$row['last_name']?></code> <br />
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