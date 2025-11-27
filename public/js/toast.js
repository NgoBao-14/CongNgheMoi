// Toast Notification System
const Toast = {
    container: null,
    
    init: function() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'toastContainer';
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        }
    },
    
    show: function(message, type = 'info', duration = 3000) {
        this.init();
        
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type} toast-show`;
        
        const icon = this.getIcon(type);
        
        toast.innerHTML = `
            <div class="toast-icon">${icon}</div>
            <div class="toast-content">
                <div class="toast-title">${this.getTitle(type)}</div>
                <div class="toast-text">${message}</div>
            </div>
            <button class="toast-close" onclick="Toast.close(this.parentElement)">&times;</button>
        `;
        
        this.container.appendChild(toast);
        
        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.close(toast);
            }, duration);
        }
        
        return toast;
    },
    
    success: function(message, duration = 3000) {
        return this.show(message, 'success', duration);
    },
    
    error: function(message, duration = 4000) {
        return this.show(message, 'error', duration);
    },
    
    warning: function(message, duration = 3500) {
        return this.show(message, 'warning', duration);
    },
    
    info: function(message, duration = 3000) {
        return this.show(message, 'info', duration);
    },
    
    confirm: function(message, onConfirm, onCancel) {
        // Create modal overlay
        const overlay = document.createElement('div');
        overlay.className = 'toast-modal-overlay toast-modal-show';
        
        const modal = document.createElement('div');
        modal.className = 'toast-modal toast-modal-show';
        
        modal.innerHTML = `
            <div class="toast-modal-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="toast-modal-content">
                <div class="toast-modal-title">Xác nhận</div>
                <div class="toast-modal-text">${message}</div>
            </div>
            <div class="toast-modal-buttons">
                <button class="toast-modal-btn toast-modal-btn-cancel">Hủy</button>
                <button class="toast-modal-btn toast-modal-btn-confirm">Xác nhận</button>
            </div>
        `;
        
        overlay.appendChild(modal);
        document.body.appendChild(overlay);
        
        const btnConfirm = modal.querySelector('.toast-modal-btn-confirm');
        const btnCancel = modal.querySelector('.toast-modal-btn-cancel');
        
        const closeModal = () => {
            overlay.classList.remove('toast-modal-show');
            overlay.classList.add('toast-modal-hide');
            setTimeout(() => {
                if (overlay.parentElement) {
                    overlay.parentElement.removeChild(overlay);
                }
            }, 300);
        };
        
        btnConfirm.onclick = () => {
            closeModal();
            if (onConfirm) onConfirm();
        };
        
        btnCancel.onclick = () => {
            closeModal();
            if (onCancel) onCancel();
        };
        
        overlay.onclick = (e) => {
            if (e.target === overlay) {
                closeModal();
                if (onCancel) onCancel();
            }
        };
        
        return overlay;
    },
    
    close: function(toast) {
        toast.classList.remove('toast-show');
        toast.classList.add('toast-hide');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 300);
    },
    
    getIcon: function(type) {
        const icons = {
            success: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
            error: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
            warning: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
            info: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>'
        };
        return icons[type] || icons.info;
    },
    
    getTitle: function(type) {
        const titles = {
            success: 'Thành công',
            error: 'Lỗi',
            warning: 'Cảnh báo',
            info: 'Thông báo'
        };
        return titles[type] || 'Thông báo';
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    Toast.init();
});
