<?php

include_once "./models/Patient.php";
include_once "./config/db.php";

$db = new Database();
$pat = new Patient($db->connect());

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $pat->P_contact = $_POST['contact'];
        if($pat->getDetailsByEmail()){
            if(password_verify($_POST['password'],$pat->P_password)){
                session_start();
                $_SESSION['user_in'] = true;
                $_SESSION['user_id'] = $pat->P_id;
                $_SESSION['user'] = $pat->P_name;
                header("location:user-dashboard.php");
            }
        }

        else{

        }
    }
}

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

    .box {
        width: 100%;
        height: calc(100vh - 56px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        max-width: 600px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .card .login {
        width: 50%;
        padding: 20px;
    }

    .card .login form {
        text-align: center;
        margin: 15px 0;
    }

    .card .login form .form-inp {
        margin: 10px 0;
        border: 0;
        border-bottom: 1px solid #504f4f;
        outline: none;
        padding: 5px;
        width: 100%;
    }

    .card .login form .form-submit {
        border: 0;
        outline: none;
        background-color: #3f3d56;
        padding: 8px;
        width: 100%;
        margin-top: 20px;
        color: #fff;
        cursor: pointer;
        transition: 0.2s;
    }

    .card .login form .form-submit:hover {
        background-color: #2f2e41;
    }

    .card .login form .form-submit:active {
        box-shadow: 0px 0px 9px;
        color: #3f3d56;
    }

    .card .login .login-text {
        text-align: center;
        font-size: 26px;
        color: #504f4f;
        font-weight: bold;
    }

    .card .img {
        width: 50%;
        padding: 15px;
    }

    .rouded {
        border-radius: 6px;
    }

    .inp-msg {
        display: none;
    }

    .text-small {
        font-size: 12px;
    }

    @media (max-width: 600px) {
        header {
            justify-content: space-around;
        }

        .hide-mob {
            display: none;
        }

        .logo {
            margin-left: 0;
        }

        .navs .links {
            display: block;
        }

        .box {
            padding: 0 20px;
        }

        .card .login {
            width: 100%;
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
                    <a href="#" class="link-text">Home</a>
                </li>
                <li class="link active">
                    <a href="#" class="link-text hide-mob">Login</a>
                </li>
                <li class="link">
                    <a href="./user-signup.php" class="link-text hide-mob">Signup</a>
                </li>
                <li class="link">
                    <a href="#" class="link-text hide-mob">Contact us</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="box">
        <div class="card rouded">
            <div class="login">
                <div class="login-text">LOGIN</div>
                <form action="user-login.php" method="POST">
                    <input type="text" name="contact" class="form-inp" placeholder="Enter Phone Number"
                        pattern="[0-9]{10}" required />
                    <input type="password" name="password" pattern="[A-Za-z0-9]{6,}" class="form-inp"
                        placeholder="Enter password" required />
                    <br />
                    <input type="submit" name="submit" class="form-submit rouded" value="login" />
                </form>
            </div>
            <div class="img hide-mob">
                <img src="./static/images/signup-bg.svg" alt="" />
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