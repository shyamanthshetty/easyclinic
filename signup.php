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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>Sign up</title>
    <style>
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
            <a class="navbar-brand" href="#">EasyClinics</a>
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
                        <a class="nav-link active" aria-current="page" href="#">Clinic Signup</a>
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
                <h5 class="card-title text-center mb-3">Register</h5>
                <form action="create-user.php" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                        <input type="text" class="form-control" placeholder="User name" aria-label="Username"
                            name="name" aria-describedby="basic-addon1" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-shield-plus"></i></span>
                        <input type="text" class="form-control" placeholder="Clinic name" aria-label="Clinicname"
                            required name="clinic" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-open"></i></span>
                        <input type="text" class="form-control" placeholder="User Email" aria-label="Email" name="email"
                            required aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-lock2"></i></span>
                        <input type="password" class="form-control" placeholder="Password" aria-label="Username"
                            required name="password" aria-describedby="basic-addon1">
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" name="submit" class="btn btn-primary">Sign up <i
                                class="bi bi-box-arrow-in-right"></i></button>
                    </div>
                    <!-- <span>Dont have any account ? <a href="/">signup</a></span> -->
                </form>
            </div>
        </div>
    </div>
</body>

</html>