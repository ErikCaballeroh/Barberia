$.ajax({
    url: 'sucursales.php',  // El archivo PHP que obtiene los empleados
    type: 'GET',            // Usamos el método GET
    dataType: 'json',       // Esperamos una respuesta en formato JSON
    success: function (sucursales) {
        // Verificar que sucursales sea un array
        if (Array.isArray(sucursales)) {
            sucursales.forEach(sucursal => {
                console.log(sucursal.id_barber); // Imprimir para verificar el valor

                // Agregar cada sucursal como una opción al select
                $("#sucursal").append($('<option>', {
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
