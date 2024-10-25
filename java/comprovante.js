// Função para baixar o comprovante como arquivo de texto
document.getElementById('baixar-comprovante').onclick = function() {
    const textoComprovante = `
        Comprovante de Agendamento
        Sala: ${comprovante.Identificacao}
        Data: ${comprovante.Data}
        Hora: ${comprovante.Hora}
        Duração: ${comprovante.Duracao} minutos
        Matéria: ${comprovante.Materia}
    `;

    const blob = new Blob([textoComprovante], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'comprovante_agendamento.txt';
    a.click();
    URL.revokeObjectURL(url);
};

// Função para compartilhar no WhatsApp
document.getElementById('compartilhar-whatsapp').onclick = function() {
    const mensagem = encodeURIComponent(`Estou compartilhando meu comprovante de agendamento:\nSala: ${comprovante.Identificacao}\nData: ${comprovante.Data}\nHora: ${comprovante.Hora}\nDuração: ${comprovante.Duracao} minutos\nMatéria: ${comprovante.Materia}`);
    const urlWhatsApp = `https://api.whatsapp.com/send?text=${mensagem}`;
    window.open(urlWhatsApp, '_blank');
};

