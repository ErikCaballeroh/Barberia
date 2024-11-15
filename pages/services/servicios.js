//ajax
fetch('get_services.php')
.then(response => response.json())
.then(data => {
    // Selecciona los contenedores correspondientes
    const serviciosIndividualesList = document.querySelector('.service-list');
    const serviciosAdicionalesList = document.getElementById('serviciosAdicionalesList');
    const paquetesList = document.getElementById('paquetesList');

    // Verificar si los contenedores existen
    if (!serviciosIndividualesList) {
        console.error('Contenedor de "Servicios Individuales" no encontrado.');
    }
    if (!serviciosAdicionalesList) {
        console.error('Contenedor de "Servicios Adicionales" no encontrado.');
    }
    if (!paquetesList) {
        console.error('Contenedor de "Paquetes" no encontrado.');
    }

    // Itera sobre cada categoría y servicio
    data.forEach(category => {
        // Clasificar por categoría
        category.services.forEach(service => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <strong>${service.service_name}</strong><br>
                <p>${service.description}</p>
                <p>Precio: $${service.price}</p>
            `;

            if (category.category_name === "Servicios Individuales") {
                serviciosIndividualesList.appendChild(listItem);
            } else if (category.category_name === "Servicios Adicionales") {
                serviciosAdicionalesList.appendChild(listItem);
            } else if (category.category_name === "Paquetes") {
                paquetesList.appendChild(listItem);
            }
        });
    });
})
.catch(error => console.error('Error:', error));