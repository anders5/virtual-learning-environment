<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta charset="utf-8">
	<title>Report upload</title>
	<?php
	require_once("init.php");
	$connection=db_connect();
	$gid=$_SESSION['gid'];
	?>
</head>
<body>
    <div id="main">
	<?php
	$query ="SELECT name FROM groups where id=$gid";
	$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
	$row=mysqli_fetch_array($result);
	$gname=$row['name'];
	?>
	<header>
	<h1><?php echo "$gname's Report Upload"?></h1>
	<?php require_once('navbar.php'); ?>
	</header>
	<main>
			<article>
				<h2>Upload your report here:</h2>
				<!-- remember to set file_uploads = On on php.ini -->
				<form action="upload_result.php" method='POST' enctype="multipart/form-data">
					<i>Only PDF files are allowed. Max size: 64mb.</i><br />
					<input type=file name="report" id="report" accept=".pdf"> <br />
					<input type="submit" value="Upload" />
				</form>
			</article>
			
			<aside>
			</aside>
	</main>
	<footer>
	</footer>
    </body>
	<?php mysqli_close($connection);?>
</html>