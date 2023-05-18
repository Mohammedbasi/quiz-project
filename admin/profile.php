<?php
session_start();
if (!empty($_SESSION['login'])) {
    $emailSe = $_SESSION['email'];
    $conn = mysqli_connect('localhost', 'root', '', 'webProject');
    if (!$conn) {
        die("Error : " . mysqli_connect_errno());
    } else {
        $sql = "SELECT * FROM admin WHERE email = '$emailSe'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $id1 = $row['id'];
            $name1 = $row['name'];
            $email1 = $row['email'];
            $password1 = $row['password'];
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $name = validiation($_POST['name']);
                $email = validiation($_POST['email']);
                $password = validiation($_POST['password']);
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
                $sqll = "SELECT * FROM admin";
                $resultt = mysqli_query($conn, $sqll);
                if (mysqli_num_rows($resultt) > 0) {
                    while ($roww = mysqli_fetch_assoc($resultt)) {
                        if ($roww['email'] == $emailSe) {
                            continue;
                        } elseif ($roww['email'] == $email) {
                            $errors['email'] = "Email is Exist";
                            break;
                        }
                    }
                }
                if (empty($errors)) {
                    $sql2 = "UPDATE admin SET name = '$name',email = '$email',password = '$password' WHERE email = '$emailSe'";
                    if (mysqli_query($conn, $sql2)) {
                        $_SESSION['email'] = $email;
                        $_SESSION['password'] = $password;
                        $_SESSION['name'] = $name;
                        $_SESSION['update'] = "Updated Sucessfully";

                        header('location:profile.php');
                    }
                }
            }
        } else {
            echo "Not fount";
        }
    }
}

if (isset($_POST['logout'])) {
    if (!empty($_SESSION['login'])) {
        session_destroy();
        session_unset();
        header('location:index.php');
        exit();
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
                        <h1 class="h3 mb-0 text-gray-800">Admin Information</h1>
                    </div>
                    <div class="row">
                        <!-- id Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ID</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $id1 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- name Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                name</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $name1 ?></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- email Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">email
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $email1 ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- password Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                password</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $password1 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                        <input type="text" name="name" class="form-control form-control-user" placeholder="Enter New Name">
                                                        <?php
                                                        isset($errors['name']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['name'] . "</div>") : '';
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="email" name="email" class="form-control form-control-user" placeholder="Enter New Email">
                                                        <?php
                                                        isset($errors['email']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['email'] . "</div>") : '';
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Enter New Password">
                                                        <?php
                                                        isset($errors['password']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['password'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <button class="btn btn-primary btn-user btn-block">Save</button>
                                                    <?php
                                                    isset($_SESSION['update']) ? print("<div class = 'text-center' style = 'color:green' >" . $_SESSION['update'] . "</div>") : '';
                                                    ?>
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
</body>

</html>