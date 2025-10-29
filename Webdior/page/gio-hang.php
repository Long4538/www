<?php 
session_start();
$require_login = !isset($_SESSION['user_id']);
$base_url = '/Webdior';
if ($require_login) { header('Location: ' . $base_url . '/page/dang-nhap.php'); exit; }
$page_title = 'Giỏ hàng | Webdior';
require_once __DIR__ . '/../config/security.php';
$csrf_cart = csrf_generate_token('cart');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include '../includes/head.php'; ?>
</head>
<body class="bg-light">
    <?php include '../includes/header.php'; ?>

    <main class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/Webdior/">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h5 class="mb-3">Sản phẩm trong giỏ</h5>
                        <div id="cart-items"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h5 class="mb-3">Tóm tắt đơn hàng</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính</span>
                            <strong id="subtotal">0 ₫</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển</span>
                            <strong id="shipping">0 ₫</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Tổng cộng</span>
                            <strong id="grand">0 ₫</strong>
                        </div>
                        <a href="/Webdior/page/checkout.php" class="btn btn-dark w-100 mt-3">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
    <script>
    const csrfCart = '<?php echo htmlspecialchars($csrf_cart); ?>';
    function fmt(v){return new Intl.NumberFormat('vi-VN').format(v)+' \u20AB'}
    function loadCart(){
        fetch('/Webdior/api/cart-get.php')
            .then(r=>r.json())
            .then(data=>{
                const wrap=document.getElementById('cart-items');
                if(!data.items || data.items.length===0){
                    wrap.innerHTML='<div class="text-muted">Giỏ hàng trống.</div>';
                } else {
                    wrap.innerHTML=data.items.map(item=>`
                        <div class="d-flex align-items-center py-3 border-bottom" data-id="${item.id}">
                            <img src="${item.image || '/Webdior/images/products/placeholder.jpg'}" alt="${item.name}" width="64" height="64" class="me-3 object-fit-cover rounded">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">${item.name}</div>
                                <div class="text-muted small">Đơn giá: ${fmt(item.price)}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" min="0" value="${item.quantity}" class="form-control form-control-sm" style="width:84px">
                                <div class="text-end" style="width:120px">${fmt(item.total)}</div>
                                <button class="btn btn-outline-danger btn-sm">Xóa</button>
                            </div>
                        </div>
                    `).join('');
                }
                document.getElementById('subtotal').textContent=fmt(data.subtotal||0);
                document.getElementById('shipping').textContent=fmt(data.shipping||0);
                document.getElementById('grand').textContent=fmt(data.grand_total||0);
            });
    }
    document.addEventListener('click', function(e){
        if(e.target.matches('#cart-items button')){
            const row=e.target.closest('[data-id]');
            updateItem(row.dataset.id, 0);
        }
    });
    document.addEventListener('change', function(e){
        if(e.target.matches('#cart-items input[type="number"]')){
            const row=e.target.closest('[data-id]');
            const q=parseInt(e.target.value||'0',10);
            updateItem(row.dataset.id, q);
        }
    });
    function updateItem(id, quantity){
        const fd=new FormData();
        fd.append('csrf_token', csrfCart);
        fd.append('item_id', id);
        fd.append('quantity', quantity);
        fetch('/Webdior/api/cart-update.php', {method:'POST', body: fd})
            .then(r=>r.json()).then(_=>{ loadCart(); refreshCartBadge(); });
    }
    function refreshCartBadge(){
        fetch('/Webdior/api/cart-count.php').then(r=>r.json()).then(d=>{
            const badge=document.querySelector('[data-cart-badge]');
            if(badge) badge.textContent = d.count ?? 0;
        })
    }
    loadCart();
    </script>
</body>
</html>


