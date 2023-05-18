<?php
require_once 'configration.php';
$id = $_GET['id'];
$sql = "DELETE FROM student WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    header('location:editStudent.php');
    exit();
}
if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}
