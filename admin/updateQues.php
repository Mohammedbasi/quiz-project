<?php
session_start();
require_once 'configration.php';
$id = $_GET['id'];
$sql = "SELECT * FROM question WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $question = $row['question'];
    $option1 = $row['option1'];
    $option2 = $row['option2'];
    $option3 = $row['option3'];
    $option4 = $row['option4'];
    $correct = $row['correct'];
    $mark = $row['mark'];
    $oldMark = $row['mark'];
    $quizId  = $row['quizId'];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $question = validiation($_POST['question']);
        $option1 = validiation($_POST['option1']);
        $option2 = validiation($_POST['option2']);
        $option3 = validiation($_POST['option3']);
        $option4 = validiation($_POST['option4']);
        $correct = validiation($_POST['correct']);
        $mark = validiation($_POST['mark']);
        $quizId = validiation($_POST['subject']);
        $errors = [];
        if (empty($question)) {
            $errors['question'] = "question is empty";
        }
        if (empty($option1)) {
            $errors['option1'] = "option1 is empty";
        }
        if (empty($option2)) {
            $errors['option2'] = "option2 is empty";
        }
        if (empty($option3)) {
            $errors['option3'] = "option3 is empty";
        }
        if (empty($option4)) {
            $errors['option4'] = "option4 is empty";
        }
        if (empty($correct)) {
            $errors['correct'] = "correct is empty";
        }
        if (empty($mark)) {
            $errors['mark'] = "mark is empty";
        }
        if (empty($quizId)) {
            $errors['quizId'] = "quizId is empty";
        }
        if (empty($errors)) {
            $sql = "UPDATE question SET question = '$question',option1='$option1',
                 option2 = '$option2',option3 = '$option3',
                option4 = '$option4',correct = '$correct',mark = '$mark',quizId = '$quizId' WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {
                $sql2 = "UPDATE quiz SET mark = mark - $oldMark + $mark WHERE id = '$quizId'";
                if (mysqli_query($conn, $sql2)) {
                    header('location:editQues.php');
                    exit();
                }
            }
        }
    }
} else {
    echo "Not found";
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
                    <h1 class="h3 mb-2 text-gray-800">Update Question</h1>
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
                                                        <textarea dir="rtl" name="question" placeholder="Question" class="form-control form-control-user"><?php echo $question ?></textarea>
                                                        <?php
                                                        isset($errors['question']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['question'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="option1" value="<?php echo $option1 ?>" class="form-control form-control-user" placeholder="option1">
                                                        <?php
                                                        isset($errors['option1']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['option1'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="option2" value="<?php echo $option2 ?>" class="form-control form-control-user" placeholder="option2">
                                                        <?php
                                                        isset($errors['option2']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['option2'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="option3" value="<?php echo $option3 ?>" class="form-control form-control-user" placeholder="option3">
                                                        <?php
                                                        isset($errors['option3']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['option3'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="option4" value="<?php echo $option4 ?>" class="form-control form-control-user" placeholder="option4">
                                                        <?php
                                                        isset($errors['option4']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['option4'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="correct" value="<?php echo $correct ?>" class="form-control form-control-user" placeholder="correct">
                                                        <?php
                                                        isset($errors['correct']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['correct'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="mark" value="<?php echo $mark ?>" class="form-control form-control-user" placeholder="mark">
                                                        <?php
                                                        isset($errors['mark']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['mark'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <span class="text-center">Subject</span>
                                                    <div class="form-group">
                                                        <select class="form-control form-control-user" name="subject">
                                                            <?php
                                                            $sql = "SELECT * FROM quiz";
                                                            $result = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                                    <option value="<?php echo $row['id'] ?>">
                                                                        <?php
                                                                        $sql1 = "SELECT * FROM subject WHERE id = " . $row['subjectId'];
                                                                        $result1 = mysqli_query($conn, $sql1);
                                                                        if (mysqli_num_rows($result1) == 1) {
                                                                            $row1 = mysqli_fetch_assoc($result1);
                                                                            $subjectName = $row1['name'];
                                                                            echo  $row['id'] . "  " . $subjectName;
                                                                        }
                                                                        ?> </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <?php
                                                        isset($errors['quizId']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['quizId'] . "</div>") : '';
                                                        ?>
                                                    </div>
                                                    <button class="btn btn-primary btn-user btn-block">Update</button>
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