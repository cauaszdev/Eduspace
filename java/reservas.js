function showReservations(status) {
    fetch(`reservas.php?status=${status}`)
        .then(response => response.json())
        .then(data => {
            const infoText = document.getElementById('infoText');
            infoText.innerHTML = '';

            if (data.length > 0) {
                data.forEach(reserva => {
                    let buttons = '';
                    if (status === 'abertas') {
                        buttons = `
                            <a href="comprovante.php?id=${reserva.IDagendamento}" class="btn btn-secondary">Ver Comprovante</a>
                            <button class="btn btn-danger ml-2" onclick="confirmDelete(${reserva.IDagendamento})">Excluir</button>
                        `;
                    }

                    infoText.innerHTML += `
                        <div class="reserva mb-3">
                            ${reserva.Professor ? `<strong>Professor:</strong> ${reserva.Professor}<br>` : ''}
                            <strong>Sala:</strong> ${reserva.Sala}<br>
                            <strong>Data:</strong> ${reserva.Data}<br>
                            <strong>Duração:</strong> ${reserva.Inicio} - ${reserva.Fim}<br>
                            <strong>Status:</strong> ${reserva.Status}<br>
                            <strong>Matéria:</strong> ${reserva.Materia}<br>
                            ${buttons}
                            <hr>
                        </div>
                    `;
                });
            } else {
                infoText.innerHTML = '<p>Nenhuma reserva encontrada.</p>';
            }
        })
        .catch(error => console.error('Erro:', error));
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteReservation(id);
        }
    });
}

function deleteReservation(id) {
    fetch('reservas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ delete_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Excluído!', 'A reserva foi excluída.', 'success');
            showReservations('abertas');
        } else {
            Swal.fire('Erro!', 'Não foi possível excluir a reserva.', 'error');
        }
    })
    .catch(error => console.error('Erro:', error));
}
