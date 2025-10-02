# Chú thích các class Bootstrap 5 sử dụng trong dự án Webdior

## Layout & Container
- `container`: Giới hạn chiều rộng tối đa và căn giữa nội dung
- `row`: Hàng trong hệ thống grid Bootstrap
- `col`: Cột tự động trong grid
- `col-lg-6`: Chiếm 6/12 cột trên màn hình large (≥992px)
- `col-md-4`: Chiếm 4/12 cột từ màn hình medium (≥768px)
- `g-3`, `g-4`: Gap (khoảng cách) giữa các cột trong grid
- `row-cols-1`: 1 cột mặc định
- `row-cols-2`: 2 cột mặc định  
- `row-cols-sm-2`: 2 cột từ màn hình small (≥576px)
- `row-cols-md-4`: 4 cột từ màn hình medium (≥768px)
- `row-cols-lg-4`: 4 cột từ màn hình large (≥992px)

## Navbar (Thanh điều hướng)
- `navbar`: Thanh điều hướng Bootstrap
- `navbar-expand-lg`: Mở rộng navbar từ màn hình large
- `navbar-light`: Giao diện navbar sáng
- `navbar-brand`: Logo/tên thương hiệu
- `navbar-toggler`: Nút hamburger menu trên mobile
- `navbar-nav`: Danh sách menu navbar
- `nav-item`: Mục trong menu
- `nav-link`: Liên kết menu
- `collapse`: Có thể thu gọn
- `navbar-collapse`: Thu gọn navbar trên mobile

## Dropdown Menu
- `dropdown`: Menu thả xuống
- `dropdown-toggle`: Mũi tên dropdown
- `dropdown-menu`: Menu thả xuống
- `dropdown-item`: Mục trong menu thả xuống
- `dropdown-divider`: Đường phân cách trong dropdown
- `dropdown-submenu`: Submenu cấp 2 (custom class)

## Display & Visibility
- `d-flex`: Hiển thị flex
- `d-block`: Hiển thị block
- `d-grid`: Hiển thị CSS Grid
- `d-none`: Ẩn mặc định
- `d-md-flex`: Hiển thị flex từ màn hình medium
- `visually-hidden`: Ẩn khỏi màn hình nhưng vẫn đọc được bởi screen reader

## Flexbox
- `align-items-center`: Căn giữa theo trục dọc
- `align-items-baseline`: Căn theo baseline
- `justify-content-between`: Căn đều 2 đầu
- `flex-wrap`: Cho phép xuống hàng khi hết chỗ

## Spacing (Khoảng cách)
- `p-2`, `p-3`: Padding 2, 3
- `py-3`, `py-4`, `py-5`: Padding top/bottom 3, 4, 5
- `px-0`: Padding left/right 0
- `m-0`: Margin 0
- `mb-0`, `mb-1`, `mb-2`, `mb-3`: Margin-bottom 0, 1, 2, 3
- `me-2`: Margin-end 2 (khoảng cách bên phải)
- `me-auto`: Margin-end auto (đẩy sang trái)
- `ms-2`: Margin-start 2 (khoảng cách bên trái)
- `gap-2`: Khoảng cách 2 giữa các phần tử flex

## Typography
- `display-5`: Font size lớn cấp 5
- `h3`, `h5`, `h6`: Kích thước heading 3, 5, 6
- `fw-semibold`: Font weight semi-bold
- `text-center`: Căn giữa chữ
- `text-secondary`: Màu chữ phụ

## Buttons
- `btn`: Nút cơ bản Bootstrap
- `btn-dark`: Nút nền tối
- `btn-outline-dark`: Nút viền tối
- `btn-sm`: Nút kích thước nhỏ

## Cards
- `card`: Thẻ Bootstrap
- `card-img-top`: Ảnh trên cùng của card
- `card-body`: Nội dung card
- `bg-transparent`: Nền trong suốt

## Borders & Rounded
- `border-0`: Không viền
- `border-top`: Viền trên
- `border-bottom`: Viền dưới
- `border-secondary-subtle`: Viền phụ nhạt
- `rounded-3`, `rounded-4`: Bo góc cấp 3, 4
- `rounded-pill`: Bo góc tròn như viên thuốc

## Background & Colors
- `bg-light`: Nền sáng
- `bg-transparent`: Nền trong suốt

## Badges
- `badge`: Huy hiệu
- `text-bg-secondary`: Nền và chữ màu phụ
- `rounded-pill`: Bo góc tròn như viên thuốc

## Form Controls
- `form-control`: Style input chuẩn Bootstrap

## Positioning
- `sticky-top`: Dính trên cùng khi scroll
- `h-100`: Chiều cao 100%

## Bootstrap JavaScript Attributes
- `data-bs-toggle="collapse"`: Kích hoạt collapse
- `data-bs-toggle="dropdown"`: Kích hoạt dropdown
- `data-bs-target="#mainNav"`: Mục tiêu để toggle
- `aria-labelledby`: Liên kết với label cho accessibility
- `aria-expanded`: Trạng thái mở rộng cho accessibility
- `role="button"`: Vai trò nút cho accessibility
- `role="search"`: Vai trò tìm kiếm cho accessibility

## Custom Classes (không phải Bootstrap)
- `hero`: Khu vực hero trang chủ
- `hero-card`: Thẻ trong hero
- `category-card`: Thẻ danh mục
- `product-card`: Thẻ sản phẩm
- `usp-item`: Mục giá trị nổi bật
- `price`: Giá sản phẩm
- `dropdown-submenu`: Submenu cấp 2

Tất cả các class này được sử dụng trong `index.php` và `page/gioi-thieu.php` để tạo layout responsive và giao diện đẹp mắt theo chuẩn Bootstrap 5.
