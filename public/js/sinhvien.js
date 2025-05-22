document.addEventListener('DOMContentLoaded', function() {
    // Logout button functionality
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                alert('Đã đăng xuất thành công!');
                // In a real application, this would redirect to the login page
                // window.location.href = 'login.html';
            }
        });
    }

    // Add current date to the page
    const today = new Date();
    const formattedDate = today.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
    
    // Create date display element
    const dateElement = document.createElement('div');
    dateElement.className = 'current-date text-end me-3 mt-2';
    dateElement.textContent = 'Ngày: ' + formattedDate;
    
    // Insert after header
    const header = document.querySelector('.header');
    if (header) {
        header.parentNode.insertBefore(dateElement, header.nextSibling);
    }

    // Simulate loading student data
    simulateLoading();
    
    // Project registration functionality
    // setupProjectRegistration(); //Commented out because it's not in the updates
});

function simulateLoading() {
    // Create loading overlay
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Đang tải...</span>
        </div>
        <p class="mt-2">Đang tải thông tin sinh viên...</p>
    `;
    
    // Style the overlay
    loadingOverlay.style.position = 'fixed';
    loadingOverlay.style.top = '0';
    loadingOverlay.style.left = '0';
    loadingOverlay.style.width = '100%';
    loadingOverlay.style.height = '100%';
    loadingOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    loadingOverlay.style.display = 'flex';
    loadingOverlay.style.flexDirection = 'column';
    loadingOverlay.style.justifyContent = 'center';
    loadingOverlay.style.alignItems = 'center';
    loadingOverlay.style.zIndex = '9999';
    
    // Add to body
    document.body.appendChild(loadingOverlay);
    
    // Remove after 1.5 seconds to simulate loading
    setTimeout(() => {
        loadingOverlay.style.opacity = '0';
        loadingOverlay.style.transition = 'opacity 0.5s';
        
        setTimeout(() => {
            document.body.removeChild(loadingOverlay);
        }, 500);
    }, 1500);
}
