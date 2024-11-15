$(document).ready(function() {
    // Obtener las sucursales
    $.ajax({
        url: '/barberia/php/agenda.php',
        type: 'POST',
        data: { action: 'get_sucursales' },
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta de sucursales:', response); // Mostrar la respuesta en la consola
            var selectSucursal = $('#sucursal');
            selectSucursal.empty();
            selectSucursal.append('<option value="">Seleccione una sucursal</option>');

            // Verificar si la respuesta contiene datos esperados
            if (Array.isArray(response)) {
                response.forEach(function(sucursal) {
                    selectSucursal.append('<option value="' + sucursal.id_barber + '">' + sucursal.service_number + '</option>');
                });
            } else {
                console.error("La respuesta no es un array de sucursales:", response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener las sucursales:", error);
            $('#mensajeSinCita').removeClass('d-none').text('Error al obtener las sucursales. Intenta nuevamente.');
        }
    });

    // Cuando se selecciona una sucursal, obtener los servicios disponibles
    $('#sucursal').change(function() {
        var barber_id = $(this).val();
        if (barber_id) {
            $.ajax({
                url: '/barberia/php/agenda.php',
                type: 'POST',
                data: { action: 'get_servicios', barber_id: barber_id },
                dataType: 'json',
                success: function(response) {
                    var servicioSelect = $('#servicio');
                    servicioSelect.empty();
                    servicioSelect.append('<option value="">Seleccione un servicio</option>');

                    if (response && Array.isArray(response)) {
                        response.forEach(function(servicio) {
                            servicioSelect.append('<option value="' + servicio.id_servicio + '">' + servicio.nombre_servicio + '</option>');
                        });
                    } else {
                        console.error("Error en la respuesta de servicios: formato inesperado.");
                        $('#mensajeSinCita').removeClass('d-none').text('Error al obtener los servicios. Intenta nuevamente.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener los servicios:", error);
                    $('#mensajeSinCita').removeClass('d-none').text('Error al obtener los servicios. Intenta nuevamente.');
                }
            });
        }
    });

    // Cuando se selecciona una fecha, obtener las horas disponibles
    $('#fecha').change(function() {
        var barber_id = $('#sucursal').val();
        var fecha = $(this).val();
        if (barber_id && fecha) {
            $.ajax({
                url: '/barberia/php/agenda.php', // Usar el mismo archivo PHP para obtener las horas disponibles
                type: 'POST',
                data: { action: 'get_horas_disponibles', barber_id: barber_id, fecha: fecha },
                dataType: 'json',
                success: function(response) {
                    var horasDisponibles = $('#hora');
                    horasDisponibles.empty();  // Limpiar las horas previas
                    horasDisponibles.append('<option value="">Selecciona una hora</option>');  // Opción por defecto

                    if (response && Array.isArray(response) && response.length > 0) {
                        response.forEach(function(hora) {
                            horasDisponibles.append('<option value="' + hora + '">' + hora + '</option>');
                        });
                    } else {
                        horasDisponibles.append('<option value="">No hay horas disponibles</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener las horas disponibles:", error);
                    $('#mensajeSinCita').removeClass('d-none').text('Error al obtener las horas. Intenta nuevamente.');
                }
            });
        }
    });

    // Enviar la cita al hacer submit
    $('#agendarCitaForm').submit(function(e) {
        e.preventDefault();  // Evitar el envío tradicional del formulario

        var formData = {
            sucursal: $('#sucursal').val(),
            servicio: $('#servicio').val(),
            fecha: $('#fecha').val(),
            hora: $('#hora').val(),
        };

        // Validar si todos los campos están seleccionados antes de enviar la solicitud
        if (!formData.sucursal || !formData.servicio || !formData.fecha || !formData.hora) {
            $('#mensajeSinCita').removeClass('d-none').text('Por favor, complete todos los campos antes de agendar.');
            return;
        }

        $.ajax({
            url: '/barberia/php/agenda.php',
            type: 'POST',
            data: { action: 'agendar_cita', ...formData },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#cuadroCita').removeClass('d-none');
                    $('#fecha').text(response.fecha);
                    $('#hora').text(response.hora);
                    $('#sucursal').text(response.sucursal);
                } else {
                    $('#mensajeSinCita').removeClass('d-none').text('Error al agendar la cita. Intenta nuevamente.');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al agendar la cita:", error);
                $('#mensajeSinCita').removeClass('d-none').text('Error al agendar la cita. Intenta nuevamente.');
            }
        });
    });
});