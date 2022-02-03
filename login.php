<?php

include_once "./models/Users.php";
include_once "./config/db.php";

$db = new Database();
$user = new Users($db->connect());

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $user->U_email = $_POST['email'];
        if($user->getDetailsByEmail()){
            if(password_verify($_POST['password'],$user->U_password)){
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $user->U_name;
                $_SESSION['clinic'] = $user->U_clinic_name;
                $_SESSION['doc_id'] = $user->Doc_id;
                header("location:./app/dashboard.php");
            }
            echo "<script>alert('Invalid Password')</script>";
        }
        echo "<script>alert('Invalid Email Address')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png" />
    <link rel="manifest" href="./site.webmanifest" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <title>Login Page</title>
    <style>
    * {
        font-family: "Poppins", sans-serif;
    }

    .box {
        width: 100%;
        height: 100vh;
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="" href="#"><img src="./static/images/4.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Clinic Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./user-login.php">User Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./signup.php">Clinic Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./user-signup.php">User Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="box">
        <div class="card mx-auto">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">Login</h5>
                <form action="login.php" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                        <input type="email" class="form-control" placeholder="Email Address" name="email">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-lock2"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Login <i
                                class="bi bi-box-arrow-in-right"></i></button>
                    </div>
                    <!-- <span>Dont have any account ? <a href="/">signup</a></span> -->
                </form>
            </div>
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