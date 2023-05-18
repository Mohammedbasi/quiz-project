<?php
session_start();
require_once 'configration.php';
if (isset($_POST['logout'])) {
    if (!empty($_SESSION['stdLogin'])) {
        session_destroy();
        session_unset();
        header('location:index.php');
        exit();
    }
}
$name = $_SESSION['stdName'];
$stdId = $_SESSION['stdId'];
if (!isset($_SESSION['stdLogin'])) {
    header('location:index.php');
    exit;
}

if (!empty($_GET['flag2'])) {
    echo '<script>alert("You start this quiz previously")</script>';
}

if (isset($_POST['submit'])) {
    $_SESSION['quizId'] =  $_GET['quizId'];
    $id = $_GET['quizId'];
    $sqll = "SELECT * FROM answers";
    $resultt = mysqli_query($conn, $sqll);
    if (mysqli_num_rows($resultt) > 0) {
        while ($roww = mysqli_fetch_assoc($resultt)) {
            if ($roww['stdId'] == $stdId && $roww['quizId'] == $id) {
                $flag2 = "no";
                header("location:quiz.php?flag2=$flag2");
                exit;
            }
        }
    }

    $sql = "SELECT * FROM quiz WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $time = $row['time'];
        setcookie("time", "20", time() + $time * 60);
        header('location:startQuiz.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('layout/header.php');
?>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Student</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="Home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item active">
                <a class="nav-link" href="subject.php">
                    <span>Subjects</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="quiz.php">
                    <span>Quizes</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name ?></span>
                                <img class="img-profile rounded-circle" src="../admin/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
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
                        <h1 class="h3 mb-0 text-gray-800">Quizes</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Subject</th>
                                            <th>Mark</th>
                                            <th>NumOfQ</th>
                                            <th>Time</th>
                                            <th>Start</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $sql = "SELECT * FROM quiz q , stdSub s WHERE q.subjectId = s.subjectId and s.studentId = " . $_SESSION['stdId'];
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php
                                                        $sql2 = "SELECT * FROM subject WHERE id =" . $row['subjectId'];
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        if (mysqli_num_rows($result2) == 1) {
                                                            $row2 = mysqli_fetch_assoc($result2);
                                                            $subjectName = $row2['name'];
                                                            echo $subjectName;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['mark'] ?></td>
                                                    <td><?php echo $row['numOfQ'] ?></td>
                                                    <td><?php echo $row['time'] ?></td>
                                                    <td>
                                                        <?php
                                                        $_SESSION['quizId'] =  $row['id'];

                                                        ?>
                                                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?quizId=" . $row['id'] ?>" method="POST">
                                                            <button name="submit" class="btn btn-success btn-circle"><i class="fas fa-check"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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