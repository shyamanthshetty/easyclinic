<?php 

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

if(!isset($_GET['App_id'])){
    die('Invalid App_id');
}

include_once "../models/Appointment.php";
include_once "../models/Patient.php";
include_once "../config/db.php";

$db = new Database();
$app = new Appointment($db->connect());
$pat = new Patient($db->connect());

$app->App_id = $_GET['App_id'];
$ptn = $app->getAppointment();
$pname = $pat->getPatientNameById($ptn['P_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
            <h1 class="h3 my-3 text-gray-800 text-center">Treatment For <?= $pname ?> </h1>

            <div class="card border-0 shadow container p-5" style="max-width: 500px;">

                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Treatment Details</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prescribed Medicine</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dosage</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No of Days</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Treatment Fees</label>
                        <input type="number" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>

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