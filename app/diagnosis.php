<?php 

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

if(!isset($_GET['App_id'])){
    die('Invalid App_id');
}

include_once "../models/Appointment.php";
include_once "../models/Diagnosis.php";
include_once "../models/Prescription.php";
include_once "../models/Patient.php";
include_once "../config/db.php";

$db = new Database();
$app = new Appointment($db->connect());
$pat = new Patient($db->connect());
$diag = new Diagnosis($db->connect());

$app->App_id = $_GET['App_id'];
if($app->getAppointment()){
    $ptn = $app->getAppointment();
    $pname = $pat->getPatientNameById($ptn['P_id']);
}
else {
    header('location:./dashboard.php');
}

$diag->app_id = $_GET['App_id'];
$diagnosis = $diag->getDiagnosis();
if($diagnosis){
    $diags = $diagnosis->fetch_assoc();
    $presc = new Prescription($db->connect());
    $diag_id = $diags['diag_id'];;
    $presc->diag_id = $diags['diag_id'];
    $prescriptions = $presc->getPresciptions();
}
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
            <h1 class="h3 my-4 text-gray-800 text-center">Diagnosis For <?= $pname ?> </h1>

            <div class="card border-0 shadow container p-5" style="max-width: 500px;">

                <?php if($diagnosis){?>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" disabled
                            placeholder="Enter Diagnosis" value="<?php echo $diags['diagnosis']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" disabled>Add Diagnosis</button>
                </form>
            </div>

            <div class="container mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Medicine</th>
                            <th scope="col">Directions</th>
                            <th scope="col">Course</th>
                            <th scope="col">Instructions</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            while($row = $prescriptions->fetch_assoc()){
                                echo '<tr>';
                                echo '<td>';
                                echo $row['Presc_id'];
                                echo '</td>';
                                echo '<td>';
                                echo $row['Presc_medicine'];
                                echo '</td>';
                                echo '<td>';
                                echo $row['Presc_directions'];
                                echo '</td>';
                                echo '<td>';
                                echo $row['Presc_course'];
                                echo '</td>';
                                echo '<td>';
                                echo $row['Presc_instructions'];
                                echo '</td>';
                                echo '<td>';
                                echo '<button onclick="deleteAppointment('.$row['Presc_id'].','.$_GET['App_id'].')" class="btn btn-danger">Delete</button>';
                                echo '</td>';
                                echo '</tr>';
                            }

                        ?>
                    </tbody>
                </table>
                <a href="./prescription.php?diag_id=<?php echo $diag_id; ?>&app_id=<?php echo $_GET['App_id']; ?>"
                    class="btn btn-primary">Add Prescription</a>
                <a href="./report.php?App_id=<?php echo $_GET['App_id']; ?>" class="btn btn-primary">Generate Report</a>
            </div>

            <?php 
        } else { ?>
            <form method="POST" action="./add-diagnosis.php">
                <div class="form-group">
                    <input type="hidden" name="app_id" value="<?php echo $_GET['App_id']; ?>">
                    <input type="text" class="form-control" name="diagnosis" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Enter Diagnosis">
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Add Diagnosis</button>
            </form>
        </div>
        <?php } ?>


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
    <script>
    let urls = new URLSearchParams(window.location.search)
    let done = urls.get('done')
    if (done) {
        alert(urls.get('msg'))
    }
    const deleteAppointment = (id, app_id) => {
        let confirm = window.confirm("Are you sure want to delete ??")
        if (confirm)
            window.location.href = "./delete-prescription.php?Presc_id=" + id + "&app_id=" + app_id
    }
    </script>
</body>

</html>