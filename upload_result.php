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
	
	//check for the right extension
	if(!isset($_FILES["report"]))
		$upload_ok=0;
	else{
		$target_file = "reports/".basename($_FILES["report"]["name"]);
		$upload_ok = 1;
		$ext = pathinfo($target_file,PATHINFO_EXTENSION);

		if($ext != "pdf"){
			echo "Only PDF files are allowed.<br />";
			$upload_ok = 0;
		}
		
		//upload file
		if($upload_ok){
			if(move_uploaded_file($_FILES["report"]["tmp_name"],$target_file)) {
				//store info in the db
				$query ="INSERT INTO reports (id,fk_group,path) VALUES (NULL,$gid,'$target_file')";
				if(!$result=mysqli_query($connection,$query)){
					echo 'Error in mySQL query '.mysqli_error($connection);
					unlink($target_file);
					$upload_ok=0;
				}
			}
			else
				$upload_ok=0;
		}
	}
	?>
</head>
<body>
    <div id="main">
        <?php include "navbar.php"; ?>
	<main>
		<article>
		<?php
			if($upload_ok){
				echo '<h3>Your report has been successfully uploaded.</h3><br />';
				echo 'Click <a href="group.php">here</a> to go back to your group page.';
			}
			else{
				echo "<h3>There's been a problem with your download.</h3><br />";
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