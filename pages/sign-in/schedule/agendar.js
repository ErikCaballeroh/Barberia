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
        data: { barber_id: 1 },
        crossDomain: true
    }).done(function (result) {
        console.log($("#select-sucursales").val())
        console.log(result)
        let disableDays = []

        // Recorrer la respuesta para identificar días deshabilitados
        result.forEach((daysArray) => {
            daysArray.forEach((day, i) => {
                if (day === '0' && !disableDays.includes(i + 1)) {
                    disableDays.push(i + 1);
                }
            });
        });

        console.log(disableDays)
        // Cambiar configuracion del datepicker
        $("#datepicker").pickadate('picker').set('disable', disableDays);
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
        crossDomain: true
    }).done(function (result) {
        console.log(result)

        $('#timepicker').pickatime({
            interval: 60,
            min: [result.opening_hour, 0],
            max: [result.closing_hour, 0]
        })
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
    // getServiceDays()
    getOpenCloseTime()

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
        format: 'dd/mm/yyyy',
    });

    // $("#date-control").hide()
    $("#time-control").hide()
});

$("#select-sucursales").change(function () {
    if ($(this).val() !== "") {
        $("#date-control").show()
        getServiceDays()
    } else {
        $("#date-control").hide()
    }
})