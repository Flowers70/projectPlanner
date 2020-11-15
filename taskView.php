<?php
require("dataBaseConnection.php");

$task_ID = getPostVariable("task_ID", true);
if($task_ID <= 0){
    exit("Outside of valid input range");
}

$db = new DB();

$dt_task = $db->selectTaskDetails($task_ID);

$row = sqlsrv_fetch_array($dt_task);
echo("<small>".$row["Task_ID"]."</small>");
echo("<h1>".$row["Task_Name"]."</h1>");
echo("<strong>Category: </strong>".$row["Category"]);
echo("<br>");
echo("<strong>Priority: </strong>".$row["Priority"]);
echo("<br>");
echo("<strong>Due Date: </strong>".$row["Due"]);
echo("<br>");
echo("<strong>Goal Date: </strong>".$row["Goal"]);
echo("<br>");
echo("<strong>Created: </strong>".$row["Created"]);
echo("<br>");
echo("<strong style=\"text-decoration:underline;\">Description</strong>");
echo("<br>");
echo($row["Description"]);

?>
