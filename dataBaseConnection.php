<?php

class DB{
    private static $project_ID = 1;
    
    // Connects to database
    function __construct(){ 
        $serverName;
        $connectionInfo;
        $this->conn = sqlsrv_connect($serverName, $connectionInfo);
    }
    
    // Destroys connection to database
    function __destruct(){
        sqlsrv_close($this->conn);
    }


    function selectTaskDetails($taskID){
        $sql = "SELECT Task_ID, Task_Name, Category, Priority, FORMAT(Created, 'M/d/yyyy') AS Created, FORMAT(Due,'M/d/yyyy') AS Due, FORMAT(Goal, 'M/d/yyyy') AS Goal, Description ".
            "FROM Project_Task ".
            "WHERE Task_ID = $taskID;";
        return sqlsrv_query($this->conn, $sql);
    }

    function selectCategories(){
        $sql = "SELECT Category AS Container, COUNT(*) taskCount ".
            "FROM Project_Task ".
            "WHERE Project_ID = ".self::$project_ID.
            " GROUP BY Category ".
            "ORDER BY Category;";
        return sqlsrv_query($this->conn, $sql);
    }

    function selectPriorities(){
        $sql = "SELECT Priority AS Container, COUNT(*) taskCount ".
            "FROM Project_Task ".
            "WHERE Project_ID = ".self::$project_ID.
            " GROUP BY Priority ".
            "ORDER BY Priority;";
        return sqlsrv_query($this->conn, $sql);
    }

    function selectTasks($viewType, $ContainerID, $sortColumn){
        $sql = "SELECT Task_ID, Task_Name, Category, Priority, FORMAT(Created, 'M/d/yyyy') AS Created, FORMAT(Due, 'M/d/yyyy') AS Due, FORMAT(Goal, 'M/d/yyyy') AS Goal, Description ".
        "FROM Project_Task ".
        "WHERE Project_ID = ".self::$project_ID." AND ";
        
        if($viewType == 1){
            $sql .= "Category = '".str_replace("'","''",$ContainerID)."' ";
        }else{
            $sql .= "Priority = ".$ContainerID." ";
        }
        $sql .= "ORDER BY ";
        if($sortColumn == 1){
            $sql .= "Created, Task_Name;";
        } else if($sortColumn == 2){
            $sql .= "Due, Task_Name;";
        }else{
            $sql .= "Goal, Task_Name;";
        }
        return sqlsrv_query($this->conn, $sql);
    }
}

// Validates passed variables
// $request_variable = Name of Variable
// $isNumeric True or False 
function getRequestVariable($request_variable, $isNumeric){
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST[$request_variable])){
        $arg = $_REQUEST[$request_variable];
        $arg = trim($arg);
        $arg = stripslashes($arg);
        $arg = htmlspecialchars($arg);
        if($isNumeric == false || is_numeric($arg)){
            return $arg;
        }else{
            return -1;
        }
        
    }else{
        return -1;
    }
}

// Validates passed variables
// $request_variable = Name of Variable
// $isNumeric True or False 
function getPostVariable($request_variable, $isNumeric){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$request_variable])){
        $arg = $_POST[$request_variable];
        $arg = trim($arg);
        $arg = stripslashes($arg);
        $arg = htmlspecialchars($arg);
        if($isNumeric == false || is_numeric($arg)){
            return $arg;
        }else{
            return -1;
        }
        
    }else{
        return -1;
    }
}

?>
