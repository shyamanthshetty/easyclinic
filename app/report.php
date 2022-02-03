<?php

session_start();



include_once "../models/Appointment.php";
include_once "../models/Users.php";
include_once "../models/Diagnosis.php";
include_once "../models/Doctor.php";
include_once "../models/Prescription.php";
include_once "../models/Patient.php";
include_once "../config/db.php";

$db = new Database();
$app = new Appointment($db->connect());
$pat = new Patient($db->connect());
$diag = new Diagnosis($db->connect());
$doc = new Doctor($db->connect());
$presc = new Prescription($db->connect());
$users = new Users($db->connect());

$app->App_id = $_GET['App_id'];
$app->updateAppointment();
$appointment = $app->getAppointment();
if(!$appointment){
    die("Invalid Report");
}
$pat->P_id = $appointment['P_id'];
$pdetails = $pat->getPatientDetails();
$doc->Doc_id = $appointment['Doc_id'];
$doc_details = $doc->getDoctor();
$diag->app_id = $_GET['App_id'];
$diagnosis = $diag->getDiagnosis();
if(!$diagnosis){
    die("Invalid Report");
}
$row = $diagnosis->fetch_assoc();
$diag_id = $row['diag_id'];
$presc->diag_id = $diag_id;
$prescriptions = $presc->getPresciptions();
$users->Doc_id = $appointment['Doc_id'];
$user_details = $users->getDetailsByDocId();

$pdetails = $pdetails->fetch_assoc();
$doc_details = $doc_details->fetch_assoc();
$user_details = $user_details->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png" />
    <link rel="manifest" href="../site.webmanifest" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
    <title>Report</title>
    <style>
    .box {
        /* background-color: red; */
        width: 21.59cm;
        /* height: 29.7cm; */
        /* margin: 30mm 45mm 30mm 45mm; */
        margin: 0 auto;
        border: 1px solid #000;
    }

    .clinic {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .img {

        display: flex;
        align-items: center;
        justify-content: center;
    }
    </style>
</head>

<body>
    <div class="box p-3 mt-5">
        <div class="row">
            <div class="col-sm-6">
                <img src="../static/images/2.png" alt="" srcset="" />
                <h4 class="text-capitalize"><?php echo $doc_details['Doc_name']; ?></h4>
                <h5 class="text-uppercase"><?php echo $doc_details['Doc_specialization']; ?></h5>
                <h5>Doc ID : <?php echo $doc_details['Doc_id']; ?></h5>
            </div>
            <div class="col-sm-6 clinic text-center">
                <h4 class="text-capitalize"><?php echo $user_details['U_clinic_name']; ?></h4>
                <h5><?php echo $user_details['U_email']; ?></h6>
            </div>
        </div>
        <hr />
        <div class="patients mt-5">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="text-capitalize">Patient Name : <span
                            class="font-weight-bold"><?php echo $pdetails['P_name'] ?></span></h5>
                    <h5>Patient Phone Number : <span
                            class="font-weight-bold"><?php echo $pdetails['P_contact'] ?></span></h5>
                    <h5>Patient ID : <span class="font-weight-bold"><?php echo $pdetails['P_id'] ?></span></h5>
                </div>

                <div class="col-sm-6 text-center font-weight-bold">
                    <h5>Date : <?php echo date('d-m-Y'); ?></h5>
                </div>
            </div>
        </div>
        <hr>
        <div class="tables mt-5">
            <h4>Prescription</h4>
            <table class="table mt-4 table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Medicine</th>
                        <th scope="col">Directions</th>
                        <th scope="col">Course</th>
                        <th scope="col">Instruction</th>
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
                        if($row['Presc_instructions'] === '1')
                            echo "Before Food";
                        else echo "After Food";
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
        <!-- <img src="https://chart.googleapis.com/chart?cht=qr&chs=200x300&chl=https://www.easyclinics.live" alt=""> -->
        <hr>
        <div class="signature mt-5">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="pt-3 text-capitalize"><?php echo $doc_details['Doc_name']; ?></h4>
                    <h5 class="text-uppercase"><?php echo $doc_details['Doc_specialization']; ?></h5>
                </div>
                <div class="col-sm-6 img">
                    <img src="https://chart.googleapis.com/chart?cht=qr&chs=200x100&chl=http://localhost/easyclinic/app/report.php?App_id=<?php echo $_GET['App_id'];?>"
                        alt="">
                </div>
            </div>
        </div>
        <hr>
        <div class="footer text-center">
            <span>For More Information contact <a href="mailto:<?php echo $user_details['U_email']; ?>"
                    class="text-dark"><?php echo $user_details['U_email']; ?></a>
            </span>
            <p>
                <a href="https://www.easyclinics.live">www.easyclinics.live</a>
            </p>
        </div>
    </div>
    <div class="btn text-center w-100 my-3">
        <button id="print" class="btn btn-primary">Print Report</button>
        <a href="./dashboard.php" class="btn btn-primary" id="dash">Dashboard</a>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
    integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
</script>
<script>
const btn = document.querySelector('#print')
const dash = document.querySelector('#dash')
btn.addEventListener('click', () => {
    btn.style.display = 'none';
    dash.style.display = 'none';
    window.print()
})
</script>

</html>