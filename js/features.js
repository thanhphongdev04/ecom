
// Lưu vị trí cuộn khi người dùng cuộn
window.addEventListener('scroll', () => {
    localStorage.setItem('scrollPosition', window.scrollY);
});

// Thiết lập lại vị trí cuộn sau khi tải trang
document.addEventListener('DOMContentLoaded', () => {
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
        window.scrollTo(0, parseInt(scrollPosition, 10));
        localStorage.removeItem('scrollPosition');
    }
});

function autoSubmit() {
    const form = document.getElementById('form-autosubmit');
    form.submit();
}

window.onload = autoSubmit;