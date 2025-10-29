document.addEventListener('DOMContentLoaded', () => {
  const emailInput = document.getElementById('email');
  const icon = document.getElementById('email-check-icon');
  const submitBtn = document.getElementById('btn-submit');
  let lastChecked = '';

  function setIcon(state) {
    icon.className = 'position-absolute top-50 end-0 translate-middle-y me-3';
    if (state === 'ok') {
      icon.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
    } else if (state === 'fail') {
      icon.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
    } else if (state === 'loading') {
      icon.innerHTML = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
    } else {
      icon.innerHTML = '';
    }
  }

  function validateEmailFormat(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  }

  emailInput.addEventListener('blur', () => {
    const value = emailInput.value.trim();
    if (!validateEmailFormat(value)) {
      setIcon('fail');
      submitBtn.disabled = true;
      return;
    }
    if (value === lastChecked) return;
    lastChecked = value;
    setIcon('loading');
    fetch(`/Webdior/api/check-email.php?email=${encodeURIComponent(value)}`)
      .then(r => r.json())
      .then(res => {
        if (res.success && res.exists) {
          setIcon('ok');
          submitBtn.disabled = false;
        } else {
          setIcon('fail');
          submitBtn.disabled = true;
        }
      })
      .catch(() => {
        setIcon('fail');
        submitBtn.disabled = true;
      });
  });
});


