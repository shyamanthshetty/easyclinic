<?php

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

include_once "../models/Appointment.php";
include_once "../models/Diagnosis.php";
include_once "../models/Doctor.php";
include_once "../models/Patient.php";
include_once "../config/db.php";

$db = new Database();
$app = new Appointment($db->connect());
$pat = new Patient($db->connect());
$diag = new Diagnosis($db->connect());
$doc = new Doctor($db->connect());

$app->Doc_id = $_SESSION['doc_id'];
$app_id = $app->getAllAppointmentByDocId();
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
            <h1 class="h3 my-4 text-gray-800 text-center">Diagnosis History</h1>

            <div class="container">
                <?php 
                if($app_id){ ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Diagnosis</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        while($row = $app_id->fetch_assoc()){
                            $diag->app_id = $row['App_id'];
                            $diagnosis = $diag->getDiagnosis();
                            $diagnosis = $diagnosis->fetch_assoc();
                            echo '<tr>';
                            echo '<td>';
                            echo $diagnosis['diag_id'];
                            echo '</td>';
                            echo '<td>';
                            $app->App_id = $diagnosis['app_id'];
                            $appointment = $app->getAppointment();
                            echo $appointment['App_date'];
                            echo '</td>';
                            echo '<td>';
                            echo $diagnosis['diagnosis'];
                            echo '</td>';
                            echo '<td>';
                            echo $pat->getPatientNameById($appointment['P_id']);
                            echo '</td>';
                            echo '<td>';
                             echo '<a href="./report.php?App_id='.$diagnosis['app_id'].'" class="btn btn-primary">View Report</a>';
                             echo '</td>';
                            echo '</tr>';
                        }
                        // while($row = $diagnosis->fetch_assoc()){
                        //     echo '<tr>';
                        //     echo '<td>';
                        //     echo $row['diag_id'];
                        //     echo '</td>';
                        //     $app->App_id = $row['app_id'];
                        //     $appointment = $app->getAppointment();
                        //     echo '<td>';
                        //     echo $appointment['App_date'];
                        //     echo '</td>';
                        //     echo '<td>';
                        //     echo $row['diagnosis'];
                        //     echo '</td>';
                        //     echo '<td>';
                        //     echo $pat->getPatientNameById($appointment['P_id']);
                        //     echo '</td>';
                            //  echo '<td>';
                            //  echo '<a href="./report.php?App_id='.$row['app_id'].'" class="btn btn-primary">View Report</a>';
                            //  echo '</td>';
                        //     echo '</tr>';
                        // }
                        
                        ?>
                    </tbody>
                </table>
                <?php }else{

                    echo "No history";
                    }?>
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