<?php
session_start();
if (isset($_POST['logout'])) {
    if (!empty($_SESSION['stdLogin'])) {
        session_destroy();
        session_unset();
        header('location:index.php');
        exit();
    }
}
if (!isset($_SESSION['stdLogin'])) {
    header('location:index.php');
    exit;
}

require_once 'configration.php';

$name = $_SESSION['stdName'];
$quizId = $_SESSION['quizId'];
$page = $_GET['page'] ?? 1;
$offset = $page - 1;
$counter = $_GET['counter'] ?? 0;
$stdId = $_SESSION['stdId'];



$sql = "SELECT * FROM question WHERE quizId = '$quizId' limit 1 offset $offset";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM question WHERE quizId = '$quizId'";
$result1 = mysqli_query($conn, $sql1);
$i = mysqli_num_rows($result1) + 1;

$sec = "30";
$myPage = $_SERVER['PHP_SELF'] . "?page=" . $page;

++$page;


if (($page > ($i))) {
    header('location:result.php');
}
if (mysqli_num_rows($result) > 0) {
    $questions = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $flag = 0;
    $option = $_POST['option'];
    $questionId = $_POST['questionId'];
    $sql4 = "SELECT * FROM question WHERE id = '$questionId'";
    $result4 = mysqli_query($conn, $sql4);
    $row = mysqli_fetch_assoc($result4);
    $mark = 0;
    if ($option == $row['correct']) {
        $flag = 1;
        $mark = $row['mark'];
    }
    $sql2 = "INSERT INTO answers VALUES ('$stdId','$quizId','$questionId','$option','$flag','$mark')";
    mysqli_query($conn, $sql2);
}
if (!isset($_COOKIE['time'])) {
    header('location:result.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="<?php echo $sec ?>;URL='<?php echo $myPage ?>'">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name
                                                                                            ?></span>
                                <img class="img-profile rounded-circle" src="../admin/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <form action="" method="POST">
                                    <button name="logout" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h1 mb-0 text-gray-800">Quiz Started</h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php print $page - 1 . "- " .  $questions['question'] ?></h1>
                    </div>

                    <form action="<?php echo $_SERVER['PHP_SELF'] .  "?page=" . $page ?>" method="POST">
                        <input type="hidden" name="questionId" value="<?php echo $questions['id'] ?>">

                        <div class="form-group">
                            <input required id="op1" type="radio" name="option" value="<?php echo $questions['option1'] ?>">
                            <span style="display:inline-block; width:7px;"></span>
                            <label for="op1"><?php echo $questions['option1'] ?></label>
                        </div>

                        <div class="form-group">
                            <input required id="op2" type="radio" name="option" value="<?php echo $questions['option2'] ?>">
                            <span style="display:inline-block; width:7px;"></span>
                            <label for="op2"><?php echo $questions['option2'] ?></label>
                        </div>

                        <div class="form-group">
                            <input required id="op3" type="radio" name="option" value="<?php echo $questions['option3'] ?>">
                            <span style="display:inline-block; width:7px;"></span>
                            <label for="op3"><?php echo $questions['option3'] ?></label>
                        </div>

                        <div class="form-group">
                            <input required id="op4" type="radio" name="option" value="<?php echo $questions['option4'] ?>">
                            <span style="display:inline-block; width:7px;"></span>
                            <label for="op4"><?php echo $questions['option4'] ?></label>
                        </div>
                        <input type="submit" name="next" value="Next" class="btn btn-primary btn-user">

                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Mohammed Basil 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php
    include('layout/footer.php');
    ?>
</body>

</html>