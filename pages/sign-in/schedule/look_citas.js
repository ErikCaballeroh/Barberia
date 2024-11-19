$(document).ready(function () {
    // Función para cargar las citas
    function cargarCitas() {
        $.ajax({
            url: 'get_citas.php', // Archivo PHP que genera las citas
            method: 'GET',
            dataType: 'json', // Espera un JSON como respuesta
            success: function (data) {
                if (data.length > 0) {
                    let citasHtml = ''; // Variable para construir el contenido dinámico
                    data.forEach((cita, index) => {
                        citasHtml += `
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Cita #${index + 1}</h5>
                                        <p class="card-text"><strong>Usuario:</strong> ${cita.user}</p>
                                        <p class="card-text"><strong>Fecha:</strong> ${cita.date}</p>
                                        <p class="card-text"><strong>Hora:</strong> ${cita.time}</p>
                                        <p class="card-text"><strong>Servicio:</strong> ${cita.service}</p>
                                        <button class="btn btn-danger btn-sm eliminar-cita" data-id="${cita.id_appointment}">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#citas-container').html(citasHtml); // Inserta las citas en el contenedor
                } else {
                    $('#citas-container').html('<p>No hay citas disponibles.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las citas:', error);
                alert('Error al cargar las citas. Por favor, inténtelo de nuevo más tarde.');
            }
        });
    }

    // Función para eliminar una cita
    function eliminarCita(idCita) {
        $.ajax({
            url: 'delete_appointment.php', // Archivo PHP que elimina la cita
            method: 'POST',
            data: { id_appointment: idCita }, // Enviar el ID de la cita
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    cargarCitas(); // Recargar las citas después de eliminar
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar la cita:', error);
                alert('Error al eliminar la cita. Por favor, inténtelo de nuevo más tarde.');
            }
        });
    }

    // Delegación de evento para manejar el clic en los botones "Eliminar"
    $('#citas-container').on('click', '.eliminar-cita', function () {
        const idCita = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
            eliminarCita(idCita);
        }
    });

    // Llama a la función para cargar las citas
    cargarCitas();
});