<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Report upload</title>
	<?php
	require_once("init.php");
	$connection=db_connect();
	$gid	=$_POST['gid'];
	$report	=mysqli_real_escape_string($connection,$_POST['report']);
	$query	="INSERT INTO reports (id,fk_group,content) VALUES (NULL,$gid,'$report')";
	$result	=mysqli_query($connection,$query)or die('Error in mySQL query'.mysqli_error($connection));
	?>
</head>
<body>
	<main>
		<article>
		<?php
			if($result){
				echo '<h3>Your report has been successfully uploaded.</h3><br />';
				echo 'Click <a href="group.php">here</a> to go back to your group page.';
			}
			else{
				echo "<h3>There's been a problem with your download. Try later.</h3><br />";
				echo 'Click <a href="upload_form.php">here</a> to go back to the upload form.';
			}
		?>
		</article>
			
		<aside>
		</aside>
	</main>
		<footer>
		</footer>
    </body>
	<?php mysqli_close($connection);?>
</html>