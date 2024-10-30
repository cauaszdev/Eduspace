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
    if (!localStorage.getItem('cookiesAccepted')) {
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
