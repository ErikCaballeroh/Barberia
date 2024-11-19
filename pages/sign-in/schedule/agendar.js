import { cargarCitas } from "./look_citas";

function getBarbers() {
    $.ajax({
        url: "sucursales.php",
        type: "GET",
        dataType: "json",
        crossDomain: true
    }).done(function (sucursales) {
        sucursales.forEach(sucursal => {
            // Agregar cada sucursal como una opción al select
            $("#select-sucursales").append($('<option>', {
                value: sucursal.id_barber,
                text: `Sucursal ${sucursal.id_barber}`
            }));
        });
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    })
}

function getServices() {
    $.ajax({
        url: "get_servicios.php",
        type: "GET",
        dataType: "json",
        crossDomain: true
    }).done(function (services) {
        services.forEach(service => {
            // Agregar cada service como una opción al select
            $("#select-service").append($('<option>', {
                value: service.id_service,
                text: service.name
            }));
        });

    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    })
}

function getServiceDays() {
    $.ajax({
        url: "get_service_days.php",
        type: "GET",
        dataType: "json",
        data: { barber_id: $("#select-sucursales").val() },
        crossDomain: true
    }).done(function (result) {
        let disableDays = []

        // Llenar los dias desabilitados
        result.forEach(function (el, i) {
            if (el === "0") disableDays.push(i + 1)
        })

        // Desabilitar los dias del datepicker
        $("#datepicker").pickadate("picker").set("disable", disableDays)
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "DaysOops...",
            text: error,
        });
    })
}

function getOpenCloseTime() {
    $.ajax({
        url: "get_open_close_time.php",
        type: "GET",
        dataType: "json",
        data: { id_barber: $("#select-sucursales").val() },
        crossDomain: true
    }).done(function (result) {

        // Se establecen las horas segun el horario de la barberia
        $("#timepicker").pickatime("picker").set("min", [result.opening_hour, 0]);
        $("#timepicker").pickatime("picker").set("max", [result.closing_hour, 0]);
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    })
}

function blockFulLHours() {
    $.ajax({
        url: "get_full_hours.php",
        type: "GET",
        dataType: "json",
        data: {
            id_barber: $("#select-sucursales").val(),
            date: $("#datepicker").val()
        },
        crossDomain: true
    }).done(function (blokedHours) {
        $("#timepicker").pickatime("picker").set("disable", blokedHours);
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    })
}

function addAppointment() {
    const datetime = $("#datepicker").val() + " " + $("#timepicker").val() + ":00"

    const appointmentData = {
        id_barber: $("#select-sucursales").val(),
        id_service: $("#select-service").val(),
        appointment_datetime: datetime
    }

    $.ajax({
        url: "add_appointment.php",
        type: "GET",
        dataType: "json",
        data: appointmentData,
        crossDomain: true
    }).done(function (response) {
        if (response.success) {
            Swal.fire({
                title: "Actualizado!",
                text: response.success,
                icon: "success"
            });
        } else if (response.error) {
            Swal.fire({
                title: "Error!",
                text: response.error,
                icon: "error"
            });
        }

        cargarCitas
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    })
}

$(document).ready(function () {
    getBarbers()
    getServices()

    // Generamos un pickadate
    $("#datepicker").pickadate({
        monthsFull: [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ],
        monthsShort: [
            'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
        ],
        weekdaysFull: [
            'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
        ],
        weekdaysShort: [
            'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'
        ],
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        format: 'yyyy-mm-dd',
    });

    // Desactivamos el pickadate
    $("#datepicker").pickadate("picker").set("disable", true);

    // Generamos un pickatime
    $('#timepicker').pickatime({
        interval: 60,
        format: 'HH:i'
    })

    // Desactivamos un pickatime
    $("#timepicker").pickatime("picker").set("disable", true);
});

// Codigo a ejecutar al elegir sucursal
$("#select-sucursales").change(function () {

    if ($(this).val() !== "") {
        // Recive el valor del select y habilita los campos de fecha y hora
        $("#datepicker").pickadate("picker").set("enable", true);
        getServiceDays()

        $("#timepicker").pickatime("picker").set("enable", true);
        getOpenCloseTime()
    } else {
        // Si no se elige una sucursal se desactivan los campos de fecha y hora
        $("#datepicker").pickadate("picker").set("disable", true);
        $("#timepicker").pickatime("picker").set("disable", true);
    }
})

$("#datepicker").change(function () {
    $("#timepicker").pickatime('picker').set('disable', false)
    blockFulLHours()
})

$("#appointmentForm").submit(function (e) {
    e.preventDefault()

    Swal.fire({
        title: "Agendar cita",
        text: "Esta seguro de que desea agendar cita?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            addAppointment()
            e.reset()
        }
    });
})