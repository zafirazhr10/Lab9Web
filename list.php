<?php
include_once __DIR__ . '/../../config/database.php';

$conn = getDatabaseConnection();
$sql = 'SELECT * FROM data_barang'; 
$result = mysqli_query($conn, $sql); 
?>

<div class="data-section">
    <div class="section-header">
        <h2>📦 Data Barang Inventory</h2>
        <a href="index.php?page=add" class="btn btn-primary">➕ Tambah Barang</a>
    </div>

    <div class="table-container">
        <table class="data-table"> 
            <thead>
                <tr> 
                    <th>Gambar</th> 
                    <th>Nama Barang</th> 
                    <th>Kategori</th> 
                    <th>Harga Beli</th> 
                    <th>Harga Jual</th> 
                    <th>Stok</th> 
                    <th>Aksi</th> 
                </tr> 
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?> 
                <?php while($row = mysqli_fetch_array($result)): ?> 
                <tr> 
                    <td class="image-cell">
                        <?php if(!empty($row['gambar'])): ?>
                            <img src="<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>" class="product-image">
                        <?php else: ?>
                            <div class="no-image">📷</div>
                        <?php endif; ?>
                    </td> 
                    <td><?php echo htmlspecialchars($row['nama']); ?></td> 
                    <td><span class="category-badge"><?php echo htmlspecialchars($row['kategori']); ?></span></td> 
                    <td class="price">Rp <?php echo number_format($row['harga_beli'], 0, ',', '.'); ?></td> 
                    <td class="price">Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></td> 
                    <td class="stock <?php echo $row['stok'] < 10 ? 'low-stock' : ''; ?>">
                        <?php echo $row['stok']; ?>
                    </td> 
                    <td class="actions">
                        <a href="index.php?page=edit&id=<?php echo $row['id_barang']; ?>" class="btn-edit">✏️ Edit</a>
                        <a href="modules/user/delete.php?id=<?php echo $row['id_barang']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Yakin ingin menghapus barang ini?')">🗑️ Hapus</a>
                    </td> 
                </tr> 
                <?php endwhile; ?> 
                <?php else: ?> 
                <tr> 
                    <td colspan="7" class="no-data">
                        <div class="empty-state">
                            <h3>📭 Tidak ada data barang</h3>
                            <p>Belum ada data barang yang ditambahkan.</p>
                            <a href="index.php?page=add" class="btn btn-primary">➕ Tambah Barang Pertama</a>
                        </div>
                    </td> 
                </tr> 
                <?php endif; ?> 
            </tbody>
        </table>
    </div>
</div>

<?php mysqli_close($conn); ?>