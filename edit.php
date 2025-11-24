<?php
include_once __DIR__ . '/../../config/database.php';

$conn = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) { 
    $id = $_POST['id']; 
    $nama = $_POST['nama']; 
    $kategori = $_POST['kategori']; 
    $harga_jual = $_POST['harga_jual']; 
    $harga_beli = $_POST['harga_beli']; 
    $stok = $_POST['stok']; 
    $file_gambar = $_FILES['file_gambar']; 
    $gambar = null; 
     
    if ($file_gambar['error'] == 0) { 
        $filename = str_replace(' ', '_', $file_gambar['name']); 
        $destination = dirname(__DIR__, 2) . '/gambar/' . $filename; 
        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) { 
            $gambar = 'gambar/' . $filename;
        }
    } 
 
    $sql = 'UPDATE data_barang SET '; 
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', "; 
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' "; 
    if (!empty($gambar)) 
        $sql .= ", gambar = '{$gambar}' "; 
    $sql .= "WHERE id_barang = '{$id}'"; 
    $result = mysqli_query($conn, $sql); 
 
    header('Location: index.php?page=list'); 
    exit;
} 
 
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?page=list');
    exit;
}

$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'"; 
$result = mysqli_query($conn, $sql); 

if (!$result || mysqli_num_rows($result) === 0) {
    echo '<div class="alert alert-error">Data barang tidak ditemukan</div>';
    exit;
}

$data = mysqli_fetch_array($result); 
 
function is_select($var, $val) { 
    return $var == $val ? 'selected="selected"' : ''; 
} 
?>

<div class="form-section">
    <div class="section-header">
        <h2>✏️ Edit Barang</h2>
        <a href="index.php?page=list" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <div class="form-container">
        <form method="post" action="index.php?page=edit" enctype="multipart/form-data" class="product-form">
            <input type="hidden" name="id" value="<?php echo $data['id_barang']; ?>">
            
            <div class="form-group">
                <label for="nama">📝 Nama Barang</label>
                <input type="text" id="nama" name="nama" required class="form-input" 
                       value="<?php echo htmlspecialchars($data['nama']); ?>">
            </div>

            <div class="form-group">
                <label for="kategori">🏷️ Kategori</label>
                <select id="kategori" name="kategori" required class="form-input">
                    <option value="Komputer" <?php echo is_select('Komputer', $data['kategori']); ?>>💻 Komputer</option>
                    <option value="Elektronik" <?php echo is_select('Elektronik', $data['kategori']); ?>>🔌 Elektronik</option>
                    <option value="Hand Phone" <?php echo is_select('Hand Phone', $data['kategori']); ?>>📱 Hand Phone</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="harga_beli">💰 Harga Beli</label>
                    <input type="number" id="harga_beli" name="harga_beli" required class="form-input" 
                           value="<?php echo $data['harga_beli']; ?>">
                </div>

                <div class="form-group">
                    <label for="harga_jual">🏷️ Harga Jual</label>
                    <input type="number" id="harga_jual" name="harga_jual" required class="form-input" 
                           value="<?php echo $data['harga_jual']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="stok">📦 Stok</label>
                <input type="number" id="stok" name="stok" required class="form-input" 
                       value="<?php echo $data['stok']; ?>">
            </div>

            <div class="form-group">
                <label for="file_gambar">🖼️ Gambar Barang</label>
                <?php if (!empty($data['gambar'])): ?>
                <div class="current-image">
                    <img src="<?php echo $data['gambar']; ?>" alt="Current image" class="product-image-preview">
                    <small>Gambar saat ini</small>
                </div>
                <?php endif; ?>
                <input type="file" id="file_gambar" name="file_gambar" class="form-input" accept="image/*">
                <small class="form-help">Biarkan kosong jika tidak ingin mengubah gambar</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary btn-large">💾 Update Barang</button>
                <a href="index.php?page=list" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php mysqli_close($conn); ?>