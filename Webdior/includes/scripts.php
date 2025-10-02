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
<!-- JS cho trang hiện tại -->
<script src="<?php echo $base_url; ?>/js/<?php echo $js_file; ?>"></script>
