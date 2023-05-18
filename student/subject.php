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
require_once 'configration.php';
if (!isset($_SESSION['stdLogin'])) {
    header('location:index.php');
    exit;
}
$name = $_SESSION['stdName'];
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Home.php">
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name  ?></span>
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
                        <h1 class="h3 mb-0 text-gray-800">Subjects</h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h5 mb-0 text-gray-800">Press subject to get it quizes</h1>
                    </div>
                    <?php
                    if (!empty($_GET['flag1'])) {
                        echo '<script>alert("You register this course previously")</script>';
                    }
                    ?>
                    <div class="row">
                        <!-- Subjects Card Example -->
                        <?php
                        $sql = "SELECT * FROM subject";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="addSubject.php?id=<?php echo $row['id'] ?>" class="text-white stretched-link">
                                        <div class="card border-left-primary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                                            <?php echo $row['name'] ?></div>
                                                        <div class="h5 mb-0 font-weight-bold text-success "><?php echo $row['hours'] . " Hours" ?></div>
                                                        <div class="p mb-0 font-weight-bold text-gray-600">
                                                            <?php
                                                            $sql1 = "SELECT COUNT(subjectId) as quiz FROM quiz WHERE subjectId =" . $row['id'];
                                                            $result1 = mysqli_query($conn, $sql1);
                                                            if (mysqli_num_rows($result1) == 1) {
                                                                $row1 = mysqli_fetch_assoc($result1);
                                                                echo $row1['quiz'] . " Quizes";
                                                            }
                                                            ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-book fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
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