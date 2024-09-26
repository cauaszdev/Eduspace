window.sr = ScrollReveal({ reset: true} ); // Adicionando ScrollReveal

sr.reveal('.titulo', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});

sr.reveal('.subtitulo', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});


sr.reveal('.main-image', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});

sr.reveal('.agendar', {
    duration: 2000,
    origin: 'bottom',
    distance: '100px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
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

function toggleInfo() { // Adicionada a chave
    const infoBox = document.getElementById('info');
    let content = '';
    const currentContent = infoBox.innerHTML;

    // Alterna a exibição do conteúdo
    if (currentContent.includes(content)) {
        infoBox.innerHTML = ''; // Limpa se o conteúdo já está visível
    } else {
        infoBox.innerHTML = content; // Exibe o conteúdo
        infoBox.classList.add('fade-in'); // Adiciona classe para animação
    }


 
    function showInfo(infoId) {
        const contents = document.querySelectorAll('.info-content');
        contents.forEach(content => {
            content.style.display = 'none'; // Esconder todos
        });
    
        const selectedContent = document.getElementById(infoId);
        if (selectedContent) {
            selectedContent.style.display = 'block'; // Mostrar conteúdo selecionado
        }
    }
}
