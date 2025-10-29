// JavaScript cho trang sản phẩm
// File này sẽ chứa các chức năng tương tác cho trang chi tiết sản phẩm

document.addEventListener('DOMContentLoaded', function() {
    console.log('📦 Trang sản phẩm đã load');
    
    // Thay đổi hình ảnh chính khi click vào thumbnail
    const thumbnailImages = document.querySelectorAll('.thumbnail-image');
    const mainImage = document.getElementById('main-product-image');
    
    thumbnailImages.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            // Xóa border active từ tất cả thumbnails
            thumbnailImages.forEach(function(img) {
                img.classList.remove('border-primary');
                img.classList.add('border');
            });
            
            // Thêm border active cho thumbnail được click
            this.classList.remove('border');
            this.classList.add('border-primary');
            
            // Thay đổi hình ảnh chính
            mainImage.src = this.src;
            mainImage.alt = this.alt;
        });
    });
    
    // Thêm vào giỏ hàng
    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');
            const qtyInput = document.getElementById('product-quantity-input');
            const quantity = Math.max(1, parseInt(qtyInput?.value || '1', 10));
            if (!productId) return;
            const fd = new FormData();
            fd.append('csrf_token', window.CART_CSRF || '');
            fd.append('product_id', productId);
            fd.append('quantity', String(quantity));
            fetch('/Webdior/api/cart-add.php', { method: 'POST', body: fd })
              .then(r => r.json())
              .then(res => {
                if (res.requires_login) {
                  window.location.href = '/Webdior/page/dang-nhap.php';
                  return;
                }
                if (!res.success) {
                  alert(res.message || 'Không thể thêm vào giỏ hàng');
                  return;
                }
                const badge = document.querySelector('[data-cart-badge]');
                if (badge) badge.textContent = res.count ?? 0;
                // Hiệu ứng visual
                addToCartBtn.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm!';
                addToCartBtn.classList.remove('btn-outline-dark');
                addToCartBtn.classList.add('btn-success');
                setTimeout(() => {
                  addToCartBtn.innerHTML = 'Thêm vào giỏ hàng';
                  addToCartBtn.classList.remove('btn-success');
                  addToCartBtn.classList.add('btn-outline-dark');
                  // Điều hướng sang giỏ hàng
                  window.location.href = '/Webdior/page/gio-hang.php';
                }, 600);
              })
              .catch(() => alert('Lỗi mạng. Vui lòng thử lại.'));
        });
    }
    
    // Mua ngay
    const buyNowBtn = document.getElementById('buy-now');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // TODO: Thêm logic mua ngay
            console.log('⚡ Mua ngay');
            alert('Chức năng mua ngay sẽ được phát triển sau!');
        });
    }
    
    // Xử lý nút tăng/giảm số lượng
    const quantityInput = document.getElementById('product-quantity-input');
    const minusButton = document.getElementById('button-minus');
    const plusButton = document.getElementById('button-plus');

    if (quantityInput && minusButton && plusButton) {
        minusButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
    }
    
    // Load dữ liệu sản phẩm từ URL parameter hoặc database
    loadProductData();
});

// Hàm load dữ liệu sản phẩm
function loadProductData() {
    // Lấy ID sản phẩm từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    
    console.log('📊 Loading product data for ID:', productId);
    console.log('🔗 Current URL:', window.location.href);
    console.log('🔍 URL Parameters:', window.location.search);
    
    if (!productId) {
        console.warn('⚠️ Không có ID sản phẩm trong URL');
        return;
    }
    
    // Gọi API để lấy dữ liệu sản phẩm từ database
    const apiUrl = `/Webdior/api/get-product.php?id=${productId}`;
    console.log('🌐 API URL:', apiUrl);
    
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            console.log('📦 API Response:', data);
            if (data.success) {
                console.log('📋 Product data:', data.data.product);
                // Populate dữ liệu từ database
                populateProductInfo(data.data.product);
                // Cập nhật hình ảnh từ API (hoặc fallback từ main_image)
                populateProductImages(data.data.images, data.data.product);
                console.log('✅ Product data loaded from database');
            } else {
                console.error('❌ API Error:', data.error);
                throw new Error(data.error || 'Không thể load dữ liệu sản phẩm');
            }
        })
        .catch(error => {
            console.error('❌ Error loading product from database:', error);
            // Hiển thị thông báo lỗi thay vì fallback
            showProductError(productId, error.message);
        });
}

// Hàm hiển thị lỗi sản phẩm
function showProductError(productId, errorMessage) {
    console.error('❌ Product Error for ID:', productId, 'Message:', errorMessage);
    
    // Hiển thị thông báo lỗi
    document.getElementById('product-name').textContent = 'Lỗi tải sản phẩm';
    document.getElementById('product-price').textContent = '0₫';
    document.getElementById('product-full-description').innerHTML = `
        <div class="alert alert-danger">
            <h5>❌ Không thể tải thông tin sản phẩm</h5>
            <p><strong>ID sản phẩm:</strong> ${productId}</p>
            <p><strong>Lỗi:</strong> ${errorMessage}</p>
            <p><strong>Giải pháp:</strong></p>
            <ul>
                <li>Kiểm tra kết nối database</li>
                <li>Kiểm tra sản phẩm có tồn tại không</li>
                <li>Kiểm tra API endpoint</li>
            </ul>
            <p><a href="/Webdior/test-api.php?id=${productId}" target="_blank" class="btn btn-primary">Test API</a></p>
        </div>
    `;
}

