<?php 

session_start();

if(!$_SESSION['logged_in']){
    header("location:../login.php");
}

if(!isset($_GET['diag_id'])){
    die('Invalid diag_id');
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
            <h1 class="h3 my-4 text-gray-800 text-center">Prescription</h1>

            <div class="card border-0 shadow container p-5" style="max-width: 500px;">
                <form action="./add-prescription.php?app_id=<?php echo $_GET['app_id']; ?>" method="POST">
                    <input type="hidden" name="diag_id" value="<?php echo $_GET['diag_id']; ?>">
                    <div class="form-group">
                        <input type="text" name="medicine" class="form-control" id="" placeholder="Enter Medicine"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="check">Directions</label><br />
                        Morining : <input type="checkbox" name="morning" value="1" id="">
                        Afternoon : <input type="checkbox" name="afternoon" value="2" id="">
                        Evening : <input type="checkbox" name="evening" value="3" id="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="course" class="form-control" id="" placeholder="Enter the no days"
                            pattern="\d" required>
                    </div>
                    <div class="form-group">
                        <select name="instructions" id="" class="form-control" required>
                            <option value="">-- Select Instructions --</option>
                            <option value="1">Before Food</option>
                            <option value="2">After Food</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="submit">Add Prescription</button>
                </form>
            </div>
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
</body>

</html>