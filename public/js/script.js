// Initialize sidebar functionality
document.addEventListener("DOMContentLoaded", () => {
  // Toggle sidebar
  const toggleSidebarBtn = document.querySelector('[data-widget="pushmenu"]')
  if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener("click", (e) => {
      e.preventDefault()
      document.body.classList.toggle("sidebar-mini")

      // For mobile view
      if (window.innerWidth <= 768) {
        document.body.classList.toggle("sidebar-open")
      }
    })
  }

  // Add active class to sidebar items when clicked
  const sidebarItems = document.querySelectorAll(".nav-sidebar .nav-link")
  sidebarItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      // Skip if this is a parent menu with submenu
      if (this.querySelector('.fa-angle-left')) {
        return
      }
      
      // Remove active class from all items
      sidebarItems.forEach((i) => {
        if (!i.querySelector('.fa-angle-left')) {
          i.classList.remove("active")
        }
      })
      // Add active class to clicked item
      this.classList.add("active")
    })
  })

  // Add tooltip functionality for sidebar
  const sidebarLinks = document.querySelectorAll(".nav-sidebar .nav-link")
  sidebarLinks.forEach((link) => {
    const linkText = link.querySelector("p")?.textContent || ""
    link.setAttribute("title", linkText)
  })
  
  // Initialize Charts
  initializeCharts()
})

// Function to initialize all charts
function initializeCharts() {
  // Bar Chart - Thống kê đề tài theo khoa
  const barChartCanvas = document.getElementById("barChart")
  if (barChartCanvas) {
    const barChartData = {
      labels: ['Công nghệ thông tin', 'Điện tử viễn thông', 'Khoa học máy tính', 'Kỹ thuật phần mềm', 'Hệ thống thông tin'],
      datasets: [
        {
          label: 'Số lượng đề tài',
          backgroundColor: 'rgba(60, 141, 188, 0.8)',
          borderColor: 'rgba(60, 141, 188, 1)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60, 141, 188, 1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60, 141, 188, 1)',
          data: [28, 19, 15, 22, 14]
        }
      ]
    }
    
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    })
  }
  
  // Pie Chart - Phân bố đề tài
  const pieChartCanvas = document.getElementById("pieChart")
  if (pieChartCanvas) {
    const pieChartData = {
      labels: ['Đã hoàn thành', 'Đang thực hiện', 'Chưa bắt đầu', 'Tạm hoãn'],
      datasets: [
        {
          data: [30, 45, 15, 10],
          backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
          borderWidth: 1
        }
      ]
    }
    
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieChartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right'
          }
        }
      }
    })
  }
  
  // Add event listeners for interactive elements
  addEventListeners()
}

// Function to add event listeners for interactive elements
function addEventListeners() {
  // Add click event for "Xem chi tiết" links in info boxes
  const infoBoxLinks = document.querySelectorAll('.info-box a')
  infoBoxLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault()
      const boxType = this.closest('.info-box').querySelector('.info-box-text').textContent.trim()
      alert(`Đang chuyển đến trang quản lý ${boxType}`)
    })
  })
  
  // Add click event for activity items
  const activityItems = document.querySelectorAll('.products-list .item')
  activityItems.forEach(item => {
    item.addEventListener('click', function() {
      const activityTitle = this.querySelector('.product-title').textContent.trim()
      const activityDesc = this.querySelector('.product-description').textContent.trim()
      alert(`Chi tiết hoạt động: ${activityTitle} - ${activityDesc}`)
    })
  })
  
  // Add hover effect for table rows
  const tableRows = document.querySelectorAll('table tbody tr')
  tableRows.forEach(row => {
    row.addEventListener('mouseenter', function() {
      this.style.backgroundColor = '#f8f9fa'
      this.style.cursor = 'pointer'
    })
    
    row.addEventListener('mouseleave', function() {
      this.style.backgroundColor = ''
      this.style.cursor = 'default'
    })
    
    row.addEventListener('click', function() {
      const student = this.cells[0].textContent
      const topic = this.cells[1].textContent
      alert(`Chi tiết lịch bảo vệ: ${student} - ${topic}`)
    })
  })
}

// Import jQuery for AdminLTE compatibility
import * as jQuery from "jquery"
window.jQuery = jQuery
window.$ = jQuery

// Đoạn code này sẽ xử lý việc mở/đóng menu dropdown
$(document).ready(function() {
  // Xử lý sự kiện click cho các menu có submenu
  $('.nav-item.has-treeview > .nav-link').on('click', function(e) {
    e.preventDefault();
    const $parent = $(this).parent();
    
    // Toggle class menu-open
    $parent.toggleClass('menu-open');
    
    // Toggle hiển thị submenu
    const $treeview = $parent.find('.nav-treeview').first();
    if ($parent.hasClass('menu-open')) {
      $treeview.slideDown();
    } else {
      $treeview.slideUp();
    }
  });
  
  // Khởi tạo trạng thái ban đầu cho các menu đã mở
  $('.nav-item.has-treeview.menu-open > .nav-treeview').show();
});