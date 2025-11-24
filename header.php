<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="assets/style.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-overlay"></div>
    <div class="container">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <header class="main-header">
            <div class="logo">
                <h1>🛍️ InventoryPro</h1>
            </div>
            <nav class="main-nav">
                <a href="index.php?page=dashboard" class="nav-link">📊 Dashboard</a>
                <a href="index.php?page=list" class="nav-link">📦 Data Barang</a>
                <a href="index.php?page=add" class="nav-link">➕ Tambah Barang</a>
                <a href="modules/auth/logout.php" class="nav-link logout">🚪 Logout</a>
            </nav>
        </header>
        <?php endif; ?>
        
        <main class="main-content">