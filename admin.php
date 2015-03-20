<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
	<meta charset="utf-8">
	<title>Admin page</title>
	<?php
	require_once("init.php");
	$connection=db_connect();
	
	//add a group
	if(isset($_GET['add'])){
		$query ="INSERT INTO groups VALUES(NULL,'no_name')";
		if(!$result=mysqli_query($connection,$query))
			echo "<i>Cannot add a new group.</i>";
	}
	
	//remove a group
	if(isset($_GET['remove'])){
		$gid=$_GET['gid'];
		$query ="SELECT * FROM reports WHERE fk_group=$gid";
		$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
		
		if(mysqli_num_rows($result)==0){
			$query ="SELECT * FROM assessments WHERE fk_group=$gid";
			$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
			if(mysqli_num_rows($result)==0){
				$query ="UPDATE students SET fk_group=NULL WHERE fk_group=$gid";
				$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
				$query ="DELETE FROM groups WHERE id=$gid";
				$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
			}
			else{
				echo "<i>The group cannot be deleted because it has at least one assigned assessment. </i>";
				echo "<i>In order to delete the group, please remove every assessments from it.</i>";
			}
		}
		else
			echo "<i>The group cannot be deleted because it has already submitted a report.</i>";
		
	}
	
	//update the db after edit page
	if(isset($_POST['edit'])){
		$checks=array();
		
		//keeps tracks of checked checkboxes.
		$query ="SELECT id FROM reports";
		$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
		while($row=mysqli_fetch_array($result)){
			$id=$row['id'];
			$checks[$id]=(isset($_POST["check_$id"]))?(true):(false);
		}
		
		$gid=(int)$_POST['gid'];
		$gname=	  mysqli_real_escape_string($connection,$_POST['name']);
		$student0=mysqli_real_escape_string($connection,$_POST['student_0']);
		$student1=mysqli_real_escape_string($connection,$_POST['student_1']);
		$student2=mysqli_real_escape_string($connection,$_POST['student_2']);
		
		//update db.
		$query ="UPDATE groups SET name='$gname' WHERE id=$gid";
		if(!$result=mysqli_query($connection,$query))
			echo "<i>Couldn't change the group's name.</i><br />";
		
		$query ="UPDATE students SET fk_group='$gid' WHERE username='$student0'";
		if(!$result=mysqli_query($connection,$query))
			echo "<i>Couldn't change $student0 group assignment.</i><br />";
		
		$query ="UPDATE students SET fk_group='$gid' WHERE username='$student1'";
		if(!$result=mysqli_query($connection,$query))
			echo "<i>Couldn't change $student1 group assignment.</i><br />";
		
		$query ="UPDATE students SET fk_group='$gid' WHERE username='$student2'";
		if(!$result=mysqli_query($connection,$query))
			echo "<i>Couldn't change $student2 group assignment.</i><br />";
		
		foreach($checks as $i => $checked){
			if($checked){
				$query ="INSERT INTO assessments VALUES(NULL,$gid,$i,0)";
				if(!$result=mysqli_query($connection,$query))
					echo "<i>Couldn't add assessment for group $gid.</i><br />";
			}
		}
	}
	?>
</head>

<body>
        <?php include "navbar.php"; ?>
    <div id="main">
	<header>
	<h1>Admin control page</h1>
	<?php
		require_once('navbar.php');
	?>
	</header>
	
	<main>
		<article>
			<h2>Groups management.</h2>
			<?php
			$g_query ="SELECT * FROM groups";
			$g_result=mysqli_query($connection,$g_query) or die('Error in mySQL query'.mysqli_error($connection));
			?>
			<table border=1>
			<tr>
				<td><b>ID</b></td>
				<td><b>Name</b></td>
				<td><b>Students</b></td>
				<td><b>Assessments assigned</b></td>
			</tr>
			<?php
			while($g_row=mysqli_fetch_array($g_result)){
				echo "<tr>";
				echo "<td>$g_row[id]</td>";
				echo "<td>$g_row[name]</td>";
				
				$s_query="SELECT id,username FROM students WHERE fk_group=$g_row[id]";
				$s_result=mysqli_query($connection,$s_query) or die('Error in mySQL query'.mysqli_error($connection));
				
				echo "<td>";
				while($s_row=mysqli_fetch_array($s_result))
					echo "<a href='account.php?id=$s_row[id]'>$s_row[username]</a><br />";//TODO check the link
				echo "</td>";
				
				//select the assessments assigned to this group, the name of the group whom submitted
				//the report to be assigned, and the path of the report.
				$a_query="SELECT name,completed,path FROM assessments,groups,reports WHERE reports.fk_group=groups.id AND assessments.fk_report=reports.id AND assessments.fk_group=$g_row[id]";
				$a_result=mysqli_query($connection,$a_query) or die('Error in mySQL query'.mysqli_error($connection));
				
				echo "<td>";
				while($a_row=mysqli_fetch_array($a_result)){
					echo "Assessment of <a href='$a_row[path]'>$a_row[name]'s report</a>:";
					if($a_row['completed'])
						echo "<i> completed.</i>";
					else
						echo "<i> not completed.</i>";
					echo "<br />";
				}
				echo "</td>";
			?>
				<td>
					<form method=get>
					<input type=hidden name="gid" value=<?php echo $g_row['id']?> />
					<input type=submit formaction='admin_group_edit.php' value="Edit" />
					<input type=submit name="remove" formaction='#' value="Remove" />
					</form>
				</td>
			<?php
			}
			?>
			</table>
			
		</article>
		
		<aside>
			<form action="#" method=get>
			<input type=submit name="add" value="Add a new group" />
			</form>
		</aside>
	</main>
	
	<footer>
	</footer>
    </body>
</html>