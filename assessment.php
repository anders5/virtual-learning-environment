

<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="js/jquery-2.1.3.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
</head>  
<body onload="init()">  
    <?php include "navbar.php"; ?>
<div id="main">
    <h1>Paper Assessment Form</h1>
       
		<form method="post" action="submitassessment.php" name="assessmentform" id="assessmentform">
			<p>Report Being Assessed: <input type="text" name="report"></p>

			<table id="assessmentTable" border="1px" style="width:100%">
			  <tr>
			    <th>Criteria</th>
			    <th>Grade</th> 
			    <th>Comments (Optional)</th>
			  </tr>
			</table>
			
			<button type="button" onclick="addCriteria()">Add another criteria</button>
			<input type="submit" value="Submit">
		</form>

        <script>

var numCriteria = 1;

function init() {
	addCriteria();
	addCriteria();
	addCriteria();
	addCriteria();
}

function addCriteria() {
    var table = document.getElementById("assessmentTable");
    var row = table.insertRow(numCriteria);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    row.id = numCriteria;
    cell1.innerHTML = '<input type="text" name="criteria_'+numCriteria+'" size="50">';
    cell2.innerHTML = '<input type="radio" name="grade_'+numCriteria+'" value="1"> 1   <input type="radio" name="grade_'+numCriteria+'" value="2"> 2   <input type="radio" name="grade_'+numCriteria+'" value="3"> 3   <input type="radio" name="grade_'+numCriteria+'" value="4"> 4   <input type="radio" name="grade_'+numCriteria+'" value="5"> 5';
    cell3.innerHTML = '<textarea name="comment_'+numCriteria+'" rows="2" cols="80"></textarea>';
    numCriteria++;
}

</script>

   

</div>
</body>
</html>