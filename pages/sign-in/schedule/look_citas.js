// Función para cargar las citas
export function cargarCitas() {
    $.ajax({
        url: 'get_citas.php', // Archivo PHP que genera las citas
        method: 'GET',
        dataType: 'json', // Espera un JSON como respuesta
        success: function (data) {
            if (data.length > 0) {
                let citasHtml = ''; // Variable para construir el contenido dinámico
                data.forEach((cita, index) => {
                    citasHtml += `
                            <div class="col-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Cita de el ${cita.date}</h5>
                                        <p class="card-text mb-1"><strong>Hora</strong> ${cita.time}</p>
                                        <p class="card-text mb-1"><strong>Servicio</strong> ${cita.service}</p>
                                        <button class="btn btn-danger btn-sm eliminar-cita w-100 mt-3" data-id="${cita.id_appointment}">Eliminar</button>
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

$(document).ready(function () {
    // Función para eliminar una cita
    function eliminarCita(idCita) {
        $.ajax({
            url: 'delete_appointment.php', // Archivo PHP que elimina la cita
            method: 'POST',
            data: { id_appointment: idCita }, // Enviar el ID de la cita
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Eliminado!",
                        icon: "success"
                    });

                    cargarCitas()
                } else if (response.error) {
                    Swal.fire({
                        title: "Error",
                        icon: "error"
                    });
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

        Swal.fire({
            title: "Eliminar cita",
            text: "Esta seguro de que desea eliminar la cita?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarCita(idCita);
            }
        });
    });

    // Llama a la función para cargar las citas
    cargarCitas();
});