<?php include "base.php"; ?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">VLE</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
<?php
    if(!empty($_SESSION['LoggedIn'])) {
    ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$_SESSION['Username']?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="account.php">My Account</a></li>
            <li><a href="group.php">My Group</a></li>
            <li><a href="assessment.php">Create Assessment</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="ranking.php">Group Rankings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
<?php
    }
 ?>   
    
  </div><!-- /.container-fluid -->
</nav>