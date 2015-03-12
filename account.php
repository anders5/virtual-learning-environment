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
        <form action="./change.php" method="post"> 
        First name: <br />
        Last name:  <br />
        Username: <code><?=$_SESSION['Username']?></code> <br />
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