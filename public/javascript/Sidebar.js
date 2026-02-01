document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.main-content');

    // Load sidebar state from localStorage
    const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
    if (isMinimized) {
        sidebar.classList.remove('expanded');
        sidebar.classList.add('minimized');
        mainContent.classList.remove('ml-[270px]');
        mainContent.classList.add('ml-[100px]');
    } else {
        sidebar.classList.remove('minimized');
        sidebar.classList.add('expanded');
        mainContent.classList.remove('ml-[100px]');
        mainContent.classList.add('ml-[270px]');
    }

    // Toggle sidebar on button click
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('minimized');
        sidebar.classList.toggle('expanded');
        
        if (sidebar.classList.contains('minimized')) {
            mainContent.classList.remove('ml-[270px]');
            mainContent.classList.add('ml-[100px]');
            localStorage.setItem('sidebarMinimized', 'true');
        } else {
            mainContent.classList.remove('ml-[100px]');
            mainContent.classList.add('ml-[270px]');
            localStorage.setItem('sidebarMinimized', 'false');
        }
    });
});