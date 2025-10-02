<?php
// Xác định đường dẫn gốc
$base_url = '/Webdior';

// Thiết lập title mặc định nếu không được định nghĩa
if (!isset($page_title)) {
    $page_title = 'Webdior - Nước hoa chính hãng';
}

// Xác định trang hiện tại để đường dẫn CSS chính xác
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$css_path = ($current_dir == 'page') ? '../assets/css/style.css' : 'assets/css/style.css';
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- CSS Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- CSS tuỳ chỉnh của dự án -->
<link rel="stylesheet" href="<?php echo $css_path; ?>">
<!-- Biểu tượng trang (Favicon) -->
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url; ?>/images/logoDior.png?v=1">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $base_url; ?>/images/logoDior.png?v=1">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>/images/logoDior.png?v=1">
