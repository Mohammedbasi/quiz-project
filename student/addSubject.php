<?php
session_start();
require_once 'configration.php';
$subId = $_GET['id'];
if (isset($_SESSION['stdLogin'])) {
    $stdId = $_SESSION['stdId'];
}

$sql = "INSERT INTO stdSub(studentId,subjectId) VALUES('$stdId','$subId')";
if (mysqli_query($conn, $sql)) {
    header('location:subject.php');
    exit;
} else {
    $flag1 = "no";
    header("location:subject.php?flag1=$flag1");
    exit;
}
