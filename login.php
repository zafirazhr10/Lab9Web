<?php
// Simple authentication (you can replace with database authentication)
if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple hardcoded authentication (replace with database check)
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php?module=user&action=dashboard');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>🔐 Login ke Sistem</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <form method="post" class="login-form">
            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Masukkan username" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="password">🔒 Password</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Masukkan password" class="form-input">
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">
                🚀 Login
            </button>
        </form>
        
        <div class="login-demo">
            <p><strong>Demo Account:</strong> admin / admin</p>
        </div>
    </div>
</div>