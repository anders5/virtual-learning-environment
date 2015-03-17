<!DOCTYPE html>
<?php include "base.php"; ?>
 
<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
    
    <h1>Group Ranking Page</h1>
    <ol>
    <?php
    $assessments = mysqli_query($connection, "SELECT assessments.grade, reports.fk_group FROM assessments INNER JOIN reports ON assessments.fk_report = reports.id ORDER BY assessments.fk_report ASC");
    $rankArray = array();
    $curGroup = -1;
    $numReports = 0;
    $curTotal = 0;
    
    while($row = mysqli_fetch_assoc($assessments)){
        if ($curGroup != $row['fk_group']) {
            $curGroup = $row['fk_group'];
            $numReports = 0;
            $curTotal = 0;
        }
        
        if ($row['grade']) {
            $numReports += 1;
            $curTotal += $row['grade']; 
            $rankArray[$curGroup] = $curTotal / $numReports;
        }
    }
    
    arsort($rankArray);
    
    foreach($rankArray as $name => $value) {
        $groupName = mysqli_query($connection, "SELECT name FROM groups WHERE id='".$name."'");
        if ($name == $_SESSION['gid']) {
            echo "<li><b>".mysqli_fetch_assoc($groupName)['name']."</b></li>";
        } 
        else {
            echo "<li>".mysqli_fetch_assoc($groupName)['name']."</li>";
        }
    }
    
?>
    </ol>
</div>
</body> 