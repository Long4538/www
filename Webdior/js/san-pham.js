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
            // TODO: Thêm logic thêm vào giỏ hàng
            console.log('🛒 Thêm vào giỏ hàng');
            
            // Hiệu ứng visual
            this.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm!';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success');
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng';
                this.classList.remove('btn-success');
                this.classList.add('btn-primary');
            }, 2000);
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
    const productsData = {
        1: {
            name: 'Dior Sauvage EDT',
            brand: 'DIOR',
            price: '2,890,000',
            volume: '100ml',
            concentration: 'Eau de Toilette',
            gender: 'Nam',
            style: 'Tươi mát, nam tính',
            duration: '6-8h',
            sillage: '1 sải tay',
            category: 'Nước hoa Nước hoa nam',
            sku: 'DIOR001',
            description: 'Sauvage là một mùi hương nam tính và tươi mát, được tạo ra bởi nhà điều chế nước hoa François Demachy. Đây là một trong những sản phẩm nổi tiếng nhất của Dior, mang đến cảm giác tự do và hoang dã.',
        },
        2: {
            name: 'Miss Dior Blooming Bouquet',
            brand: 'DIOR',
            price: '3,150,000',
            volume: '100ml',
            concentration: 'Eau de Parfum',
            gender: 'Nữ',
            style: 'Nữ tính, tươi mát',
            duration: '4-6h',
            sillage: '1 sải tay',
            category: 'Nước hoa Nước hoa nữ',
            sku: 'DIOR002',
            description: 'Miss Dior Blooming Bouquet là một mùi hương nữ tính và tươi mát, được lấy cảm hứng từ những bông hoa nở rộ trong vườn. Mùi hương này thể hiện sự nữ tính và thanh lịch của phụ nữ hiện đại.',
            topNotes: ['Hoa hồng', 'Hoa nhài', 'Cam bergamot'],
            middleNotes: ['Hoa peony', 'Hoa lily', 'Hoa violet'],
            baseNotes: ['Gỗ trắng', 'Xạ hương', 'Vani']
        },
        3: {
            name: 'Dior Homme Intense',
            brand: 'DIOR',
            price: '3,490,000',
            volume: '100ml',
            concentration: 'Eau de Parfum',
            gender: 'Nam',
            style: 'Sang trọng, nam tính',
            duration: '8-10h',
            sillage: '1.5 sải tay',
            category: 'Nước hoa Nước hoa nam',
            sku: 'DIOR003',
            description: 'Dior Homme Intense là phiên bản đậm đà hơn của Dior Homme, mang đến sự sang trọng và nam tính. Mùi hương này phù hợp cho những dịp đặc biệt và buổi tối.',
            topNotes: ['Hoa oải hương', 'Cam bergamot', 'Hoa hồng'],
            middleNotes: ['Hoa iris', 'Gỗ cedar', 'Gỗ vetiver'],
            baseNotes: ['Xạ hương', 'Gỗ sandalwood', 'Vani']
        },
        4: {
            name: 'J\'adore Parfum d\'Eau',
            brand: 'DIOR',
            price: '3,990,000',
            volume: '100ml',
            concentration: 'Parfum',
            gender: 'Nữ',
            style: 'Sang trọng, quyến rũ',
            duration: '10-12h',
            sillage: '2 sải tay',
            category: 'Nước hoa Nước hoa nữ',
            sku: 'DIOR004',
            description: 'J\'adore Parfum d\'Eau là phiên bản cao cấp nhất của dòng J\'adore, mang đến sự sang trọng và quyến rũ tuyệt đối. Mùi hương này được tạo ra cho những phụ nữ tự tin và quyến rũ.',
            topNotes: ['Hoa ylang-ylang', 'Hoa nhài', 'Cam bergamot'],
            middleNotes: ['Hoa hồng', 'Hoa lily', 'Hoa violet'],
            baseNotes: ['Gỗ sandalwood', 'Xạ hương', 'Vani']
        },
        5: {
            name: 'Dior J\'adore EDP',
            brand: 'DIOR',
            price: '2,750,000',
            volume: '100ml',
            concentration: 'Eau de Parfum',
            gender: 'Nữ',
            style: 'Nữ tính, thanh lịch',
            duration: '6-8h',
            sillage: '1 sải tay',
            category: 'Nước hoa Nước hoa nữ',
            sku: 'DIOR005',
            description: 'J\'adore EDP là một mùi hương nữ tính và thanh lịch, được tạo ra để tôn vinh vẻ đẹp của phụ nữ. Mùi hương này kết hợp giữa sự tươi mát và quyến rũ.',
            topNotes: ['Hoa ylang-ylang', 'Hoa nhài', 'Cam bergamot'],
            middleNotes: ['Hoa hồng', 'Hoa lily', 'Hoa violet'],
            baseNotes: ['Gỗ sandalwood', 'Xạ hương', 'Vani']
        },
        6: {
            name: 'Miss Dior Rose N\'Roses',
            brand: 'DIOR',
            price: '3,300,000',
            volume: '100ml',
            concentration: 'Eau de Parfum',
            gender: 'Nữ',
            style: 'Lãng mạn, nữ tính',
            duration: '6-8h',
            sillage: '1 sải tay',
            category: 'Nước hoa Nước hoa nữ',
            sku: 'DIOR006',
            description: 'Miss Dior Rose N\'Roses là một mùi hương lãng mạn và nữ tính, được lấy cảm hứng từ những bông hoa hồng đẹp nhất. Mùi hương này thể hiện sự lãng mạn và nữ tính.',
            topNotes: ['Hoa hồng', 'Hoa peony', 'Cam bergamot'],
            middleNotes: ['Hoa lily', 'Hoa violet', 'Hoa iris'],
            baseNotes: ['Gỗ trắng', 'Xạ hương', 'Vani']
        },
        7: {
            name: 'Dior Sauvage Parfum',
            brand: 'DIOR',
            price: '4,150,000',
            volume: '100ml',
            concentration: 'Parfum',
            gender: 'Nam',
            style: 'Mạnh mẽ, nam tính',
            duration: '10-12h',
            sillage: '2 sải tay',
            category: 'Nước hoa Nước hoa nam',
            sku: 'DIOR007',
            description: 'Dior Sauvage Parfum là phiên bản đậm đà nhất của dòng Sauvage, mang đến sự mạnh mẽ và nam tính tuyệt đối. Mùi hương này phù hợp cho những dịp đặc biệt.',
            topNotes: ['Cam bergamot', 'Quả chanh vàng', 'Hoa oải hương'],
            middleNotes: ['Hoa nhài Sambac', 'Quế', 'Mật ong'],
            baseNotes: ['Cây thuốc lá', 'Đậu Tonka', 'Vani', 'Xạ hương']
        },
        8: {
            name: 'Dior Joy Intense',
            brand: 'DIOR',
            price: '3,650,000',
            volume: '100ml',
            concentration: 'Eau de Parfum',
            gender: 'Nữ',
            style: 'Vui tươi, năng động',
            duration: '6-8h',
            sillage: '1 sải tay',
            category: 'Nước hoa Nước hoa nữ',
            sku: 'DIOR008',
            description: 'Dior Joy Intense là một mùi hương vui tươi và năng động, được tạo ra để mang đến niềm vui và hạnh phúc. Mùi hương này thể hiện sự vui tươi và năng động của phụ nữ hiện đại.',
        }
    };
    
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
    
    // Không xử lý hương thơm
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
            // Ẩn thumbnail thừa nếu ít hơn 4 ảnh
            el.closest('.col-3')?.classList.add('d-none');
        }
    });
}


// Hàm format số tiền
function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

