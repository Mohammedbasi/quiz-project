<?php
require_once 'configration.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM subject WHERE id = '$id'";
    if(mysqli_query($conn,$sql)){
        header('location:editSubject.php');
        exit;
    }else{
        echo "no";
    }
    if (!isset($_SESSION['login'])) {
        header('location:index.php');
        exit;
    }
