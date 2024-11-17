$.ajax({
    url: 'sucursales.php',  // El archivo PHP que obtiene los empleados
    type: 'GET',            // Usamos el método GET
    dataType: 'json',       // Esperamos una respuesta en formato JSON
    success: function (sucursales) {
        // Verificar que sucursales sea un array
        if (Array.isArray(sucursales)) {
            sucursales.forEach(sucursal => {
                // Agregar cada sucursal como una opción al select
                $("#selectSucursal").append($('<option>', {
                    value: sucursal.id_barber,
                    text: `Sucursal ${sucursal.id_barber}`
                }));
            });
        } else {
            console.error('La respuesta no es un array:', sucursales);
        }
    },
    error: function () {
        alert('Hubo un error al cargar las sucursales.');
    }
});

// Al cambiar sucursal, cargar días disponibles
$('#selectSucursal').on('change', function () {
    const idBarber = $(this).val();
    if (idBarber) {
        $.ajax({
            url: 'get_dias_disponibles.php',
            method: 'GET',
            data: { idBarber },
            dataType: 'json',
            success: function (diasDisponibles) {
                $('#selectfecha').flatpickr({
                    dateFormat: 'Y-m-d',
                    disable: [
                        function (date) {
                            const day = date.toLocaleString('en-US', { weekday: 'long' }).toLowerCase();
                            return !diasDisponibles.includes(day);
                        }
                    ]
                });
            },
            error: function () {
                alert('Error al cargar los días disponibles.');
            }
        });
    }
});

$('#selectSucursal').on('change', function () {
    const idBarber = $(this).val(); // Obtener el id del barbero seleccionado
    if (idBarber) {
        $.ajax({
            url: 'get_dias_disponibles.php',  // URL del archivo PHP para obtener los días disponibles
            method: 'GET',
            data: { idBarber },
            dataType: 'json',
            success: function (diasDisponibles) {
                // Si ya existe una instancia de flatpickr, la destruimos para reiniciarla
                if ($('#selectfecha').flatpickr) {
                    $('#selectfecha').flatpickr().destroy();
                }

                // Inicializamos flatpickr con los días habilitados
                $('#selectfecha').flatpickr({
                    dateFormat: 'Y-m-d', // Formato compatible con MySQL
                    disable: [
                        function (date) {
                            const day = date.toLocaleString('en-US', { weekday: 'long' }).toLowerCase();
                            // Deshabilitar el día si no está en el array de días disponibles
                            return !diasDisponibles.includes(day);
                        }
                    ],
                    inline: true // Mostrar el calendario directamente sin necesidad de un campo de texto
                });
            },
            error: function () {
                alert('Error al cargar los días disponibles.');
            }
        });
    }
});
// Cargar servicios al cargar la página
$(document).ready(function () {
    $.ajax({
        url: 'get_servicios.php',
        method: 'GET',
        dataType: 'json',
        success: function (servicios) {
            servicios.forEach(servicio => {
                $('#selectservicio').append(
                    `<option value="${servicio.id_service}">${servicio.name}</option>`
                );
            });
        },
        error: function () {
            alert('Error al cargar los servicios.');
        }
    });
});

// Al enviar formulario, agendar cita
$('#appointmentForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'agendar_cita.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            alert(response.message);
            if (response.success) {
                $('#appointmentForm')[0].reset();
            }
        },
        error: function () {
            alert('Error al agendar la cita.');
        }
    });
});