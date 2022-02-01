<?php

include_once "./config/db.php";
include_once "./models/Users.php";
include_once "./models/Appointment.php";

session_start();
if(!isset($_SESSION['user_in']))
    header("location:user-login.php");
    
$db = new Database();
$app = new Appointment($db->connect());
$user = new Users($db->connect());

$app->P_id = $_SESSION['user_id'];

$appointments = $app->getDiagnosedAppointmentsByPatientId();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>login</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background-color: #e5e5e5;
    }

    header {
        height: 56px;
        background-color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        margin-left: 50px;
        font-size: 26px;
        font-weight: bold;
        color: #05be92;
    }

    .sub-logo {
        color: #504f4f;
    }

    ul {
        margin-bottom: 0 !important;
    }

    .navs .links {
        display: flex;
    }

    .navs .links .link {
        padding: 0 20px;
        list-style: none;
    }

    .navs .links .link a {
        color: #504f4f;
        text-decoration: none;
    }

    .navs .links .link.active a {
        color: #05be92 !important;
    }

    .contain {
        width: 100%;
        /* height: calc(100vh - 56px); */
        margin-top: 50px;
    }

    .rounded {
        border-radius: 6px;
    }

    .card {
        max-width: 400px;
        /* display: flex; */
        /* justify-content: center; */
        /* align-items: center; */
        background-color: #fff;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        margin: 0 auto;
    }

    .card .title {
        color: #504f4f !important;
    }

    .btn-color {
        background-color: #05be92 !important;
        border: #05be92;
    }

    .btn-color:hover {
        background-color: #27b08f !important;
    }

    .btn-color:focus {
        box-shadow: 0 0 0 0.25rem rgb(39 176 143 / 50%) !important;
    }


    @media (max-width: 600px) {
        header {
            justify-content: space-around;
        }

        .hide-mob {
            display: none;
        }

        .navs .links {
            display: block;
        }

    }
    </style>
</head>

<body>
    <header>
        <div class="logo">EASY<span class="sub-logo">CLINIC</span></div>
        <nav class="navs">
            <ul class="links">
                <li class="link">
                    <a href="#" class="link-text hide-mob">Home</a>
                </li>
                <li class="link hide-mob">
                    <a href="./user-dashboard.php" class="link-text">Dashboard</a>
                </li>
                <li class="link active hide-mob">
                    <a href="#" class="link-text">History</a>
                </li>
                <li class="link">
                    <a href="./logout.php" class="link-text">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container mt-5">
        <h4 class="text-center">Your Appointments History</h4>

        <?php

        if($appointments){ ?>

        <table class="table table-striped mt-5 ">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Clinic</th>
                    <th scope="col">Timings</th>
                    <th scope="col">Report</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while($row = $appointments->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>';
                    echo $row['App_date'];
                    echo '</td>';
                    echo '<td>';
                    echo $user->getClinicName($row['Doc_id']);
                    echo '</td>';
                    echo '<td>';
                    if($row['App_time'] === '1')
                        echo '10am-12.30pm';
                    else if($row['App_time'] === '2')
                        echo '1.30pm-3.00pm';
                    else echo '4.00pm-6.30pm';
                    echo '</td>';
                    echo '<td>';
                    echo '<button onclick="deleteAppointment('.$row['App_id'].')" class="btn btn-success">Download</button>';
                    echo '</td>';
                    echo '</tr>';
                }

?>
            </tbody>
        </table>


        <?php } else{
            
            
        }?>

    </div>
    <script>
    </script>
</body>

</html>