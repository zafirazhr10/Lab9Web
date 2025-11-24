<?php
include_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) { 
    $conn = getDatabaseConnection();
    
    $nama = $_POST['nama']; 
    $kategori = $_POST['kategori']; 
    $harga_jual = $_POST['harga_jual']; 
    $harga_beli = $_POST['harga_beli']; 
    $stok = $_POST['stok']; 
    $file_gambar = $_FILES['file_gambar']; 
    $gambar = null; 
    
    if ($file_gambar['error'] == 0) { 
        $filename = str_replace(' ', '_',$file_gambar['name']); 
        $destination = dirname(__DIR__, 2) . '/gambar/' . $filename; 
        if(move_uploaded_file($file_gambar['tmp_name'], $destination)) { 
            $gambar = 'gambar/' . $filename;
        } 
    } 
    
    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) '; 
    $sql .= "VALUES ('{$nama}', '{$kategori}','{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')"; 
    $result = mysqli_query($conn, $sql); 
    header('Location: index.php?page=list');
    exit;
}
?>

<div class="form-section">
    <div class="section-header">
        <h2>➕ Tambah Barang Baru</h2>
        <a href="index.php?page=list" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <div class="form-container">
        <form method="post" action="index.php?page=add" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="nama">📝 Nama Barang</label>
                <input type="text" id="nama" name="nama" required class="form-input" placeholder="Masukkan nama barang">
            </div>

            <div class="form-group">
                <label for="kategori">🏷️ Kategori</label>
                <select id="kategori" name="kategori" required class="form-input">
                    <option value="">Pilih Kategori</option>
                    <option value="Komputer">💻 Komputer</option>
                    <option value="Elektronik">🔌 Elektronik</option>
                    <option value="Hand Phone">📱 Hand Phone</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="harga_beli">💰 Harga Beli</label>
                    <input type="number" id="harga_beli" name="harga_beli" required class="form-input" placeholder="Harga beli">
                </div>

                <div class="form-group">
                    <label for="harga_jual">🏷️ Harga Jual</label>
                    <input type="number" id="harga_jual" name="harga_jual" required class="form-input" placeholder="Harga jual">
                </div>
            </div>

            <div class="form-group">
                <label for="stok">📦 Stok</label>
                <input type="number" id="stok" name="stok" required class="form-input" placeholder="Jumlah stok">
            </div>

            <div class="form-group">
                <label for="file_gambar">🖼️ Gambar Barang</label>
                <input type="file" id="file_gambar" name="file_gambar" class="form-input" accept="image/*">
                <small class="form-help">Format: JPG, PNG, GIF (Maksimal 2MB)</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary btn-large">💾 Simpan Barang</button>
                <a href="index.php?page=list" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>