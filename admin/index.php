<?php
session_start();

// DB Connection
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = mysqli_connect('localhost', 'root', '', 'webProject');
    if (!$conn) {
        die("Error : " . mysqli_connect_errno());
    } else {
        $email = validiation($_POST['email']);
        $password = validiation($_POST['password']);
        $errors = [];
        if (empty($email)) {
            $errors['email'] = "Email is empty";
        }
        if (empty($password)) {
            $errors['password'] = "Password is empty";
        }
        if (empty($errors)) {
            $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    // echo 'name';
                    // die();
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['login'] = 'true';
                    header('location:Home.php');
                    exit();
                } else {
                    echo "Not found";
                }
            } else {
                die("Error : " . mysqli_error($conn));
            }
        }
    }
}
if (isset($_SESSION['login'])) {
    header('location:Home.php');
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

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-login-image {
            background-image: url('login.png');
            background-size: 250%;
            background-repeat: no-repeat;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Admin!</h1>
                                    </div>
                                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                            <?php
                                            isset($errors['email']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['email'] . "</div>") : '';
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                            <?php
                                            isset($errors['password']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['password'] . "</div>") : '';
                                            ?>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>