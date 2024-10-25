function showContent(contentId) {
    const allContents = document.querySelectorAll('.content-container');
    allContents.forEach(content => content.classList.remove('active'));
  
    const selectedContent = document.getElementById(contentId);
    selectedContent.classList.add('active');
  
    if (contentId === 'menuContent') {
        swiper.update(); 
    }
  }
  
  
  
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
  
  
  function showNotifications() {
    document.getElementById('notificationsContent').classList.add('active');
  }
  
  function closeNotifications() {
    document.getElementById('notificationsContent').classList.remove('active');
  }
  
  
  document.querySelector('.nav-links li:nth-child(3) a').onclick = function(event) {
    event.preventDefault(); 
    showNotifications(); 
  };
  
  document.addEventListener("DOMContentLoaded", function() {
    
    document.querySelectorAll('.nav-links li a').forEach(link => {
        link.addEventListener('click', function() {
            showContent(this.getAttribute('onclick').match(/'(.*?)'/)[1]); 
        });
    });
  });
  
 
  let notifications = [];
  
  
  function addNotification(message, timestamp) {
    notifications.push({ message, timestamp });
    updateNotificationCount();
    renderNotifications();
  }
  
  
  function renderNotifications() {
    const listElement = document.getElementById('notification-list');
    listElement.innerHTML = ''; 
    notifications.forEach(notification => {
      const listItem = document.createElement('div');
      listItem.classList.add('notification-item');
      listItem.setAttribute('data-timestamp', notification.timestamp);
      
      listItem.innerHTML = `
        <img src="https://via.placeholder.com/40" alt="thumb" class="thumb">
        <div class="notification-details">
          <p class="notification-title">${notification.message}</p>
          <span class="notification-time" data-time="${notification.timestamp}">${timeSince(new Date(notification.timestamp))}</span>
        </div>
        <div class="notification-actions">
          <button class="btn-action" onclick="markAsRead(this)">
            <i class="fas fa-check"></i>
          </button>
          <button class="btn-action" onclick="deleteNotification(this)">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      `;
      
      listElement.appendChild(listItem);
    });
  }
  
  function updateNotificationCount() {
    const notificationItems = document.querySelectorAll(".notification-item");
    const notificationCount = document.getElementById("notification-count");
    const markAllAsReadButton = document.getElementById("mark-all-as-read"); 
  
    
    let count = 0;
    notificationItems.forEach(item => {
        if (!item.classList.contains("read")) {
            count++;
        }
    });
  
    
    notificationCount.textContent = count > 0 ? count : '';
    notificationCount.style.display = count > 0 ? 'inline-block' : 'none'; 
  
    
    markAllAsReadButton.style.display = count > 0 ? 'inline-block' : 'none';
  }
  
  
  function deleteNotification(button) {
    const notificationItem = button.closest(".notification-item");
    
    if (notificationItem) {
        notificationItem.remove(); 
        updateNotificationCount(); 
    }
  }
  
  
  function markAsRead(button) {
    const notificationItem = button.closest(".notification-item");
  
    if (notificationItem) {
        notificationItem.classList.add("read"); 
        notificationItem.style.display = "none"; 
        updateNotificationCount(); 
    }
  }
  
  
  function markAllAsRead() {
    const notificationItems = document.querySelectorAll(".notification-item");
    notificationItems.forEach(item => {
        item.classList.add("read"); 
        item.style.display = "none"; 
    });
    updateNotificationCount(); 
  }
  
  
  updateNotificationCount();
  
  document.querySelectorAll('.btn-action').forEach(button => {
    button.addEventListener('click', function() {
        const notification = this.closest('.notification-item');
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300); 
    });
  });
  
  document.getElementById("mark-read").addEventListener("click", function() {
    const notificationItems = document.querySelectorAll(".notification-item");
  
    notificationItems.forEach(item => {
        
        item.classList.add("read"); 
        item.style.display = "none"; 
    });
  
    
    this.style.display = "none"; 
  });
  
  function mostrarSalas(event) {
    event.preventDefault();
   
    const salasExtras = document.querySelectorAll('.extra-salas');
    salasExtras.forEach(sala => sala.style.display = 'list-item');
    
    
    document.querySelector('.ver-mais').style.display = 'none';
    document.querySelector('.esconder').style.display = 'block';
  }
  
  function esconderSalas(event) {
    event.preventDefault();
    
    const salasExtras = document.querySelectorAll('.extra-salas');
    salasExtras.forEach(sala => sala.style.display = 'none');
    
    
    document.querySelector('.ver-mais').style.display = 'block';
    document.querySelector('.esconder').style.display = 'none';
  }
  
  function showInfo(type) {
    const infoDisplay = document.getElementById('infoDisplay');
    const infoText = document.getElementById('infoText');
    const buttons = document.querySelectorAll('.info-button'); 
  

    buttons.forEach(button => button.classList.remove('selected'));
  

    const activeButton = Array.from(buttons).find(button => button.dataset.type === type); 
    if (activeButton) {
        activeButton.classList.add('selected');
    }
  
    let content = '';
  
    switch (type) {
      case 'emAberto':
          content = `
              <div class="room">Laboratório de Química <span>22/10/2024</span></div>
              <div class="separator"></div>
              <div class="room">Sala Multimídia <span>23/10/2024</span></div>
              <div class="separator"></div>
          `;
          break;
      case 'finalizadas':
          content = `
              <div class="room">Auditório <span>21/10/2024</span></div>
              <div class="separator"></div>
              <div class="room">Laboratório de Física <span>20/10/2024</span></div>
              <div class="separator"></div>
          `;
          break;
      case 'verTodas':
          content = `
              <div class="room">Laboratório de Química <span>22/10/2024</span></div>
              <div class="separator"></div>
              <div class="room">Auditório <span>21/10/2024</span></div>
              <div class="separator"></div>
              <div class="room">Sala Multimídia <span>23/10/2024</span></div>
              <div class="separator"></div>
              <div class="room">Laboratório de Física <span>20/10/2024</span></div>
              <div class="separator"></div>
          `;
          break;
      default:
          content = '';
          break;
    }
  
    infoText.innerHTML = content; 
    infoDisplay.style.display = 'block'; 
  }
  
  
  
  
  