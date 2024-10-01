$(document).ready(function() {
    const salas = {
        '101': {
            title: 'Laboratório de Informática',
            capacity: 'Capacidade: 30 alunos',
            description: 'Sala ideal para aulas de até 30 alunos, com tecnologia de ponta.',
            features: ['Projetor', 'Ar condicionado', 'Computadores', 'Wi-Fi gratuito']
        },
        '102': {
            title: 'Laboratório de Quimíca',
            capacity: 'Capacidade: 25 alunos',
            description: 'Sala ideal para aulas de até 25 alunos, com ambiente aconchegante.',
            features: ['Ar condicionado', 'Equipamentos de laboratório', 'Luz adequada', 'Bancadas de trabalho']
        },
        '103': {
            title: 'Auditório',
            capacity: 'Capacidade: 40 alunos',
            description: 'Sala ideal para aulas de até 40 alunos, equipada com projetor e quadro branco.',
            features: ['Iluminação ajustável', 'Sistema de projeção', 'Sistema de climatização', 'Conectividade']
        },
        '104': {
            title: 'Sala dos Chrome-Books',
            capacity: 'Capacidade: 35 alunos',
            description: 'Sala ideal para aulas de até 35 alunos, com assistência técnica.',
            features: ['Computadores Chromebook', 'Conectividade Wi-Fi', 'Suporte técnico']
        },
        '105': {
            title: 'Sala Multimidía',
            capacity: 'Capacidade: 20 alunos',
            description: 'Sala ideal para aulas de até 20 alunos, ideial para pequenas apresentações.',
            features: ['Televisão', 'Conexão Wi-Fi', 'Ambiente silencioso']
        }
    };

    $('.card').click(function() {
        const salaId = $(this).data('sala');
        const sala = salas[salaId];

        if (sala) {
            $('#modal-titulo').text(sala.title);
            $('#sala-informacoes').html(`
                <h6>${sala.capacity}</h6>
                <p>${sala.description}</p>
                <h6>Características:</h6>
                <ul>${sala.features.map(feature => `<li>${feature}</li>`).join('')}</ul>
            `);
            $('#modal-sala').modal('show');
        }
    });
});
