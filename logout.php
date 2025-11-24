<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - InventoryPro</title>
    <link href="../assets/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="logout-container">
        <div class="logout-message">
            <h2>✅ Logout Berhasil</h2>
            <p>Anda akan diarahkan ke halaman login...</p>
            <div class="loading-spinner"></div>
        </div>
    </div>
    
    <script>
        // Redirect setelah 2 detik
        setTimeout(function() {
            window.location.href = '../index.php';
        }, 2000);
    </script>
</body>
</html>