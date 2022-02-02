<?php

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

include_once "../models/Doctor.php";
include_once "../config/db.php";

$db = new Database();
$doc = new Doctor($db->connect());

$doc->Doc_id = $_SESSION['doc_id'];
$doctor = $doc->getDoctor();
$doctor = $doctor->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png" />
    <link rel="manifest" href="../site.webmanifest" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?php echo $_SESSION['clinic']; ?> - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../static/vendor/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom styles for this template-->
    <link href="../static/css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include_once "../partials/dashboard-nav.php" ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <h1 class="h3 my-4 text-gray-800 text-center">Doctor Info</h1>
            <div class="container mx-auto" style="max-width: 500px;">
                <div class="card shadow border-0 p-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Doctor ID : </h6>

                        </div>
                        <div class="col-sm-6">
                            <?php echo $doctor['Doc_id']; ?>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <h6>Doctor Name : </h6>

                        </div>
                        <div class="col-sm-6">
                            <?php echo $doctor['Doc_name']; ?>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <h6>Doctor Contact : </h6>

                        </div>
                        <div class="col-sm-6">
                            <?php echo $doctor['Doc_contact']; ?>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <h6>Doctor Qualification : </h6>

                        </div>
                        <div class="col-sm-6">
                            <?php echo $doctor['Doc_specialization']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div> <!-- end -->
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once "../partials/footer.php" ?>
</body>

</html>