window.sr = ScrollReveal({ reset: true} ); 

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
})

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

function toggleInfo() { 
    const infoBox = document.getElementById('info');
    let content = '';
    const currentContent = infoBox.innerHTML;

    
    if (currentContent.includes(content)) {
        infoBox.innerHTML = ''; 
    } else {
        infoBox.innerHTML = content; 
        infoBox.classList.add('fade-in'); 
    }


 
    function showInfo(infoId) {
        const contents = document.querySelectorAll('.info-content');
        contents.forEach(content => {
            content.style.display = 'none'; 
        });
    
        const selectedContent = document.getElementById(infoId);
        if (selectedContent) {
            selectedContent.style.display = 'block'; 
        }
    }
}
