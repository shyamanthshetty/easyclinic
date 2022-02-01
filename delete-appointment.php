<?php 


session_start();
if(!isset($_SESSION['user_in']))
    header("location:user-login.php");

if(!isset($_GET['App_id']))
    die("Invalid App id");


include_once "./config/db.php";
include_once "./models/Appointment.php";

$db = new Database();
$app = new Appointment($db->connect());
$app->App_id = $_GET['App_id'];

if($app->deleteAppointment())
    header("location:./user-dashboard.php?done=1&msg=Appointment%20Deleted%20Successfully");
else header("location:./user-dashboard.php?done=1&msg=Something%20Went%20Wrong");
?>