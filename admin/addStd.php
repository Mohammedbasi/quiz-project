<?php
session_start();
require_once 'configration.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = validiation($_POST['name']);
    $email = validiation($_POST['email']);
    $password = validiation($_POST['password']);
    $passwordConfi = validiation($_POST['passwordConfi']);
    $errors = [];
    if (empty($name)) {
        $errors['name'] = "Name is empty";
    }
    if (empty($email)) {
        $errors['email'] = "Email is empty";
    }
    if (empty($password)) {
        $errors['password'] = "Password is empty";
    }
    if (empty($passwordConfi)) {
        $errors['passwordConfi'] = "Confirmation is empty";
    }
    if ($password != $passwordConfi) {
        $errors['passwordConfi'] = "Passwords Not equal";
    }
    if (strlen($password) < 8) {
        $errors['password'] = "Password is short";
    }
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($email === $row['email']) {
                $errors['email'] = "Email is exist";
                break;
            }
        }
    }
    if (empty($errors)) {
        $sql = "INSERT INTO student(name,email,password) VALUES('$name','$email','$password')";
        if (mysqli_query($conn, $sql)) {
            header('location:editStudent.php');
            exit();
        }
    }
}

if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}

function validiation($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    return $input;
}
if (isset($_POST['logout'])) {
    if (!empty($_SESSION['login'])) {
        session_destroy();
        header('location:index.php');
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Home.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
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
                <a class="nav-link" href="editStudent.php">
                    <span>Students</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="editSubject.php">
                    <span>Subjects</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="editQuiz.php">
                    <span>Quizes</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="editQues.php">
                    <span>Questions</span></a>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name'] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a> -->
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
                    <h1 class="h3 mb-2 text-gray-800">Add Student</h1>
                    <!-- Outer Row -->
                    <div class="row justify-content-center">

                        <div class="col-xl-10 col-lg-12 col-md-9">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <div class="p-5">
                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="user">
                                                    <div class="form-group">
                                                        <input type="text" value="<?php isset($name) ? print($name) : '' ?>" name="name" class="form-control form-control-user" placeholder="Enter Student Name">
                                                        <?php
                                                        isset($errors['name']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['name'] . "</div>") : '';
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="email" value="<?php isset($email) ? print($email) : '' ?>" name="email" class="form-control form-control-user" placeholder="Enter Student Email">
                                                        <?php
                                                        isset($errors['email']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['email'] . "</div>") : '';
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="password" value="<?php isset($password) ? print($password) : '' ?>" name="password" class="form-control form-control-user" placeholder="Enter Student Password">
                                                        <?php
                                                        isset($errors['password']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['password'] . "</div>") : '';
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="password" value="<?php isset($passwordConfi) ? print($passwordConfi) : '' ?>" name="passwordConfi" class="form-control form-control-user" placeholder="Password Confirmation">
                                                        <?php
                                                        isset($errors['passwordConfi']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['passwordConfi'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <button class="btn btn-primary btn-user btn-block">Add</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>