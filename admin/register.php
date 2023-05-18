<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = mysqli_connect('localhost', 'root', '', 'webProject');
    if (!$conn) {
        die("Error : " . mysqli_connect_errno());
    } else {
        $name = validiation($_POST['name']);
        $email = validiation($_POST['email']);
        $password = validiation($_POST['password']);
        $passwordConf = validiation($_POST['passwordConf']);
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
        if (strlen($password) < 8) {
            $errors['password'] = "Password is very short";
        }
        if (empty($passwordConf)) {
            $errors['passwordConf'] = "Password Confirmation is empty";
        }
        if ($password !== $passwordConf) {
            $errors['equal'] = "Doesn't equal";
        }
        $sql = "SELECT * FROM admin";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['email'] == $email) {
                    $errors['email'] = "Email is exist";
                    break;
                }
            }
        } else {
            echo "Not found";
        }
        if (empty($errors)) {
            $sql = "INSERT INTO admin(name,email,password) VALUES('$name','$email','$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header('location:index.php');
                exit();
            }
        }
    }
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

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create Admin Account!</h1>
                            </div>
                            <form class="user" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="form-group">
                                    <input type="text" value="<?php isset($name) ? print($name) : '' ?>" name="name" class="form-control form-control-user" id="exampleFirstName" placeholder="Name">
                                    <?php
                                    isset($errors['name']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['name'] . "</div>") : '';
                                    ?>
                                </div>
                                <div class="form-group">
                                    <input type="email" value="<?php isset($email) ? print($email) : '' ?>" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                                    <?php
                                    isset($errors['email']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['email'] . "</div>") : '';
                                    ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" value="<?php isset($password) ? print($password) : '' ?>" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        <?php
                                        isset($errors['password']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['password'] . "</div>") : '';
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" value="<?php isset($passwordConf) ? print($passwordConf) : '' ?>" name="passwordConf" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                                        <?php
                                        isset($errors['passwordConf']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['passwordConf'] . "</div>") : '';
                                        isset($errors['equal']) ? print("<div class = 'text-center' style = 'color:red' >" . $errors['equal'] . "</div>") : '';
                                        ?>
                                    </div>
                                </div>
                                <button name="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                                <hr>

                            </form>


                            <div class="text-center">
                                <a class="small" href="index.php">Already have an account? Login!</a>
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