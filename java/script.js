window.sr = ScrollReveal({ reset: true });

sr.reveal('.titulo', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, 
    interval: 100 
});

sr.reveal('.subtitulo', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, 
    interval: 100 
});

sr.reveal('.main-image', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, 
    interval: 100 
});

sr.reveal('.agendar', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, 
    interval: 100 
});

sr.reveal('.calendar-integration', {
    duration: 2000,
    origin: 'left',
    distance: '400px'
});

sr.reveal('.svg-container', {
    duration: 2000,
    origin: 'right',
    distance: '400px'
});

window.onload = function() {
    const cookiesAccepted = localStorage.getItem('cookiesAccepted');
    
    if (cookiesAccepted === null || cookiesAccepted === 'false') {
        document.getElementById('cookie-consent').style.display = 'block';
    }
};

document.getElementById('accept-cookies').onclick = function() {
    localStorage.setItem('cookiesAccepted', 'true');
    document.getElementById('cookie-consent').style.display = 'none';
};

document.getElementById('decline-cookies').onclick = function() {
    localStorage.setItem('cookiesAccepted', 'false');
    document.getElementById('cookie-consent').style.display = 'none';
};

const toggleButton = document.querySelector('.theme-toggle-button');
const body = document.body; 
const themeText = document.getElementById('theme-text'); 
const themeIcon = document.getElementById('theme-icon'); 

toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    body.classList.toggle('light-mode');

    if (body.classList.contains("dark-mode")) {
        themeText.textContent = "Light"; 
        themeIcon.setAttribute("d", "M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"); 
    } else {
        themeText.textContent = "Dark"; 
        themeIcon.setAttribute("d", "M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z"); 
    }
});

