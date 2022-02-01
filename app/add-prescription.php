<?php
session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

include_once "../config/db.php";
include_once "../models/Prescription.php";

$db = new Database();
$presc = new Prescription($db->connect());

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $direction = '';
        $presc->Presc_medicine = $_POST['medicine'];
        if(isset($_POST['morning'])){
            $direction.=1;
            $direction.='-';
        }else{
            $direction.=0;
            $direction.='-';
        }
        if(isset($_POST['afternoon'])){
            $direction.=1;
            $direction.='-';
        }else{
            $direction.=0;
            $direction.='-';
        }
        if(isset($_POST['evening'])){
            $direction.=1;
        }else{
            $direction.=0;
        }
        $presc->Presc_directions = $direction;
        $presc->Presc_course = $_POST['course'];
        $presc->Presc_instructions = $_POST['instructions'];
        $presc->diag_id = $_POST['diag_id'];
        if($presc->addPrescription()){
            header("location:./diagnosis.php?App_id=".$_GET['app_id']);
        }
    }
}
?>