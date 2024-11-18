$(document).ready(function () {
    // Evento de envío del formulario
    $('form').submit(function (event) {
        event.preventDefault();  // Evitar que el formulario se envíe de manera tradicional

        // Obtener los valores del formulario
        var whatsapp = $("input[name='whatsapp']").val();
        var maps = $("input[name='maps']").val();

        // Realizar la solicitud AJAX
        $.ajax({
            url: '/barberia/pages/dashboard/contact-settings/get_number_link.php', // Ruta del archivo PHP
            type: 'POST',
            data: {
                whatsapp: whatsapp,
                maps: maps
            },
            success: function (response) {
                // Intentamos analizar la respuesta como JSON
                try {
                    var res = JSON.parse(response);  // Intentar convertir la respuesta en JSON

                    // Si la respuesta es exitosa
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Actualizado!',
                            text: res.message,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();  // Recargar la página para reflejar los cambios
                        });
                    } else {
                        // Si ocurrió un error
                        Swal.fire({
                            title: 'Error!',
                            text: res.message,
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    console.error("Error al analizar JSON: ", e);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Hubo un problema con la respuesta del servidor.',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr, status, error) {
                // Si la solicitud falla
                Swal.fire({
                    title: 'Error!',
                    text: 'Hubo un error al realizar la solicitud.',
                    icon: 'error'
                });
            }
        });
    });
});