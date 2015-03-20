<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
	<meta charset="utf-8">
	<title>Forum</title>
	<?php 
		require_once('init.php');
		$connection=db_connect();
		$uid=6;//$_SESSION['uid'];
		$tid=(int)(isset($_POST['newrep']))?($_POST['tid']):($_GET['id']);
		
		//new thread created, store it in the db
		if(isset($_POST['newrep'])){
			$content=mysqli_real_escape_string($connection,$_POST['content']);
			
			$query="INSERT INTO replies VALUES(NULL,$tid,$uid,'$content',CURRENT_TIMESTAMP)";
			$result=mysqli_query($connection,$query);
			if(!$result)
				echo "<i>ERROR: Couldn't store the reply in the db.</i>";
			else
				echo "<i>Reply successfully stored.</i>";
		}
		
	?>
</head>
<body>
    <div id="main">
	<header>
	<?php require_once('navbar.php'); ?>
	</header>
	
	<main>
		<?php
			$query="SELECT title,content,username,creation FROM threads JOIN students ON threads.fk_author=students.id WHERE threads.id=$tid"; 
			$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
			$row=mysqli_fetch_array($result);
		?>
		<article>
			<h2><?php echo $row['title'] ?></h2>
		
			<section>
				<table border=1>
					<?php print_forum_post($row['username'],$row['creation'],$row['content']); ?>
				</table>
			</section>
			<br>
			<section>
				<i>Replies:</i><br />
				<?php
					$query="SELECT content,creation,username FROM replies JOIN students ON replies.fk_author=students.id WHERE fk_thread=$tid ORDER BY creation ASC"; 
					$result=mysqli_query($connection,$query) or die('Error in mySQL query'.mysqli_error($connection));
					if(mysqli_num_rows($result)==0)
						echo "<i>There are no replies to this thread yet.</i><br />";
					else{
						echo "<table border=1>";
	
						while($row=mysqli_fetch_array($result))
							print_forum_post($row['username'],$row['creation'],$row['content']);
						
						echo "</table>";
					}
				?>
			</section>
			<section>
				<form action="#" method=post  >
				<legend><h3>Post a new reply here:</h3></legend>
				<fieldset>
					<textarea name=content rows=5 cols=50 placeholder='Write your reply here...'></textarea><br />
					<input type=hidden name=newrep value=1>
					<input type=hidden name=tid value=<?php echo $tid?>>
					<input type=submit value='Post'>
				</fieldset>
				</form>
			</section>
		</article>
		
		<aside>
			Click <a href="forum.php">here</a> to go back to the main forum.
		</aside>
	</main>
	
	<footer>
	</footer>
    </body>
</html>