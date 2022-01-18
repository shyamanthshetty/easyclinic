<?php

session_start();
if(!isset($_SESSION['user_in']))
    header("location:user-login.php");

?>