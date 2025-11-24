<?php
include_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id']; 
    $conn = getDatabaseConnection();
    $sql = "DELETE FROM data_barang WHERE id_barang = '{$id}'"; 
    $result = mysqli_query($conn, $sql); 
}

header('Location: index.php?page=list');
exit;
?>