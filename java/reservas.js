function showReservations(status) {
    const infoText = document.getElementById('infoText');
    infoText.innerHTML = '<div class="alert alert-info" role="alert">Carregando reservas...</div>';

    fetch(`reservas.php?status=${status}`)
        .then(response => response.json())
        .then(data => {
            // Limpa o conteúdo anterior
            infoText.innerHTML = '';

            if (data.length > 0) {
                data.forEach(reserva => {
                    const card = `
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${reserva.Tipoatividade}</h5>
                                <p class="card-text">
                                    <strong>Data:</strong> ${reserva.Data}<br>
                                    <strong>Hora:</strong> ${reserva.Hora}<br>
                                    <strong>Status:</strong> ${reserva.Status}<br>
                                    <strong>Sala:</strong> ${reserva.sala}<br> <!-- Exibindo o nome da sala -->
                                </p>
                                <a href="/tec/php/comprovante.php?id=${reserva.IDagendamento}" class="btn btn-secondary">Mostrar Comprovante</a> <!-- Botão para baixar o comprovante -->
                            </div>
                        </div>`;
                    infoText.innerHTML += card;
                });
            } else {
                infoText.innerHTML = '<div class="alert alert-warning" role="alert">Nenhuma reserva encontrada.</div>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            infoText.innerHTML = '<div class="alert alert-danger" role="alert">Erro ao carregar reservas.</div>';
        });
}
