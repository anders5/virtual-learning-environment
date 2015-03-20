<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>Group main page</title>
	<?php require_once("init.php");
	$connection=db_connect();
	$report_id=-1;
	$gid=$_SESSION['gid'];	//TODO to be tested
	
	?>
</head>
<body>
    <?php include "navbar.php"; ?>
<div id="main">
	<?php
	$query ="SELECT name FROM groups where id=$gid";
	$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysql_error());
	$row=mysqli_fetch_array($result);
	$gname=$row['name'];
	?>
	<header>
	<h1><?php echo "$gname's Home Page"?></h1>
	<?php require_once('navbar.php'); ?>
	</header>
	<main>
			<article>
				<h2>Group's members:</h2>
				<?php
					$query ="SELECT first_name,last_name FROM students WHERE students.fk_group=$gid";
					$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
					while($row=mysqli_fetch_array($result)){
						echo "$row[first_name] $row[last_name] <br />";//add link to profile page (TODO)
					}
				?>
			</article>
			<article>
			<section>
				<h2>Group report:</h2>
				<?php
					$query ="SELECT id,path FROM reports WHERE reports.fk_group=$gid";
					$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));

					if(mysqli_num_rows($result)==0){
						echo '<i>The group report has not been submitted yet.</i>';
				?>
					<form action="upload_form.php" method="GET">
					Click here to upload your report:
					<input type=submit value="Upload" />
					</form>
				<?php
					}else{
						$row=mysqli_fetch_array($result);
						$report_id=$row['id'];
						$name=basename($row['path']);
						echo "<a href='$row[path]'>$name</a>";
					}
				?>
			</section>
			<section>
				<?php
					if($report_id!=-1){
						echo "<h2>Assessments received:</h2>";
						//select report's assessments and authors
						$query ="SELECT assessments.id,groups.name FROM assessments JOIN groups ON assessments.fk_group=groups.id WHERE assessments.fk_report=$report_id AND assessments.completed";
						$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
						
						if(mysqli_num_rows($result)==0){
							echo '<i>Currently there are no assessments for this report.</i>';
						}else{
							while($row=mysqli_fetch_array($result)){
								echo "<h4>$row[name]'s assessment:</h4>";
								print_assessment_table($row['id']);
							}
						}
					}
				?>
			</section>
			</article>
			<article>
				<h2>Assessments assigned:</h2>
				<?php
					$query ="SELECT assessments.id,name,fk_report,completed FROM assessments,groups,reports WHERE assessments.fk_group=$gid AND groups.id=reports.fk_group AND reports.id=assessments.fk_report";
					$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
					
					if(mysqli_num_rows($result)==0){
						echo "<i>Currently your group hasn't got reports to assess.</i>";
					}else{
						while($row=mysqli_fetch_array($result)){
							echo "<section>";
							echo "<h3>$row[name]'s report.</h3>";
							
							if($row['completed']){
								echo "<i>You have already submitted an assessment for this report:</i><br />";
								print_assessment_table($row['id']);
							}
							else{
								echo "<i>This report hasn't been assessed yet.</i><br />";
								?>
									<form action="assessment.php" method="GET"><!-- TODO check the link-->
									Click here to assess this report:
									<input type=submit value="Assess" />
									</form>
								<?php
							}
							echo "</section>";
						}
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