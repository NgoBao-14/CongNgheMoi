// Loading utility functions
const LoadingSpinner = {
    show: function(message = 'Đang xử lý...') {
        let overlay = document.getElementById('loadingOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-spinner">
                    <svg viewBox="25 25 50 50">
                        <circle r="20" cy="50" cx="50"></circle>
                    </svg>
                    <div class="loading-text">${message}</div>
                </div>
            `;
            document.body.appendChild(overlay);
        } else {
            overlay.querySelector('.loading-text').textContent = message;
        }
        overlay.classList.add('show');
    },
    
    hide: function() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.classList.remove('show');
        }
    },
    
    showForAction: function(action, message = 'Đang xử lý...') {
        this.show(message);
        return action().finally(() => {
            this.hide();
        });
    }
};

// Auto show loading for page navigation
window.addEventListener('beforeunload', function() {
    LoadingSpinner.show('Đang tải trang...');
});
