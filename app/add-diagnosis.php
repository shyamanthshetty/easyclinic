<?php

include_once "../config/db.php";
include_once "../models/Diagnosis.php";

$db = new Database();
$diag = new Diagnosis($db->connect());

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $diag->app_id = $_POST['app_id'];
        $app_id = $_POST['app_id'];
        $diag->diagnosis = $_POST['diagnosis'];
        if($diag->addDiagnosis()){
            header("location:./prescription.php?diag_id=".$diag->diag_id."&app_id=".$app_id);
        }
        else die("Error");
    }
    else die("from error");
}

?>