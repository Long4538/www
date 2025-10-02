<?php
// Lấy tên trang hiện tại để đánh dấu active
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$page_dir = basename(dirname($_SERVER['PHP_SELF']));

// Xác định đường dẫn gốc
$base_url = '/Webdior';
?>

<!-- Header / Thanh điều hướng (Navbar - Bootstrap) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top border-bottom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_url; ?>/">
            <img src="<?php echo $base_url; ?>/images/logoDior.png" alt="Dior Logo" height="28" class="me-2">
            <span class="visually-hidden">Webdior</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'gioi-thieu') ? 'active' : ''; ?>" 
                       href="<?php echo $base_url; ?>/page/gioi-thieu.php">Giới thiệu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#bo-suu-tap" id="dropdownCollections" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bộ sưu tập</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownCollections">
                        <li><a class="dropdown-item" href="#nuoc-hoa-nam">Nước hoa nam</a></li>
                        <li><a class="dropdown-item" href="#nuoc-hoa-nu">Nước hoa nữ</a></li>
                        <li><a class="dropdown-item" href="#unisex">Unisex</a></li>
                        <li><a class="dropdown-item" href="#body-spray">Body spray</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#tin-tuc">Tin tức</a></li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'lien-he') ? 'active' : ''; ?>" 
                       href="<?php echo $base_url; ?>/page/lien-he.php">Liên hệ</a>
                </li>
            </ul>
            <form class="d-none d-md-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm mùi hương..." aria-label="Tìm kiếm">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="d-flex align-items-center gap-2 ms-2">
                <a href="#" class="text-dark" title="Giỏ hàng" style="position: relative;">
                    <i class="fas fa-shopping-cart fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">0</span>
                </a>
                <a href="<?php echo $base_url; ?>/page/dang-nhap.php" class="text-dark" title="Đăng nhập">
                    <i class="fas fa-user fs-5"></i>
                </a>
                <a href="<?php echo $base_url; ?>/page/lien-he.php" class="btn btn-dark btn-sm ms-2">Liên hệ tư vấn</a>
            </div>
        </div>
    </div>
</nav>
