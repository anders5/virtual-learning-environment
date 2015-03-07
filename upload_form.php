<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Report upload</title>
	<?php
	require_once("init.php");
	$connection=db_connect();
	$gid=$_GET['gid'];
	?>
</head>
<body>
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
				<form action="upload_result.php" method='POST'>
					<textarea name="report" rows="30" cols="50">Copy your report here...</textarea><br />
					<input type=hidden name="gid" value="<?php echo $gid ?>" />
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