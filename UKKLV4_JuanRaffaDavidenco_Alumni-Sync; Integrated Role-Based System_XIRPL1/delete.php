<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM alumni WHERE id_alumni='$id'");

header("Location: dashboard_admin.php");