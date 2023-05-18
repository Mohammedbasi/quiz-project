<?php
require_once 'configration.php';
$id = $_GET['id'];
$oldMark = $_GET['mark'];
$quizId = $_GET['quizId'];
$sql = "DELETE FROM question WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    $sql2 = "UPDATE quiz SET numOfQ = numOfQ - 1 , mark = mark - '$oldMark' WHERE id = '$quizId'";
    if (mysqli_query($conn, $sql2)) {
        header('location:editQues.php');
        exit();
    }
}
if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}
