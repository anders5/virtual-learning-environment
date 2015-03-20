<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
	<meta charset="utf-8">
	<?php
		require_once("init.php");
		$connection=db_connect();
		$gid=(int)$_GET['gid'];
	?>
	<title>Group edit</title>
</head>
<body>
        <?php include "navbar.php"; ?>
        <div id="main">
	<h1>Admin control page</h1>
	<header>
	<?php require_once('navbar.php');?>
	</header>
	
	<main>
		<article>
			<?php
			$query ="SELECT * FROM groups WHERE groups.id=$gid";
			$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
			?>
			<form action="admin.php" method=post>
			<table border=1>
			<tr>
				<td><b>ID</b></td>
				<td><b>Name</b></td>
				<td><b>Students</b></td>
				<td><b>Assessments assigned</b><br />
					<i>NB: Assessments that have already been completed cannot be removed.</i>
				</td>
			</tr>
			<?php
			$row=mysqli_fetch_array($result);
			echo "<tr>";
			echo "<td>$row[id]</td>";
			?>	
				<td><input type=text name="name" value=<?php echo "$row[name]"?> ></td>
			<?php	
			
			$query="SELECT username FROM students WHERE fk_group=$gid";
			$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
			
			//in case the group isn't full
			$i=mysqli_num_rows($result);
			echo "<td>";

			$j=0;
			for(;$row=mysqli_fetch_array($result);$j++){
				echo "<select name='student_$j'>";
				generate_students_option_list($connection,$row['username']);
				echo "<option value='unassigned'>unassigned</option>";
				echo "</select><br />";
				
				//this is needed to avoid inconsisencies during the update
				$sub_query ="UPDATE students SET fk_group=NULL WHERE username='$row[username]'";
				$sub_result=mysqli_query($connection,$sub_query)or die('Error in mySQL query'.mysqli_error($connection));
			}
			for(;$i<3;$i++,$j++){
				echo "<select name='student_$j'>";
				generate_students_option_list($connection,NULL);
				echo "<option selected='selected' value='unassigned'>unassigned</option>";
				echo "</select><br />";
			}
			echo "</td>";
			echo "<td>";
			
			//all the reports
			$query1="SELECT reports.id,name,path FROM reports JOIN groups ON reports.fk_group=groups.id ORDER BY reports.id";
			$result1=mysqli_query($connection,$query1) or die('Error in mySQL query'.mysqli_error($connection));
			
			
			if(0==mysqli_num_rows($result1))
				echo "<i>There are no assessments to assign.</i>";
			else
				while($row1=mysqli_fetch_array($result1)){
					//all report already assigned to this group for assessment
					$query2="SELECT id,fk_report,completed FROM assessments WHERE fk_group=$gid";
					$result2=mysqli_query($connection,$query2) or die('Error in mySQL query'.mysqli_error($connection));
					
					$tmp=false;
					$completed=false;
					$aid=0;
					while($row2=mysqli_fetch_array($result2)){
						if($row1['id']==$row2['fk_report']){
							$tmp=true;
							$completed=$row2['completed'];
							$aid=$row2['id'];
							break;
						}
					}
					$checked=($tmp)?("checked"):("");
					
					//if an assessment has already been completed, it won't be possible to delete it
					$checked.=($completed)?(" disabled='disabled'"):("");
					echo "<input type='checkbox' name='check_$row1[id]' ".$checked.">$row1[name]'s <a href='$row1[path]'>report</a>.<br />";
					
					//this is needed to avoid inconsisencies during the update
					if(!$completed){
						$query ="DELETE FROM assessments WHERE id=$aid";
						$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
						
					}
				}
			echo "</td>";
			?>
			</table>
			<br />
			<input type=hidden name="edit">
			<input type=hidden name="gid" value=<?php echo $gid?>>
			<input type=submit value="Save edit">
			</form>
		</article>
		
		<aside>
		</aside>
	</main>
	
	<footer>
	</footer>
    </body>
</html>