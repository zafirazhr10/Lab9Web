<?php
include_once 'config/database.php';
$conn = getDatabaseConnection();

// Get statistics with error handling
$totalItems = 0;
$totalValue = 0;
$lowStock = 0;

$result1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_barang");
if ($result1) {
    $totalItems = mysqli_fetch_assoc($result1)['total'];
}

$result2 = mysqli_query($conn, "SELECT SUM(harga_beli * stok) as total FROM data_barang");
if ($result2) {
    $totalValue = mysqli_fetch_assoc($result2)['total'] ?? 0;
}

$result3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_barang WHERE stok < 10");
if ($result3) {
    $lowStock = mysqli_fetch_assoc($result3)['total'];
}
?>

<div class="dashboard">
    <div class="welcome-section">
        <h2>🎉 Selamat Datang, <?php echo $_SESSION['username'] ?? 'Admin'; ?>!</h2>
        <p>Kelola inventory barang Anda dengan mudah dan efisien</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3>Total Barang</h3>
                <span class="stat-number"><?php echo $totalItems; ?></span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>Total Nilai Inventory</h3>
                <span class="stat-number">Rp <?php echo number_format($totalValue, 0, ',', '.'); ?></span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-info">
                <h3>Stok Menipis</h3>
                <span class="stat-number"><?php echo $lowStock; ?></span>
            </div>
        </div>
    </div>
    
    <div class="quick-actions">
        <h3>⚡ Quick Actions</h3>
        <div class="action-buttons">
            <a href="index.php?page=add" class="btn btn-primary">
                ➕ Tambah Barang Baru
            </a>
            <a href="index.php?page=list" class="btn btn-secondary">
                📋 Lihat Semua Barang
            </a>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>