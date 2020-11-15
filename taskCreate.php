<?php
require("dataBaseConnection.php");

$task_ID = getPostVariable("task_ID", true);
if($task_ID < 0){
    exit("Outside of valid input range");
}
$title = "";
$category = "";
$priority = 3;
$dueDate = "";
$goalDate = "";
$createdDate = "";
$description = "";

if($task_ID > 0){
    $db = new DB();
    $dt_task = $db->selectTaskDetails($task_ID);
    $row = sqlsrv_fetch_array($dt_task);

    $title = $row["Task_Name"];
    $category = $row["Category"];
    $priority = $row["Priority"];
    $dueDate = $row["Due"];
    $goalDate = $row["Goal"];
    $createdDate = $row["Created"];
    $description = $row["Description"];
}



echo("<h1>Create Task</h1>");
// Input for Task_Name
if($task_ID == 0){
    echo("<input id=\"taskName\" type=\"text\" placeholder=\"Enter task name...\" required>");
}else{
    echo("<input id=\"taskName\" type=\"text\" value=\"".$title."\" required>");
}

echo("<br>");
// Input for Category
if($task_ID == 0){
    echo("<input id=\"category\" type=\"text\" placeholder=\"Enter category...\" required>");
}else{
    echo("<input id=\"category\" type=\"text\" value=\"".$category."\" required>");
}

echo("<br>");

// Select for Priority
echo("<strong>Priority: </strong>");
echo("<select id=\"priority\" required>");
for($i = 1; $i < 6; $i = $i+1){
    if($task_ID == 0){
        if($i == $priority){
            echo("<option value=\"".$i."\" selected>".$i."</option>");
        }else{
            echo("<option value=\"".$i."\">".$i."</option>");
        }
    }else{
        if($i == $priority){
            echo("<option value=\"".$i."\" selected>".$i."</option>");
        }else{
            echo("<option value=\"".$i."\">".$i."</option>");

        }
    }
  
}

echo("</select>");

echo("<br>");

// Due Date
echo("<strong>Due Date: </strong>");
if($task_ID == 0){
    echo("<input id=\"dueDate\" type=\"date\">");
}else{
    echo("<input id=\"dueDate\" type=\"date\" value=\"".$dueDate."\">");
}
echo("<br>");

// Goal Date
echo("<strong>Goal Date: </strong>");

if($task_ID == 0){
    echo("<input id=\"goalDate\" type=\"date\">");
}else{
    echo("<input id=\"goalDate\" type=\"date\" value=\"".$goalDate."\">");
}
echo("<br>");

// Created Date
echo("<strong>Created Date: </strong>");
if($task_ID == 0){
    echo("<input id=\"createdDate\" type=\"date\" value=\"".date("Y-m-d")."\">");
}else{
    echo("<input id=\"createdDate\" type=\"date\" value=\"".$createdDate."\">");
}

echo("<br>");

// Description
if($task_ID == 0){
    echo("<input id=\"description\" type=\"text\" placeholder=\"Enter description...\">");
}else{
    echo("<input id=\"description\" type=\"text\" value=\"".$description."\">");
}
echo("<br>");

// Save button
echo("<button onclick=\"insertaTask()\">Save</button>");

// Cancel button
echo("<button onclick=\"closeModal()\">Cancel</button>");
echo("<p style=\"color:red\">This is a demo only (save is disabled)</p>");

?>
