// Sidebar Toggle Functions
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggleIcon');
    sidebar.classList.toggle('collapsed');
    
    if (sidebar.classList.contains('collapsed')) {
        icon.className = 'bi bi-chevron-right';
    } else {
        icon.className = 'bi bi-chevron-left';
    }
    
    // Save state to localStorage
    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
}

function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('mobile-open');
}

// Restore sidebar state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggleIcon');
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        icon.className = 'bi bi-chevron-right';
    }
    
    // Call loadStatusAndMessages if it exists (for dashboard page)
    if (typeof loadStatusAndMessages === 'function') {
        loadStatusAndMessages();
    }
});

// Close mobile sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const mobileBtn = document.querySelector('.mobile-menu-btn');
    
    if (window.innerWidth <= 768 && 
        sidebar.classList.contains('mobile-open') && 
        !sidebar.contains(event.target) && 
        mobileBtn && !mobileBtn.contains(event.target)) {
        sidebar.classList.remove('mobile-open');
    }
});
