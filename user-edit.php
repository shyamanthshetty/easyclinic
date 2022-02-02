<?php

include_once "./config/db.php";
include_once "./models/Patient.php";

session_start();
if(!isset($_SESSION['user_in']))
    header("location:user-login.php");
    
$db = new Database();
$pat = new Patient($db->connect());
$pat->P_id = $_SESSION['user_id'];
$patients = $pat->getPatientDetails();
$patients = $patients->fetch_assoc();
$passwd = $patients['P_password'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $pat->P_id = $_POST['id'];
        $pat->P_name = $_POST['name'];
        $pat->P_contact = $_POST['contact'];
        $pat->P_address = $_POST['address'];
        if(empty($_POST['password'])){
            $pat->P_password = $passwd;
        }else{
            $pat->P_password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        }

        if($pat->updatePatient()){
            header("location:./user-dashboard.php?done=1&msg=Account%20Updated%20Successfully");
        }else{
            header("location:./user-dashboard.php?done=1&msg=Something%20Went%20Wrong");
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
    <title>Edit User</title>
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
                <li class="link hide-mob">
                    <a href="./user-dashboard.php" class="link-text">Dashboard</a>
                </li>
                <li class="link hide-mob">
                    <a href="./user-history.php" class="link-text">History</a>
                </li>
                <li class="link hide-mob active">
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
            <h3 class="title text-center mt-4 mb-4">Edit User Info</h3>
            <form class="px-5 mb-3" method="post" action="./user-edit.php">
                <input type="hidden" name="id" value="<?php echo $patients['P_id']; ?>">
                <div class="mb-3">
                    <input type="text" class="form-control" required name="name"
                        value="<?php echo $patients['P_name']; ?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" required name="contact"
                        value="<?php echo $patients['P_contact']; ?>">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" required name="address"
                        value="<?php echo $patients['P_address']; ?>">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Enter new password"
                        pattern="[A-Za-z0-9]{6,}">
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-color" name="submit">Edit Info</button>
                </div>
            </form>

        </div>
    </div>


    <script>
    let urls = new URLSearchParams(window.location.search)
    let done = urls.get('done')
    if (done) {
        alert(urls.get('msg'))
    }
    </script>
</body>

</html>