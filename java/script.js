window.sr = ScrollReveal({ reset: true} ); // Adicionando ScrollReveal
 


sr.reveal('.grid-item', {
    duration: 800,
    origin: 'bottom',
    distance: '20px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});

sr.reveal('.titulo', {
    duration: 1000,
    origin: 'bottom',
    distance: '20px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});

sr.reveal('.subtitulo', {
    duration: 1000,
    origin: 'bottom',
    distance: '20px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});


sr.reveal('.main-image', {
    duration: 1000,
    origin: 'bottom',
    distance: '20px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
});

sr.reveal('.agendar', {
    duration: 1000,
    origin: 'bottom',
    distance: '20px',
    opacity: 0, // Começa invisível
    interval: 100 // Intervalo entre os itens
})

sr.reveal('.calendar-integration', {
    duration: 1200,
    origin: 'left',
    distance: '50px'
});


function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none"; // Adicionei o ponto e vírgula
}

function toggleMenu() {
    const modal = document.getElementById('modalMenu');
    modal.style.display = "block"; // Exibe a modal ao abrir o menu
}

function toggleInfo(section) { // Adicionada a chave
    const infoBox = document.getElementById('info');
    let content = '';
    const currentContent = infoBox.innerHTML;

    switch (section) {
        case 'sobreNos':
            content = `<h3>Sobre Nós</h3>
                       <p>Somos uma plataforma dedicada ao agendamento de salas, com foco em facilitar a vida acadêmica de nossos usuários.</p>`;
            break;
        case 'recursos':
            content = `<h3>Recursos</h3>
                       <p>Oferecemos uma variedade de recursos para tornar seu agendamento mais eficiente e prático.</p>`;
            break;
        case 'contato':
            content = `<h3>Contato</h3>
                       <p>Entre em contato conosco através do e-mail: suporte@eduspace.com</p>`;
            break;
        default:
            content = `<h3>Erro</h3><p>Informações não encontradas.</p>`;
    }

    // Alterna a exibição do conteúdo
    if (currentContent.includes(content)) {
        infoBox.innerHTML = ''; // Limpa se o conteúdo já está visível
    } else {
        infoBox.innerHTML = content; // Exibe o conteúdo
        infoBox.classList.add('fade-in'); // Adiciona classe para animação
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('modalMenu');
    if (event.target === modal) {
        modal.style.display = "none"; // Ponto e vírgula adicionado
    }
}
