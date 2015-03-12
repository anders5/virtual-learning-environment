<?php
	session_start();
	function db_connect(){
		$connection=mysqli_connect('localhost','root','','virtual_learning_environment')
			   or die('Error connecting to the db'.mysqli_error($connection));
		return $connection;
	}
?>