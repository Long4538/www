<?php
// Xác định đường dẫn gốc
$base_url = '/Webdior';

// Xác định file JS tương ứng với trang hiện tại
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$js_file = '';

switch($current_page) {
    case 'index':
        $js_file = 'trang-chu.js';
        break;
    case 'dang-nhap':
        $js_file = 'dang-nhap.js';
        break;
    case 'dang-ky':
        $js_file = 'dang-ky.js';
        break;
    case 'gioi-thieu':
        $js_file = 'gioi-thieu.js';
        break;
    case 'lien-he':
        $js_file = 'lien-he.js';
        break;
    default:
        $js_file = 'trang-chu.js'; // Mặc định
}
?>

<!-- Gói JS Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Dropdown Debug & Fix -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 Checking Bootstrap...');
    
    // Kiểm tra Bootstrap có load không
    if (typeof bootstrap === 'undefined') {
        console.error('❌ Bootstrap JavaScript CHƯA LOAD!');
        return;
    } else {
        console.log('✅ Bootstrap JavaScript đã load');
    }

    // Kiểm tra dropdown elements
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    console.log('🎯 Tìm thấy', dropdownToggles.length, 'dropdown toggles');

    // Khởi tạo Bootstrap dropdowns một cách rõ ràng
    dropdownToggles.forEach(function(toggle, index) {
        console.log('🔧 Khởi tạo dropdown', index + 1);
        try {
            new bootstrap.Dropdown(toggle);
        } catch (error) {
            console.error('❌ Lỗi khởi tạo dropdown:', error);
        }
    });

    // Smooth scroll cho anchor links (không ảnh hưởng dropdown)
    document.querySelectorAll('a[href^="#"]:not(.dropdown-toggle)').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const target = document.querySelector(href);
            if (target && href !== '#') {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Email validation tiếng Việt
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(function(input) {
        input.addEventListener('invalid', function(e) {
            if (this.validity.typeMismatch) {
                this.setCustomValidity('Vui lòng nhập đúng định dạng email (có chứa @)');
            } else if (this.validity.valueMissing) {
                this.setCustomValidity('Vui lòng nhập email');
            }
        });
        
        input.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });

    // Debug events
    document.addEventListener('show.bs.dropdown', function(e) {
        console.log('🔓 Dropdown đang mở:', e.target);
    });
    
    document.addEventListener('shown.bs.dropdown', function(e) {
        console.log('✅ Dropdown đã mở:', e.target);
    });

    document.addEventListener('hide.bs.dropdown', function(e) {
        console.log('🔒 Dropdown đang đóng:', e.target);
    });
});
</script>

<!-- JS cho trang hiện tại -->
<script src="<?php echo $base_url; ?>/js/<?php echo $js_file; ?>"></script>
