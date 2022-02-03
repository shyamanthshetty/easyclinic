<?php

include_once "./models/Doctor.php";
include_once "./models/Users.php";
include_once "./config/db.php";

$db = new Database();
$doc = new Doctor($db->connect());
$users = new Users($db->connect());

if(!isset($_GET['acc_id']) && $_SERVER['REQUEST_METHOD'] === 'GET') die("Invalid Account ID");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $users->U_id = $_GET['acc_id'];
    if(!$users->validateUId())
        die("invalid id");
    $Doc = $users->getDocId();
    if(!empty($Doc['Doc_id'])){
        header("location:login.php?msg=ff");
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $doc->Doc_name = $_POST['name'];
    $doc->Doc_contact = $_POST['contact'];
    $doc->Doc_specialization = $_POST['quali'];
    if($doc->addDoctor()){
        $users->U_id = $_POST['acc_id'];
        $users->Doc_id = $doc->Doc_id;
        if($users->updateDocId())
            header("location:login.php?done=1&msg=Account%20created%20Successfully.Please%20Login%20to%20Continue");
        else {
            die("dA");
        };
    }
    else header("location:login.php?msg=fuck");
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <title>Login Page</title>
    <style>
    * {
        font-family: "Poppins", sans-serif;
    }

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
                        <a class="nav-link" aria-current="page" href="./login.php">Clinic Login</a>
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
                <h5 class="card-title text-center mb-3">Doctor Info</h5>
                <form action="get-started.php" method="POST">
                    <input type="hidden" name="acc_id" value="<?php echo $_GET['acc_id'];?>">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                        <input type="text" class="form-control" placeholder="name" aria-label="Username" name="name"
                            required aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
                        <input type="tel" class="form-control" placeholder="contact no." aria-label="Username" required
                            name="contact" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-mortarboard-fill"></i></span>
                        <input type="text" class="form-control" placeholder="qualification" aria-label="Username"
                            name="quali" required aria-describedby="basic-addon1">
                    </div>



                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Add <i
                                class="bi bi-box-arrow-in-right"></i></button>
                    </div>

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