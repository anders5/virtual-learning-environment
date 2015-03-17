<!DOCTYPE html>
<?php include "base.php"; ?>
 
<title>Virtual Learning Environment</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
    
    <h1>Paper Assessment Form</h1>
    <?php

if (empty($_POST['report']) || empty($_POST['criteria_1']) || empty($_POST['grade_1'])) {
    echo "<h2>Error</h2>";
    echo "<p>Please enter the group you are assessing and at least one criteria and grade.</p>";    
}
else {
    $report = $_POST['report'];
    $checkassessed = mysqli_query($connection, "SELECT id, completed FROM assessments WHERE fk_report = '".$report."' AND fk_group = '".$_SESSION['gid']."'");
    $assessment = mysqli_fetch_assoc($checkassessed);
    
    if (mysqli_num_rows($checkassessed) != 1) {
        echo "<h2>Error</h2>";
        echo "<p>Please check the report number and try again.</p>";
    }
    else if ($assessment["completed"] == 1) {
        echo "<h2>Error</h2>";
        echo "<p>The assessment for this report has already been completed.</p>";
    }
    else {
        $numCriteria = 0;
        $gradeSum = 0;
        $finalGrade = 0;
        
        foreach($_POST as $name => $value) {
            // Split the name into an array on each underscore.
            $criteriaSearch = explode("_", $name);
            $gradeSearch = "grade_" . $criteriaSearch[1];
            $commentSearch = "comment_" . $criteriaSearch[1];

            // If the data begins with "criteria", use it.
            if ($criteriaSearch[0] == "criteria" && $value != NULL) {
                // If there doesn't exist a corresponding "grade," print error.
                if (!isset($_POST[$gradeSearch])) {
                    echo "<h2>Error</h2>";
                    echo '<p>Please enter a grade for criteria "$value".</p>';
                }
                //Submit criteria if there exists a corresponding "grade"
                else {
                    //Check for comment
                    if (isset($_POST[$commentSearch])) {
                        //Submit criteria with comment to database
                        $submissionquery = mysqli_query($connection, "INSERT INTO criteria (type, fk_assessment, comment, grade) VALUES('".$value."', '".$assessment['id']."', '".$_POST[$commentSearch]."', '".$_POST[$gradeSearch]."')");
                    }
                    else {
                        //Submit criteria without comment to database
                        $submissionquery = mysqli_query($connection, "INSERT INTO criteria (type, fk_assessment, grade) VALUES('".$value."', '".$assessment['id']."', '".$_POST[$gradeSearch]."')");
                    
                    }
                    
                    if ($submissionquery) {
                        $numCriteria += 1;
                        $gradeSum += (int)$_POST[$gradeSearch];
                    }
                    else {
                        echo "<h2>Error</h2>";
                        echo "<p>Sorry, your criteria submission has failed.</p>";
                        break 2;
                    }
                }
            }
        }
        
        $finalGrade = $gradeSum / $numCriteria;
        $completedquery = mysqli_query($connection, "UPDATE assessments SET completed='1', grade='".$finalGrade."' WHERE fk_group='".$_SESSION['gid']."' AND fk_report='".$_POST['report']."'");
        if ($completedquery){
            echo "<h2>Success</h2>";
            echo "<p>Your assessment has been submitted";
        }
        else {
            echo "<h2>Error</h2>";
            echo "<p>Sorry, your assessment submission has failed.</p>";
        }
    }
}?>
 
</div>
</body> 