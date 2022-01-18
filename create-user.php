<?php

include_once "./config/db.php";
include_once "./models/Users.php";

$db = new Database();
$user = new Users($db->connect());

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $user->U_name = $_POST['name'];
        $user->U_clinic_name = $_POST['clinic'];
        $user->U_email = $_POST['email'];
        $user->U_password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        if($user->addUser())
        {
            header("location:get-started.php?done=1&msg=Account%20created%20Successfully.Please%20Add%20Doctor%20Info%20To%20Complete%20The%20Account%20Setup&acc_id=".$user->U_id);
        }
        else die("df");
    }
}
else die("Request not allowed");

?>