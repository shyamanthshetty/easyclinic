<?php 

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

include_once "../models/Appointment.php";
include_once "../models/Patient.php";
include_once "../config/db.php";

$db = new Database();
$app = new Appointment($db->connect());
$pat = new Patient($db->connect());

$app->App_date = date("Y-m-d");
$app->Doc_id = $_SESSION['doc_id'];

$app_count = $app->getTodaysAppointmentCount();
$app_done_count = $app->getTodaysAppointmentDoneCount();
$app_pending_count = $app->getTodaysAppointmentPendingCount();
$appointments = $app->getAppointments();

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
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="#" class="
                  d-none d-sm-inline-block
                  btn btn-sm btn-primary
                  shadow-sm
                "><i class="fas fa-download fa-sm text-white-50"></i> Generate
                    Report</a>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4 mx-auto">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="
                            text-xs
                            font-weight-bold
                            text-primary text-uppercase
                            mb-1
                          ">
                                        Appointments (Today)
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $app_count; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4 mx-auto">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="
                            text-xs
                            font-weight-bold
                            text-info text-uppercase
                            mb-1
                          ">
                                        Checked (Today)
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="
                                h5
                                mb-0
                                mr-3
                                font-weight-bold
                                text-gray-800
                              ">
                                                <?php echo $app_done_count; ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="<?php echo "width:".(($app_done_count / $app_count)*100)."%"; ?>"
                                                    aria-valuenow="<?php echo $app_done_count; ?>" aria-valuemin="0"
                                                    aria-valuemax="<?php echo $app_count; ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4 mx-auto">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="
                            text-xs
                            font-weight-bold
                            text-warning text-uppercase
                            mb-1
                          ">
                                        Pending Appointments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $app_pending_count; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="h3 mb-4 text-gray-800">Upcoming Appointments
            </h1>

            <div class="table-responsive shadow">
                <?php
                if($appointments){ ?>
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th>Appointment Timing</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        while($row = $appointments->fetch_assoc()){
                            echo '<tr>';
                            echo '<td>';
                            if($row['App_time'] === '1')
                                echo '10am-12.30pm';
                            else if($row['App_time'] === '2')
                                echo '1.30pm-3.00pm';
                            else echo '4.00pm-6.30pm';
                            echo '</td>';
                            echo "<td>".$pat->getPatientNameById($row['P_id'])."</td>";
                            echo "<td>".$row['App_date']."</td>";
                            echo '<td><a href="./diagnosis.php?App_id='.$row['App_id'].'" class="btn btn-primary">Treat Patient</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?php      
                } else {
                    echo "<div class='m-3 text-center'>No Appointments as of Now 😍</div>";
                    
                } ?>

            </div>
            <!-- /.container-fluid -->
        </div>
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