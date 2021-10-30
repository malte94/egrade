<?php
declare(strict_types=1);

session_set_cookie_params(3600 * 24 * 30);
session_start();

ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ERROR);
require_once "config/config.php";
require_once("config/setup.php");

if(isset($_GET["function"]))
{
    $action = "";

    switch(strtolower($_GET["function"])){
        case "login":
            $action = "Login";
            break;

        case "main":
            $action = "Main";
            break;

        case "create_reports":
            $action = "Create_Reports";
            break;    

        case "my_classes":
            $action = "My_Classes";
            break;    

        case "show_classes":
            $action = "Show_classes";
            break;

        case "add_schoolclass":
            $action = "Add_Schoolclass";
            break;

        case "schoolclass_details":
            $action = "Schoolclass_Details";
            break;

        case "shared_reports":
            $action = "Shared_Reports";
            break;  

        case "student_details":
            $action = "Student_Details";
            break;

        case "admin_school":
            $action = "Admin_School";
            break;

        case "absences":
            $action = "Absences";
            break;   

        case "pinboard":
            $action = "Pinboard";
            break;    
    }

    if (!empty($action))
    {
        require_once "functions/".$action.".php";

        $name_module = $action."_Class";
        $module = new $name_module();
    }

}else{
    require_once "functions/Login.php";
    $module = new Login_Class();
}


?>