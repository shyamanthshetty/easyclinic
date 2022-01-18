<?php

include_once "./models/Users.php";
include_once "./models/Patient.php";
include_once "./models/Appointment.php";
include_once "./config/db.php";

$db = new Database();
$user = new Users($db->connect());
$pat = new Patient($db->connect());
$app = new Appointment($db->connect());

$data = $user->clinics();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $pat->P_name = $_POST['name'];
        $pat->P_contact = $_POST['contact'];
        $pat->P_address = $_POST['address'];
    
        if($pat->addPatient()){
            $app->App_time = $_POST['time'];
            $app->App_date = $_POST['date'];
            $app->P_id = $pat->P_id;
            $user->U_id = $_POST['clinic'];
            $doc_id = $user->getDocId();
            $app->Doc_id = $doc_id['Doc_id'];
            if($app->addAppointment()){
                setcookie("ptn_id",$pat->P_id);
                echo '<script>alert("qfewf")</script>';
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <title>Login Page</title>
    <style>
    .box {
        width: 100%;
        height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border: 0;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EasyClinic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>

            </div>
        </div>
    </nav>


    <div class="box">
        <div class="card mx-auto">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Book an Appointment</h5>
                <form action="book-appointment.php" method="POST" class="px-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                        <input type="text" class="form-control" placeholder="Your name" aria-label="Username"
                            name="name" required aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                        <input type="tel" class="form-control" placeholder="Phone number" required name="contact"
                            minlength="10" maxlength="10">
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" required id="floatingTextarea" name="address"></textarea>
                        <label for="floatingTextarea">Address</label>
                    </div>
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

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i
                                class="bi bi-calendar-event-fill"></i></i></span>
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
                        <button type="submit" class="btn btn-primary" name="submit">Book</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>