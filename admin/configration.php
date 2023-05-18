<?php
$conn = mysqli_connect('localhost', 'root', '', 'webProject');
if (!$conn) {
    die("Error : " . mysqli_connect_errno());
}
