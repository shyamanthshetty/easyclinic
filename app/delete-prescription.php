<?php 

session_start();
if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

if(!isset($_GET['Presc_id']) && !isset($_GET['app_id'])){
    die('Invalid Presc_id');
}
$app_id = $_GET['app_id'];
include_once "../models/Prescription.php";
include_once "../config/db.php";
$db = new Database();
$presc = new Prescription($db->connect());

$presc->Presc_id = $_GET['Presc_id'];
if($presc->deletePrescription()){
    header("location:./diagnosis.php?App_id=".$app_id."&done=1&msg=Prescription%20Deleted%20Successfully");
}

?>