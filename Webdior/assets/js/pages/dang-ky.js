// JavaScript cho trang đăng ký (dang-ky.php)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="/Webdior/register-process.php"]');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');

    // Validation mật khẩu
    function validatePassword() {
        const passwordValue = password.value;
        const confirmValue = confirmPassword.value;
        
        // Xóa class cũ
        password.classList.remove('is-valid', 'is-invalid');
        confirmPassword.classList.remove('is-valid', 'is-invalid');
        
        // Kiểm tra độ dài mật khẩu
        if (passwordValue.length > 0) {
            if (passwordValue.length >= 6) {
                password.classList.add('is-valid');
            } else {
                password.classList.add('is-invalid');
            }
        }
        
        // Kiểm tra xác nhận mật khẩu
        if (confirmValue.length > 0) {
            if (confirmValue === passwordValue && passwordValue.length >= 6) {
                confirmPassword.classList.add('is-valid');
            } else {
                confirmPassword.classList.add('is-invalid');
            }
        }
    }

    // Validation email
    function validateEmail() {
        const emailValue = email.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        email.classList.remove('is-valid', 'is-invalid');
        
        if (emailValue.length > 0) {
            if (emailRegex.test(emailValue)) {
                email.classList.add('is-valid');
            } else {
                email.classList.add('is-invalid');
            }
        }
    }

    // Validation số điện thoại
    function validatePhone() {
        const phoneValue = phone.value;
        const phoneRegex = /^[0-9+\-\s()]+$/;
        
        phone.classList.remove('is-valid', 'is-invalid');
        
        if (phoneValue.length > 0) {
            if (phoneRegex.test(phoneValue)) {
                phone.classList.add('is-valid');
            } else {
                phone.classList.add('is-invalid');
            }
        }
    }

    // Event listeners
    if (password) password.addEventListener('input', validatePassword);
    if (confirmPassword) confirmPassword.addEventListener('input', validatePassword);
    if (email) email.addEventListener('input', validateEmail);
    if (phone) phone.addEventListener('input', validatePhone);

    // Form submission validation
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Kiểm tra tất cả trường bắt buộc
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            // Kiểm tra mật khẩu
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }
            
            // Kiểm tra email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng kiểm tra lại thông tin đã nhập!');
            }
        });
    }

    // Xóa dữ liệu session khi user bắt đầu nhập
    if (form) {
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (window.location.search.includes('error')) {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            });
        });
    }
});
