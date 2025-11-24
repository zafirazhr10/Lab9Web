<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Default routing to login if not authenticated
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $page = 'login';
    $pageTitle = 'Login - InventoryPro';
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
}

// Set page titles
$pageTitles = [
    'dashboard' => 'Dashboard - InventoryPro',
    'list' => 'Data Barang - InventoryPro',
    'add' => 'Tambah Barang - InventoryPro', 
    'edit' => 'Edit Barang - InventoryPro',
    'login' => 'Login - InventoryPro'
];

$pageTitle = $pageTitles[$page] ?? 'InventoryPro';

// Include header
include 'views/header.php';

// Routing logic
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Show login for non-authenticated users
    include 'modules/auth/login.php';
} else {
    // Show requested page for authenticated users
    switch($page) {
        case 'dashboard':
            include 'views/dashboard.php';
            break;
        case 'list':
            include 'modules/user/list.php';
            break;
        case 'add':
            include 'modules/user/add.php';
            break;
        case 'edit':
            include 'modules/user/edit.php';
            break;
        default:
            include 'views/dashboard.php';
    }
}


// Include footer
include 'views/footer.php';
?>