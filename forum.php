<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta charset="utf-8">
	<title>Forum</title>
	<?php 
		require_once('init.php');
		$connection=db_connect();
		$uid	= $_SESSION['uid'];
		
		//new thread created, store it in the db
		if(isset($_POST['newpost'])){
			$title	=mysqli_real_escape_string($connection,$_POST['title']);
			$content=mysqli_real_escape_string($connection,$_POST['content']);
			
			$query="INSERT INTO threads VALUES(NULL,$uid,'$title','$content',CURRENT_TIMESTAMP)";
			$result=mysqli_query($connection,$query);
			if(!$result)
				echo "<i>ERROR: Couldn't create a new thread.</i>";
			else
				echo "<i>Thread successfully created.</i>";
		}
	?>
</head>
<body>
    <?php include "navbar.php"; ?>
<div id="main">
	<header>
	<h1>Public Forum</h1>
	<?php require_once('navbar.php'); ?>
	</header>
	
	<main>
		<article>
			<h2>Latest discussions:</h2>
			<?php
				$query="SELECT threads.id,title,username,creation FROM threads JOIN students ON threads.fk_author=students.id ORDER BY creation DESC";
				$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysql_error());
				
				if(mysqli_num_rows($result)==0)
						echo "<i>There are no discussions yet.</i><br />";
				else{
					?>
					<section>
						<table border=1>
						<?php
							while($row=mysqli_fetch_array($result))
								print_forum_post($row['username'],$row['creation'],"<a href='thread.php?id=$row[id]'><b>$row[title]</b></a>");
						?>
						</table>
					</section>
					<section>
						<form action="#" method=post  >
						<legend><h3>Post a new thread here:</h3></legend>
						<fieldset>
							<input type=text name=title size=50 maxlenght=50 placeholder='Write the title here...'/><br />
							<textarea name=content rows=5 cols=50 placeholder='Write here...'></textarea><br />
							<input type=hidden name=newpost value=1>
							<input type=submit value='Post'>
						</fieldset>
						</form>
					</section>
				<?php
				}
				?>
		</article>
		<aside>
			<form action="forum_search_result.php" method=get  >
			<legend><h3>Search a thread:</h3></legend>
				<fieldset>
					<i>Enter the partial title below.</i><br />
					<input type=text name=title size=30 maxlenght=50 /><br />
					<input type="checkbox" name="user_src" />
					Search only threads by:
					 <select name="userlist">
						<?php
							$query="SELECT username FROM students ORDER BY username";
							$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysql_error());
							while($row=mysqli_fetch_array($result))
								echo "<option value='$row[username]'>$row[username]</option>";
						?>
					</select>
					<br />
					<input type=hidden name=newpost value=1>
					<input type=submit value='Search'>
				</fieldset>
			</form>
		</aside>
	</main>
	
	<footer>
	</footer>
    </body>
</html>