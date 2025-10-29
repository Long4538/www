# Kế hoạch phát triển Webdior

Tài liệu này tổng hợp các chức năng còn thiếu và đề xuất cải thiện theo mức ưu tiên, kèm các bước thực thi tiếp theo.

## Ưu tiên cao

- Bảo mật/Đăng nhập
  - Thêm đổi mật khẩu, quên mật khẩu (reset qua email)
  - Xác thực email sau đăng ký
  - CSRF token cho các form (đăng nhập, đăng ký, admin)
  - Tùy chọn "Đăng xuất mọi thiết bị"

- Tài khoản khách hàng
  - Trang cập nhật hồ sơ (họ tên, điện thoại, địa chỉ)
  - Sổ địa chỉ (mặc định + nhiều địa chỉ)
  - Lịch sử đơn hàng, chi tiết đơn hàng và trạng thái (pending/confirmed/shipping/delivered/cancelled)

- Sản phẩm & Hiển thị
  - Bổ sung dữ liệu thật cho `product_images` và hiển thị gallery ở `page/san-pham.php`
  - Liên quan sản phẩm: tự động theo danh mục/brand nếu chưa có `related_products`

- Giỏ hàng & Thanh toán
  - Giỏ hàng (session/DB), cập nhật số lượng, tổng tiền, hiển thị counter ở header
  - Trang giỏ hàng, mã giảm giá, tính phí ship
  - Trang checkout (COD trước), tạo đơn hàng, email xác nhận

- Quản trị (Admin)
  - CRUD danh mục/brand đầy đủ
  - Quản lý nhiều ảnh sản phẩm, đánh dấu ảnh chính
  - Quản lý tồn kho, bật/tắt hiển thị, gắn "nổi bật"
  - Quản lý đơn hàng (đổi trạng thái, ghi chú), phân quyền admin/staff

## Ưu tiên trung bình

- API/Backend
  - Chuẩn hóa format tiền tệ (VND) cả server & client
  - Chuẩn hóa lỗi API, thêm logging server
  - Tách cấu hình `.env` (DB, mail) cho dev/prod

- UI/UX
  - Chuyển hướng sau đăng nhập về trang trước hoặc `tai-khoan.php`
  - Breadcrumb đồng nhất; trang 404/500
  - Loader/trạng thái "đang tải" khi gọi API
  - Cải thiện responsive menu; accessibility (alt ảnh, focus, contrast)

- Danh sách sản phẩm
  - Bộ lọc theo giới tính, giá, nồng độ, dung tích; sắp xếp theo giá/mới
  - Phân trang danh sách sản phẩm

## SEO & Hiệu năng

- Meta title/description theo từng sản phẩm; Open Graph
- Tạo `sitemap.xml`, `robots.txt`
- Tối ưu ảnh (lazy-load, nén), cache headers cho static assets
- Prefetch/preconnect cho các endpoint quan trọng

## Kiểm thử & Dữ liệu

- Seed dữ liệu mẫu: brands, categories, 5–8 sản phẩm có đủ `product_images`
- Kiểm thử form (server + client)
- Migration script để đồng bộ schema DB

## 3 bước tiếp theo đề xuất

1. Hoàn thiện ảnh sản phẩm: thêm bản ghi `product_images` cho 4–5 sản phẩm (mỗi sp 3–4 ảnh), cập nhật gallery `san-pham.php` dùng dữ liệu thật
2. Làm giỏ hàng cơ bản: thêm vào giỏ, xem giỏ, cập nhật số lượng, tổng tiền; hiển thị count trên icon header
3. Thêm "Quên mật khẩu" và "Đổi mật khẩu" (email reset token)

---

Người phụ trách: Chủ dự án Webdior  
Cập nhật: Tự động bởi trợ lý


