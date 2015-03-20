<?php

//connects to 'virtual_learning_environment' db.
function db_connect(){
		$connection=mysqli_connect('eu-cdbr-azure-north-b.cloudapp.net','b71a879e88f712','6c9071b0','vledatabase')
			   or die('Error connecting to the db'.mysqli_error($connection));
		return $connection;
}

//prints a table which contains all the critera for a certain assessment.
function print_assessment_table($id){
		$connection=db_connect();
		
		echo "<table border=1>";
		echo "<tr><td><b>Type</b></td><td><b>Description</b></td><td><b>Grade</b></td></tr>";
		
		$query ="SELECT type,description,grade FROM criteria WHERE fk_assessment=$id ORDER BY type ASC";
		$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysql_error());
		while($row=mysqli_fetch_array($result)){
			echo "<tr><td>$row[type]</td><td>$row[description]</td><td>$row[grade]</td></tr>";
		}
		echo "</table>";
}

//prints a single line of a table, representing a forum post.
function print_forum_post($author,$creation,$content){
	echo "<tr>";
	echo "<td><i>Posted on: </i>$creation<br />";
	echo "<i>By: </i>$author";
	echo "</td>";
	echo "<td>$content</td>";
	echo "</tr>";
}

//generate the list of all students. the output is suitable for a drop-down list.
function generate_students_option_list($connection,$default){
	$query="SELECT username FROM students ORDER BY username";
	$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
	
	while($row=mysqli_fetch_array($result)){
		$selected=($row['username']==$default)?("selected='selected'"):("");
		echo "<option ".$selected."value='$row[username]'>$row[username]</option>";
	}
}

?>