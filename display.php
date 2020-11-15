<?php
require("supplement.php");

// Sort Column = 1 is Created Date
// Sort Column = 2 is Due Date
// Sort Column = 3 is Goal Date
$sortColumn = getPostVariable("sortColumn", true);

// View Type = 1 is Category
// View Type = 2 is Priority
$viewType = getPostVariable("viewType", true);

// Validates data
if($sortColumn < 1 || $sortColumn > 3 || $viewType < 1 || $viewType > 2){
    exit("Outside of valid input range");
}

$db = new DB();

if($viewType == 1){
    $dt_taskContainers = $db->selectCategories();
}else{
    $dt_taskContainers = $db->selectPriorities();
}

while($row = sqlsrv_fetch_array($dt_taskContainers)){
    // <div class="task_container">
    echo("<div class=\"task_container");
    if($viewType == 2){
        echo(" priority_".$row["Container"]);
    }
    echo("\" >");

    // <div class="categoryORpriority"><p>Test</p><p style="text-align: right;"># of Tasks</p></div>
    echo("<div class=\"categoryORpriority\"><p>");
    if($viewType == 1){
        echo($row["Container"]);
    }else{
        echo("Priority ".$row["Container"]);
    }
    echo("</p> <p style=\"text-align: right;\">".$row["taskCount"]." Task(s)</p></div>");
    
    $dt_Tasks = $db->selectTasks($viewType, $row["Container"], $sortColumn);

    while($taskRow = sqlsrv_fetch_array($dt_Tasks)){
        //         <div class="task">
        echo("<div class=\"task\">");

    //     //<div class="task_background priority_1">
        echo("<div class=\"task_background"); // Left here
    //     if($viewType == 1){
            echo(" priority_".$taskRow["Priority"]);
    //     }
        echo("\">");
        
    //     //<div class="text_container" id="button">
        echo("<div class=\"text_container\" onclick=\"viewTask(".$taskRow["Task_ID"].")\">");
        
    //     //<h2>Title</h2>
        echo("<h2>".$taskRow["Task_Name"]."</h2>");

        echo("<div>");
         //     // Gives the number priority
         if($viewType == 1){
            echo("Priority ".$taskRow["Priority"]);
         }else{
            echo($taskRow["Category"]);
         }
         

         echo("</div>");
    //     //<div class="date">
        echo("<div class=\"date\">");                            
        
    //     //<h4>11/14/2020</h4>
        echo("<h4>".$taskRow["Created"]."</h4>");   
        
    //     //<p>Category</p>
        echo("<p>Created</p>");

    //     //</div>
        echo("</div>");

    //     //<div class="date">
        echo("<div class=\"date\">");  
        
    //     //<h4>11/14/2020</h4>
        echo("<h4>".$taskRow["Due"]."</h4>");
         
    //     // <p>Due</p>
        echo("<p>Due</p>");  
        
    //     //</div>
        echo("</div>");

    //     //<div class="date">
        echo("<div class=\"date\">");

    //     //<h4>11/14/2020</h4>
        echo("<h4>".$taskRow["Goal"]."</h4>");                    
        
    //     //<p>Goal</p>
        echo("<p>Goal</p>");
        
    //     //</div>
        echo("</div>");
        

    //     //</div>
        echo("</div>");

    //     //<div class="image_container">
        echo("<div class=\"image_container\">");
        
    //     // Edit Image
        echo("<img src=\"Edit.png\" onclick=\"createTask(".$taskRow["Task_ID"].")\">");

    //     // Delete Image
        echo("<img src=\"Delete.png\" onclick=\"demonstration()\">");

    //     // Complete Image
        echo("<img src=\"Complete.png\" onclick=\"demonstration()\">");

        echo("</div>");
        echo("</div>");
        echo("</div>");
    }

    echo("</div>");
       
}

?>
