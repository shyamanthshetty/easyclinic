<?php

include_once "./config/db.php";
include_once "./models/Users.php";
include_once "./models/Appointment.php";

session_start();
if(!isset($_SESSION['user_in']))
    header("location:user-login.php");
    
$db = new Database();
$user = new Users($db->connect());
$app = new Appointment($db->connect());
$data = $user->clinics();

$app->P_id = $_SESSION['user_id']; 
$app->App_date = date("Y-m-d");
$appointments = $app->getAppointmentsByPatientId();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $app->App_time = $_POST['time'];
        $app->App_date = $_POST['date'];
        $app->P_id = $_SESSION['user_id'];
        $user->U_id = $_POST['clinic'];
        $doc_id = $user->getDocId();
        $app->Doc_id = $doc_id['Doc_id'];
        if($app->addAppointment()){
            header("location:./user-dashboard.php?done=1&msg=Appointment%20Booked%20Successfully");
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png" />
    <link rel="manifest" href="./site.webmanifest" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Dashboard</title>
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
        <div class="logo">EASY<span class="sub-logo">CLINICS</span></div>
        <nav class="navs">
            <ul class="links">
                <li class="link">
                    <a href="#" class="link-text hide-mob">Home</a>
                </li>
                <li class="link active hide-mob">
                    <a href="#" class="link-text">Dashboard</a>
                </li>
                <li class="link hide-mob">
                    <a href="./user-history.php" class="link-text">History</a>
                </li>
                <li class="link hide-mob">
                    <a href="./user-edit.php" class="link-text">Edit Info</a>
                </li>
                <li class="link">
                    <a href="./logout.php" class="link-text">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="contain">
        <div class="card rounded">
            <h3 class="title text-center mt-4 mb-4">Book Appointment</h3>
            <form class="px-5 mb-3" method="post" action="./user-dashboard.php">
                <div class="form-floating mb-3">
                    <select class="form-select" name="clinic" required id="floatingSelect">
                        <option disabled selected value> -- select the clinic -- </option>
                        <?php 
                            while($row = $data->fetch_assoc()){
                                echo '<option value="'.$row['U_id'].'">'.$row['U_clinic_name'].'</option>';
                            }
                            ?>
                    </select>
                    <label for="floatingSelect">Clinic</label>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" placeholder="Select Date" required name="date"
                        min="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" name="time" required id="floatingSelect">
                        <option value="1" selected>10am-12.30pm</option>
                        <option value="2">1.30pm-3.00pm</option>
                        <option value="3">4.00pm-6.30pm</option>
                    </select>
                    <label for="floatingSelect">Select Time</label>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-color" name="submit">Book</button>
                </div>
            </form>

        </div>
    </div>

    <div class="container mt-4">
        <h4 class="text-center mb-3">Todays Appointments</h4>
        <?php if($appointments) {?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Clinic</th>
                    <th scope="col">Timing</th>
                    <th scope="col">Action</th>
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
                    echo '<button onclick="deleteAppointment('.$row['App_id'].')" class="btn btn-danger">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                ?>
            </tbody>
        </table>
        <?php } else {
            echo "<div class='m-3 text-center'>No Appointments as of Now</div>";
        }?>
    </div>
    <script>
    let urls = new URLSearchParams(window.location.search)
    let done = urls.get('done')
    if (done) {
        alert(urls.get('msg'))
    }
    const deleteAppointment = (id) => {
        let confirm = window.confirm("Are you sure want to delete ??")
        if (confirm)
            window.location.href = "./delete-appointment.php?App_id=" + id
    }
    </script>
</body>

</html>