// Hàm load dữ liệu mẫu (fallback)
function loadSampleData(productId) {
    console.log('📊 Loading sample data for ID:', productId);
    
    // Dữ liệu mẫu theo ID (fallback khi không có database)
    const productsData = { };
    
    const productData = productsData[productId];
    
    if (productData) {
        // Populate dữ liệu vào các elements
        populateProductInfo(productData);
        console.log('✅ Sample product data loaded successfully');
    } else {
        console.error('❌ Product not found for ID:', productId);
        // Hiển thị thông báo lỗi
        document.getElementById('product-name').textContent = 'Sản phẩm không tồn tại';
        document.getElementById('product-price').textContent = '0₫';
    }
}

// Hàm populate thông tin sản phẩm
function populateProductInfo(data) {
    console.log('🔄 Populating product info with data:', data);
    
    // Cập nhật thông tin cơ bản
    const nameElement = document.getElementById('product-name');
    if (nameElement) {
        nameElement.textContent = data.name;
        console.log('✅ Updated product name:', data.name);
    } else {
        console.error('❌ Element product-name not found');
    }
    
    // Xử lý category (có thể là object hoặc string)
    const categoryText = data.category ? 
        (typeof data.category === 'object' ? data.category.name : data.category) : 
        'Nước hoa Nước hoa nam';
    document.getElementById('product-category').textContent = categoryText;
    
    // Xử lý product_code/sku
    const productCode = data.product_code || data.sku || 'DIOR001';
    document.getElementById('product-sku').textContent = productCode;
    
    // Xử lý price (có thể đã được format hoặc chưa)
    const priceText = data.price.includes(',') ? data.price : numberFormat(data.price);
    const priceElement = document.getElementById('product-price');
    if (priceElement) {
        priceElement.textContent = priceText + '₫';
        console.log('✅ Updated product price:', priceText + '₫');
    } else {
        console.error('❌ Element product-price not found');
    }
    
    // Cập nhật dung tích và nồng độ
    document.getElementById('product-volume-display').textContent = data.volume || '-';
    document.getElementById('product-concentration-display').textContent = data.concentration || '-';
    
    // Cập nhật thuộc tính sản phẩm
    const brandName = data.brand ? 
        (typeof data.brand === 'object' ? data.brand.name : data.brand) : 
        'DIOR';
    document.getElementById('attr-brand').textContent = brandName;
    document.getElementById('attr-concentration').textContent = data.concentration || '-';
    document.getElementById('attr-duration').textContent = data.duration || '-';
    document.getElementById('attr-sillage').textContent = data.sillage || '1 sải tay';
    document.getElementById('attr-gender').textContent = data.gender || '-';
    
    // Cập nhật mô tả
    const description = data.description || data.full_description || '<!-- Nội dung mô tả sẽ được load từ database -->';
    document.getElementById('product-full-description').innerHTML = description;
}

// Hàm populate hình ảnh sản phẩm (main + thumbnails)
function populateProductImages(images, product) {
    const mainImageEl = document.getElementById('main-product-image');
    const thumbnailEls = document.querySelectorAll('.thumbnail-image');

    // Xác định ảnh chính
    const mainFromList = Array.isArray(images) ? images.find(img => Number(img.is_main) === 1) : null;
    const mainSrc = (mainFromList && mainFromList.image_path) || product.main_image || '/Webdior/images/products/placeholder.jpg';
    const altText = product.name || 'Hình ảnh sản phẩm';

    if (mainImageEl) {
        mainImageEl.src = mainSrc;
        mainImageEl.alt = altText;
    }

    // Cập nhật tiêu đề trang theo tên sản phẩm
    if (product && product.name) {
        document.title = product.name + ' - DIOR';
    }

    // Chuẩn bị danh sách thumbnail tối đa 4 ảnh
    let thumbs = [];
    if (Array.isArray(images) && images.length > 0) {
        thumbs = images.slice(0, 4).map(img => ({
            src: img.image_path || mainSrc,
            alt: img.alt_text || altText
        }));
    }
    // Fallback: nếu không có danh sách ảnh, dùng ảnh chính cho tất cả thumbnail
    if (thumbs.length === 0) {
        thumbs = new Array(4).fill({ src: mainSrc, alt: altText });
    }

    // Gán vào DOM
    thumbnailEls.forEach((el, idx) => {
        const t = thumbs[idx];
        if (t) {
            el.src = t.src;
            el.alt = t.alt;
            el.classList.add('border');
            if (idx === 0) {
                el.classList.remove('border');
                el.classList.add('border-primary');
            }
        } else {
            el.closest('.col-3')?.classList.add('d-none');
        }
    });
}

// Hàm format số tiền
function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
