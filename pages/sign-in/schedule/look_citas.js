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
                            <tr>
                                <td>${index + 1}</td>
                                <td>${cita.user}</td>
                                <td>${cita.date}</td>
                                <td>${cita.time}</td>
                                <td>${cita.service}</td>

                            <td>
                                    <button class="btn btn-danger btn-sm eliminar-cita" data-id="${cita.id_appointment}">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#citas-body').html(citasHtml); // Inserta las citas en la tabla
                } else {
                    $('#citas-body').html('<tr><td colspan="5">No hay citas disponibles.</td></tr>');
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
    $('#citas-body').on('click', '.eliminar-cita', function () {
        const idCita = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
            eliminarCita(idCita);
        }
    });

    // Llama a la función para cargar las citas
    cargarCitas();
});
