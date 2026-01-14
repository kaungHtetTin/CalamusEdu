// Navigation Drawer Toggle
document.addEventListener('DOMContentLoaded', function() {
  const drawerToggle = document.getElementById('drawerToggle');
  const navigationDrawer = document.getElementById('navigationDrawer');
  const drawerOverlay = document.getElementById('drawerOverlay');
  const adminMain = document.querySelector('.admin-main');

  // Initialize drawer state based on screen size
  function initDrawer() {
    if (window.innerWidth >= 992) {
      // Desktop: drawer always visible
      navigationDrawer.classList.add('drawer-open');
      drawerOverlay.classList.remove('active');
      adminMain.classList.remove('drawer-open');
    } else {
      // Mobile: drawer closed by default
      navigationDrawer.classList.remove('drawer-open');
      drawerOverlay.classList.remove('active');
      adminMain.classList.remove('drawer-open');
    }
  }

  function toggleDrawer() {
    if (window.innerWidth < 992) {
      navigationDrawer.classList.toggle('drawer-open');
      drawerOverlay.classList.toggle('active');
    }
  }

  function closeDrawer() {
    if (window.innerWidth < 992) {
      navigationDrawer.classList.remove('drawer-open');
      drawerOverlay.classList.remove('active');
    }
  }

  // Initialize on load
  initDrawer();

  if (drawerToggle) {
    drawerToggle.addEventListener('click', toggleDrawer);
  }

  if (drawerOverlay) {
    drawerOverlay.addEventListener('click', closeDrawer);
  }

  // Close drawer when clicking on a nav item on mobile
  const navItems = document.querySelectorAll('.admin-nav-item');
  navItems.forEach(item => {
    item.addEventListener('click', function() {
      if (window.innerWidth < 992) {
        closeDrawer();
      }
    });
  });

  // Handle window resize
  window.addEventListener('resize', initDrawer);
});

// Theme Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
  const themeToggle = document.getElementById('themeToggle');
  const body = document.body;
  
  if (!body) return;
  
  // Get saved theme or default to dark
  const savedTheme = localStorage.getItem('theme') || 'dark';
  
  // Apply saved theme on load
  function applyTheme(theme) {
    if (theme === 'light') {
      body.classList.add('light-theme');
      body.classList.remove('dark-theme');
      if (themeToggle) {
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        themeToggle.setAttribute('title', 'Switch to dark mode');
      }
    } else {
      body.classList.add('dark-theme');
      body.classList.remove('light-theme');
      if (themeToggle) {
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        themeToggle.setAttribute('title', 'Switch to light mode');
      }
    }
    localStorage.setItem('theme', theme);
  }
  
  // Initialize theme
  applyTheme(savedTheme);
  
  // Toggle theme on button click
  if (themeToggle) {
    themeToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      const currentTheme = body.classList.contains('light-theme') ? 'light' : 'dark';
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      applyTheme(newTheme);
    });
  }
});

// Graph
var ctx = document.getElementById("myChart");
if (ctx) {
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      datasets: [
        {
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "#007bff",
          borderWidth: 4,
          pointBackgroundColor: "#007bff",
        },
      ],
    },
    options: {
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: false,
            },
          },
        ],
      },
      legend: {
        display: false,
      },
    },
  });
}

// User Avatar Dropdown Toggle
function initUserDropdown() {
  const userAvatarContainer = document.querySelector('.user-avatar-dropdown');
  const userAvatar = document.getElementById('userAvatarDropdown');
  const dropdownMenu = document.getElementById('userDropdownMenu');
  
  if (!userAvatarContainer || !dropdownMenu) {
    // Retry after a short delay if elements not found
    setTimeout(initUserDropdown, 100);
    return;
  }
  
  let hoverTimeout = null;
  let isOpen = false;
  
  function showDropdown() {
    clearTimeout(hoverTimeout);
    dropdownMenu.classList.add('show');
    isOpen = true;
  }
  
  function hideDropdown() {
    clearTimeout(hoverTimeout);
    hoverTimeout = setTimeout(function() {
      dropdownMenu.classList.remove('show');
      isOpen = false;
    }, 150);
  }
  
  // Show dropdown on hover over container
  userAvatarContainer.addEventListener('mouseenter', function() {
    showDropdown();
  });
  
  // Hide dropdown when mouse leaves container
  userAvatarContainer.addEventListener('mouseleave', function(e) {
    // Check if mouse is moving to dropdown
    const relatedTarget = e.relatedTarget;
    if (relatedTarget && dropdownMenu.contains(relatedTarget)) {
      return; // Don't hide if moving to dropdown
    }
    hideDropdown();
  });
  
  // Keep dropdown open when hovering over it
  dropdownMenu.addEventListener('mouseenter', function() {
    showDropdown();
  });
  
  // Hide dropdown when mouse leaves dropdown
  dropdownMenu.addEventListener('mouseleave', function() {
    hideDropdown();
  });
  
  // Toggle dropdown on avatar click
  if (userAvatar) {
    userAvatar.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      if (isOpen) {
        dropdownMenu.classList.remove('show');
        isOpen = false;
      } else {
        dropdownMenu.classList.add('show');
        isOpen = true;
      }
    });
  }
  
  // Also allow clicking on container (avatar area)
  userAvatarContainer.addEventListener('click', function(e) {
    // Only toggle if clicking on the avatar itself, not the dropdown
    if (e.target.closest('.user-avatar-top') || e.target.closest('#userAvatarDropdown')) {
      e.preventDefault();
      e.stopPropagation();
      if (isOpen) {
        dropdownMenu.classList.remove('show');
        isOpen = false;
      } else {
        dropdownMenu.classList.add('show');
        isOpen = true;
      }
    }
  });
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (isOpen && !userAvatarContainer.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove('show');
      isOpen = false;
    }
  });
  
  // Close dropdown on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isOpen) {
      dropdownMenu.classList.remove('show');
      isOpen = false;
    }
  });
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initUserDropdown);
} else {
  // DOM already loaded
  initUserDropdown();
}
