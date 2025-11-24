<?php
function getDatabaseConnection() {
    $host = "localhost"; 
    $user = "root"; 
    $pass = ""; 
    $db   = "latihan1"; 
    
    $conn = mysqli_connect($host, $user, $pass, $db); 
    
    if (mysqli_connect_errno()) { 
        die("Koneksi database gagal: " . mysqli_connect_error()); 
    }
    
    return $conn;
}
?>