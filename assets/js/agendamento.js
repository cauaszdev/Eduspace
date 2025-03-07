$(document).ready(function() {
    $('#agendar').click(function() {
        const nome = $('#nome').val();
        const sala = $('#sala').val();
        const turma = $('#turma').val();
        const dataHora = $('#dataHora').val();

        if (nome && sala && turma && dataHora) {
            
            const data = new Date(dataHora);
            const dataFormatada = `${String(data.getDate()).padStart(2, '0')}/${String(data.getMonth() + 1).padStart(2, '0')}/${data.getFullYear()} ${String(data.getHours()).padStart(2, '0')}:${String(data.getMinutes()).padStart(2, '0')}`;
            $('#comprovante-info').html(`Nome: ${nome}<br>Sala: ${sala}<br>Turma: ${turma}<br>Data e Hora: ${dataFormatada}`);
            $('#comprovante').removeClass('d-none');
            $('#agendamento-form').addClass('d-none');
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });

    $('#cancelar').click(function() {
        
        window.location.href = 'home.php';
    });
    

    $('#compartilhar').click(function() {
        const nome = $('#nome').val();
        const sala = $('#sala').val();
        const turma = $('#turma').val();
        const dataHora = $('#dataHora').val();

        if (nome && sala && turma && dataHora) {
            
            const data = new Date(dataHora);
            const dataFormatada = `${String(data.getDate()).padStart(2, '0')}/${String(data.getMonth() + 1).padStart(2, '0')}/${data.getFullYear()} ${String(data.getHours()).padStart(2, '0')}:${String(data.getMinutes()).padStart(2, '0')}`;

            
            const mensagem = `Olá! Gostaria de compartilhar meu agendamento:\n\nNome: ${nome}\nSala: ${sala}\nTurma: ${turma}\nData e Hora: ${dataFormatada}\n\nVamos nos encontrar!`;
            
            
            const mensagemEncoded = encodeURIComponent(mensagem);

            
            const whatsappUrl = `https://api.whatsapp.com/send?text=${mensagemEncoded}`;

            
            window.open(whatsappUrl, '_blank');
        } else {
            alert('Por favor, preencha todos os campos antes de compartilhar.');
        }
    });
    $('#historico').click(function() {
        window.location.href = 'home.php';
    });

});
