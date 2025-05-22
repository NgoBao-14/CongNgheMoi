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

    // Project registration functionality
    setupProjectRegistration();
});

function setupProjectRegistration() {
    // Sample project data
    const projects = [
        {
            id: 'DT001',
            title: 'Xây dựng ứng dụng quản lý sinh viên sử dụng Spring Boot',
            instructor: 'TS. Nguyễn Văn A',
            description: 'Đề tài tập trung vào việc xây dựng một ứng dụng web quản lý sinh viên sử dụng Spring Boot, Spring Data JPA và Thymeleaf. Ứng dụng cần có các chức năng cơ bản như thêm, sửa, xóa, tìm kiếm sinh viên, quản lý điểm, lớp học và các báo cáo thống kê.',
            requirements: 'Sinh viên cần có kiến thức về Java, Spring Framework, cơ sở dữ liệu và HTML/CSS/JavaScript.',
            maxMembers: 3,
            deadline: '30/06/2023'
        },
        {
            id: 'DT002',
            title: 'Phát triển ứng dụng di động đa nền tảng với React Native',
            instructor: 'ThS. Trần Thị B',
            description: 'Đề tài hướng đến việc xây dựng một ứng dụng di động đa nền tảng (iOS và Android) sử dụng React Native. Ứng dụng có thể là một ứng dụng thương mại điện tử, mạng xã hội, hoặc ứng dụng tin tức tùy theo sở thích của sinh viên.',
            requirements: 'Sinh viên cần có kiến thức về JavaScript, React, và hiểu biết cơ bản về phát triển ứng dụng di động.',
            maxMembers: 2,
            deadline: '15/07/2023'
        },
        {
            id: 'DT003',
            title: 'Xây dựng hệ thống nhận diện khuôn mặt sử dụng Deep Learning',
            instructor: 'PGS.TS. Lê Văn C',
            description: 'Đề tài nghiên cứu và phát triển một hệ thống nhận diện khuôn mặt sử dụng các kỹ thuật Deep Learning hiện đại như CNN, YOLO, hoặc các mô hình khác. Hệ thống cần có khả năng nhận diện khuôn mặt trong thời gian thực từ camera hoặc video.',
            requirements: 'Sinh viên cần có kiến thức về Python, Deep Learning, và xử lý ảnh.',
            maxMembers: 3,
            deadline: '01/08/2023'
        },
        {
            id: 'DT004',
            title: 'Phát triển website thương mại điện tử sử dụng MERN Stack',
            instructor: 'TS. Phạm Thị D',
            description: 'Đề tài tập trung vào việc xây dựng một website thương mại điện tử đầy đủ chức năng sử dụng MERN Stack (MongoDB, Express.js, React, Node.js). Website cần có các chức năng như đăng ký, đăng nhập, xem sản phẩm, giỏ hàng, thanh toán, quản lý đơn hàng, v.v.',
            requirements: 'Sinh viên cần có kiến thức về JavaScript, React, Node.js, và MongoDB.',
            maxMembers: 3,
            deadline: '20/07/2023'
        },
        {
            id: 'DT005',
            title: 'Xây dựng chatbot tư vấn học tập sử dụng NLP',
            instructor: 'ThS. Hoàng Văn E',
            description: 'Đề tài nghiên cứu và phát triển một chatbot tư vấn học tập cho sinh viên sử dụng các kỹ thuật Xử lý ngôn ngữ tự nhiên (NLP). Chatbot cần có khả năng trả lời các câu hỏi liên quan đến chương trình học, thời khóa biểu, quy định của trường, v.v.',
            requirements: 'Sinh viên cần có kiến thức về Python, NLP, và các thư viện như NLTK, spaCy, hoặc các framework chatbot.',
            maxMembers: 2,
            deadline: '10/08/2023'
        }
    ];
    
    // Get DOM elements
    const projectTableBody = document.querySelector('.project-list tbody');
    const registrationForm = document.getElementById('registrationForm');
    const selectedProjectTitle = document.getElementById('selectedProjectTitle');
    const selectedProjectId = document.getElementById('selectedProjectId');
    const groupRegistrationForm = document.getElementById('groupRegistrationForm');
    const cancelRegistration = document.getElementById('cancelRegistration');
    const additionalMembers = document.getElementById('additionalMembers');
    const addMemberBtn = document.getElementById('addMemberBtn');
    
    // Variable to store current project max members
    let currentProjectMaxMembers = 0;
    
    // Load projects when page loads
    loadProjects(projects);
    
    // Simulate loading
    showLoadingOverlay('Đang tải danh sách đề tài...');
    
    // Load projects into the table
    function loadProjects(projects) {
        // Clear existing rows
        projectTableBody.innerHTML = '';
        
        // Add project rows
        projects.forEach((project, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td>${project.id}</td>
                <td>${project.title}</td>
                <td>${project.instructor}</td>
                <td class="text-center">
                    <button class="btn btn-info btn-sm btn-view-details" data-project-id="${project.id}">
                        <i class="bi bi-eye"></i> Xem chi tiết
                    </button>
                    <button class="btn btn-success btn-sm btn-register" data-project-id="${project.id}">
                        <i class="bi bi-pencil-square"></i> Đăng ký
                    </button>
                </td>
            `;
            projectTableBody.appendChild(row);
        });
        
        // Add event listeners to buttons
        addButtonEventListeners(projects);
    }
    
    // Add event listeners to view details and register buttons
    function addButtonEventListeners(projects) {
        // View details buttons
        const viewDetailsButtons = document.querySelectorAll('.btn-view-details');
        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                const project = projects.find(p => p.id === projectId);

                // Show project details in modal
                showProjectDetails(project);
                
                // Show modal using Bootstrap's Modal API
                const projectDetailModal = new bootstrap.Modal(document.getElementById('projectDetailModal'));
                projectDetailModal.show();
            });
        });
        
        // Register buttons
        const registerButtons = document.querySelectorAll('.btn-register');
        registerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                const project = projects.find(p => p.id === projectId);
                
                // Store current project max members
                currentProjectMaxMembers = project.maxMembers;
                
                // Reset form
                resetRegistrationForm();
                
                // Show registration form
                registrationForm.style.display = 'block';
                
                // Set selected project info
                selectedProjectTitle.textContent = `Đề tài: ${project.title} (Tối đa ${project.maxMembers} thành viên)`;
                selectedProjectId.value = project.id;
                
                // Setup add member functionality with max members limit
                setupAddMemberFunctionality(currentProjectMaxMembers);
                
                // Scroll to registration form
                registrationForm.scrollIntoView({ behavior: 'smooth' });
            });
        });
    }
    
    // Setup add member functionality with max members limit
    function setupAddMemberFunctionality(maxMembers) {
        // Clear previous event listeners
        const newAddMemberBtn = addMemberBtn.cloneNode(true);
        addMemberBtn.parentNode.replaceChild(newAddMemberBtn, addMemberBtn);
        
        // Get the new button reference
        const addMemberBtnRef = document.getElementById('addMemberBtn');
        
        // Current member count (leader + member1 = 2)
        let memberCount = 2;
        
        // Check if we already reached max members
        updateAddMemberButtonState();
        
        // Add event listener
        addMemberBtnRef.addEventListener('click', function() {
            // Create new member element
            const memberDiv = document.createElement('div');
            memberDiv.className = 'mb-3 member-container';
            memberDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Thành viên ${memberCount}</h5>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-member">
                        <i class="bi bi-x-circle"></i> Xóa
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="member${memberCount}Mssv" class="form-label">MSSV</label>
                        <input type="text" class="form-control" id="member${memberCount}Mssv" name="member${memberCount}Mssv">
                    </div>
                    <div class="col-md-8">
                        <label for="member${memberCount}Name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="member${memberCount}Name" name="member${memberCount}Name">
                    </div>
                </div>
            `;
            
            // Add to container
            additionalMembers.appendChild(memberDiv);
            
            // Add remove functionality
            const removeBtn = memberDiv.querySelector('.remove-member');
            removeBtn.addEventListener('click', function() {
                additionalMembers.removeChild(memberDiv);
                memberCount--;
                updateAddMemberButtonState();
            });
            
            // Increment member count
            memberCount++;
            
            // Update add member button state
            updateAddMemberButtonState();
        });
        
        // Function to update add member button state
        function updateAddMemberButtonState() {
            // If current members >= max members, disable the button
            if (memberCount >= maxMembers) {
                addMemberBtnRef.disabled = true;
                addMemberBtnRef.title = `Đã đạt số lượng thành viên tối đa (${maxMembers})`;
            } else {
                addMemberBtnRef.disabled = false;
                addMemberBtnRef.title = 'Thêm thành viên mới';
            }
        }
    }
    
    // Reset registration form
    function resetRegistrationForm() {
        // Clear member 1 fields
        document.getElementById('member1Mssv').value = '';
        document.getElementById('member1Name').value = '';
        
        // Clear additional members
        additionalMembers.innerHTML = '';
    }
    
    // Show project details in modal
    function showProjectDetails(project) {
        const projectDetailContent = document.getElementById('projectDetailContent');
        
        projectDetailContent.innerHTML = `
            <div class="project-detail-item">
                <div class="label">Mã đề tài:</div>
                <div>${project.id}</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Tên đề tài:</div>
                <div>${project.title}</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Giảng viên hướng dẫn:</div>
                <div>${project.instructor}</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Mô tả:</div>
                <div>${project.description}</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Yêu cầu:</div>
                <div>${project.requirements}</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Số lượng thành viên tối đa:</div>
                <div>${project.maxMembers} sinh viên</div>
            </div>
            <div class="project-detail-item">
                <div class="label">Hạn đăng ký:</div>
                <div>${project.deadline}</div>
            </div>
        `;
    }
    
    // Group registration form submit
    groupRegistrationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data for leader and member 1
        const formData = {
            projectId: selectedProjectId.value,
            leader: {
                mssv: document.getElementById('leaderMssv').value,
                name: document.getElementById('leaderName').value
            },
            member1: {
                mssv: document.getElementById('member1Mssv').value,
                name: document.getElementById('member1Name').value
            },
            additionalMembers: []
        };
        
        // Get additional members data
        const memberContainers = additionalMembers.querySelectorAll('.member-container');
        memberContainers.forEach((container, index) => {
            const memberNumber = index + 2; // Start from member 2
            const mssv = document.getElementById(`member${memberNumber}Mssv`).value;
            const name = document.getElementById(`member${memberNumber}Name`).value;
            
            if (mssv && name) {
                formData.additionalMembers.push({
                    mssv: mssv,
                    name: name
                });
            }
        });
        
        // Simulate form submission
        showLoadingOverlay('Đang đăng ký đề tài...');
        
        // Simulate API call
        setTimeout(() => {
            alert('Đăng ký đề tài thành công!');
            
            // Hide registration form
            registrationForm.style.display = 'none';
            
            // Disable register button for the selected project
            const registerButton = document.querySelector(`.btn-register[data-project-id="${formData.projectId}"]`);
            if (registerButton) {
                registerButton.disabled = true;
                registerButton.classList.remove('btn-success');
                registerButton.classList.add('btn-secondary');
                registerButton.innerHTML = '<i class="bi bi-check-circle"></i> Đã đăng ký';
            }
            
            // Hide loading overlay
            const loadingOverlay = document.querySelector('.loading-overlay');
            if (loadingOverlay) {
                document.body.removeChild(loadingOverlay);
            }
            
            // Log form data to console (for debugging)
            console.log('Form Data:', formData);
        }, 2000);
    });
    
    // Cancel registration button
    cancelRegistration.addEventListener('click', function() {
        registrationForm.style.display = 'none';
    });
    
    // Show loading overlay
    function showLoadingOverlay(message) {
        // Create loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="mt-2">${message}</p>
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
        
        // Remove after 1.5 seconds
        setTimeout(() => {
            loadingOverlay.style.opacity = '0';
            loadingOverlay.style.transition = 'opacity 0.5s';
            
            setTimeout(() => {
                document.body.removeChild(loadingOverlay);
            }, 500);
        }, 1500);
    }
}