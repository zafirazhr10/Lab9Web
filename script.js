// ===== SYSTEM FUNCTIONS =====

// Konfirmasi sebelum menghapus data
function confirmDelete(message = 'Yakin ingin menghapus data ini?') {
    return confirm(message);
}

// Format angka ke format Rupiah
function formatRupiah(angka) {
    if (!angka) return 'Rp 0';
    return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
}

// Format angka input saat ketik
function formatRupiahInput(input) {
    // Hapus karakter selain angka
    let value = input.value.replace(/\D/g, '');
    
    // Format ke Rupiah
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        input.value = value;
    }
}

// Validasi form
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#f72585';
            isValid = false;
            
            // Hapus warning setelah user mulai mengetik
            input.addEventListener('input', function() {
                this.style.borderColor = '#dee2e6';
            });
        }
    });
    
    if (!isValid) {
        showNotification('Harap isi semua field yang wajib diisi!', 'error');
    }
    
    return isValid;
}

// Tampilkan notifikasi
function showNotification(message, type = 'info') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getNotificationIcon(type)}"></i>
        ${message}
        <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Style notifikasi
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Hapus otomatis setelah 5 detik
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Icon untuk notifikasi
function getNotificationIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Preview gambar sebelum upload
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <div style="text-align: center;">
                    <img src="${e.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 10px;">
                    <p style="font-size: 12px; color: #666;">${file.name}</p>
                </div>
            `;
        }
        
        reader.readAsDataURL(file);
    }
}

// Toggle password visibility
function togglePassword(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleBtn = document.getElementById(toggleId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        passwordInput.type = 'password';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
    }
}

// Search/filter table
function filterTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tr');
    
    input.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            
            rows[i].style.display = found ? '' : 'none';
        }
    });
}

// ===== INITIALIZATION =====

document.addEventListener('DOMContentLoaded', function() {
    // Auto-format input harga
    const hargaInputs = document.querySelectorAll('input[name="harga_jual"], input[name="harga_beli"]');
    hargaInputs.forEach(input => {
        input.addEventListener('blur', function() {
            formatRupiahInput(this);
        });
        
        input.addEventListener('focus', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    });
    
    // Validasi form submit
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
    
    // Tambahkan animasi pada card
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Inisialisasi search jika ada
    const searchInput = document.getElementById('searchInput');
    const dataTable = document.getElementById('dataTable');
    
    if (searchInput && dataTable) {
        filterTable('searchInput', 'dataTable');
    }
    
    // Konfirmasi logout
    const logoutBtn = document.querySelector('.btn-logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    }
});

// ===== LOADING STATE =====

// Tampilkan loading
function showLoading() {
    const loading = document.createElement('div');
    loading.id = 'globalLoading';
    loading.innerHTML = `
        <div style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        ">
            <div class="spinner"></div>
        </div>
    `;
    document.body.appendChild(loading);
}

// Sembunyikan loading
function hideLoading() {
    const loading = document.getElementById('globalLoading');
    if (loading) {
        loading.remove();
    }
}

// ===== API FUNCTIONS =====

// Simulasi API call dengan timeout
function apiCall(callback, delay = 1000) {
    showLoading();
    setTimeout(() => {
        callback();
        hideLoading();
    }, delay);
}

// ===== EXPORT FUNCTIONS =====
// Untuk penggunaan di global scope
window.confirmDelete = confirmDelete;
window.formatRupiah = formatRupiah;
window.formatRupiahInput = formatRupiahInput;
window.validateForm = validateForm;
window.showNotification = showNotification;
window.previewImage = previewImage;
window.togglePassword = togglePassword;
window.filterTable = filterTable;
window.showLoading = showLoading;
window.hideLoading = hideLoading;