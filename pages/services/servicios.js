function getServices() {
    $.ajax({
        url: "get_services.php",
        type: "GET",
        dataType: "json",
        crossDomain: true
    }).done(function (servicesData) {

        // Referencia a la sección de servicios
        const $servicesSection = $("#services-section").addClass("container");

        // Iterar sobre las categorías
        servicesData.forEach(category => {
            // Crear el contenedor de la categoría
            const $categoryContainer = $("<div>").addClass("mb-5");

            // Título de la categoría con estilo
            const $categoryHeader = $("<div>")
                .addClass("category-header border-bottom pb-2 mb-3")
                .append(`<h3 class="text-dark">${category.category_name}</h3>`);

            // Contenedor para los servicios
            const $servicesList = $("<div>").addClass("row g-3"); // g-3 para espacios uniformes

            // Iterar sobre los servicios
            category.services.forEach(service => {
                const $serviceCard = $("<div>").addClass("col-md-4");
                $serviceCard.html(`
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-dark">${service.service_name}</h5>
                        <p class="card-text text-muted">${service.description || "Sin descripción disponible"}</p>
                        <p class="card-text text-success"><strong>Precio:</strong> $${service.price}</p>
                    </div>
                </div>
            `);
                $servicesList.append($serviceCard);
            });

            // Agregar todo al contenedor principal
            $categoryContainer.append($categoryHeader, $servicesList);
            $servicesSection.append($categoryContainer);
        });

    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error,
        });
    });
}

$(document).ready(function () {
    getServices();
});
