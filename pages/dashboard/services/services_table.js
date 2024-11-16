$(document).ready(function () {
  // Inicializamos el DataTable
  var table = $("#myTable").DataTable({
    ajax: {
      url: 'get_services.php', // Archivo PHP para obtener los datos
      dataSrc: '' // Los datos JSON se insertarán en el cuerpo de la tabla
    },
    columns: [
      { title: "Servicio", data: "service" },
      { title: "Descripcion", data: "description" },
      { title: "Precio", data: "price" },
      {  title: "Categoria", data: "category" },
      {
        title: "Acciones",
        data: null, // Este campo no proviene de los datos directamente
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Editar</button>
          <button class="btn btn-danger btn-sm delete-btn">Eliminar</button>
        `
      }
    ],
    pageLength: 5, // Número de filas por página
    lengthMenu: [5, 10, 15, 20], // Opciones para elegir el número de filas
  });
      // Cargar categorías para el select cuando se abra el modal de edición
      function loadCategoriesForModal() {
          $.ajax({
              url: 'get_categories.php', // Este es el archivo que obtiene las categorías
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  var categoryDropdown = $('#editServiceCategory');
                  categoryDropdown.empty(); // Limpiar las opciones existentes
  
                  // Añadir una opción por defecto si no hay ninguna
                  categoryDropdown.append('<option value="" disabled selected>Selecciona una categoría</option>');
  
                  // Rellenar las opciones con las categorías
                  data.forEach(function(category) {
                      categoryDropdown.append('<option value="' + category.id_category + '">' + category.name + '</option>');
                  });
              },
              error: function() {
                  alert('Error al cargar las categorías');
              }
          });
      }
  
      // Abrir el modal de edición y cargar los datos
      $('#myTable tbody').on('click', 'button.edit-btn', function() {
          var data = table.row($(this).parents('tr')).data(); // Obtener los datos de la fila
          console.log("Datos seleccionados para editar:", data);
  
          // Llenar los campos del formulario con los datos del servicio seleccionado
          $('#editServiceId').val(data.id_service);
          $('#editServiceName').val(data.name);
          $('#editServiceDescription').val(data.description);
          $('#editServicePrice').val(data.price);
          $('#editServiceCategory').val(data.id_category); // Establecer la categoría seleccionada
  
          // Cargar las categorías antes de mostrar el modal
          loadCategoriesForModal();
  
          // Mostrar el modal
          $('#editServiceModal').modal('show');
      });
  
      // Manejar el evento de guardar cambios
      $('#updateService').on('click', function() {
          var formData = $('#editServiceForm').serialize(); // Obtener los datos del formulario
  
          // Enviar los datos al servidor para actualizar el servicio
          $.ajax({
              url: 'update_service.php', // Archivo PHP que procesa la actualización
              method: 'POST',
              data: formData,
              dataType: 'json',
              success: function(response) {
                  if (response.success) {
                      alert('Servicio actualizado correctamente');
                      $('#editServiceModal').modal('hide'); // Cerrar el modal
                      table.ajax.reload(); // Recargar la tabla para mostrar los datos actualizados
                  } else {
                      alert('Error al actualizar el servicio: ' + response.message);
                  }
              },
              error: function() {
                  alert('Error al procesar la solicitud.');
              }
          });
      });
  
  // Event listener para el botón de eliminar 
  $('#myTable tbody').on('click', 'button.delete-btn', function() {
    const data = table.row($(this).parents('tr')).data(); // Obtener datos de la fila

    if (confirm("¿Estás seguro de que deseas eliminar este servicio?")) {
        $.ajax({
            url: 'delete.php', // Archivo PHP que maneja la eliminación
            method: 'POST',
            data: { serviceId: data.id_service }, // Enviar ID del servicio
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message); // Mostrar mensaje de éxito
                    table.ajax.reload(); // Recargar la tabla
                } else {
                    alert('Error: ' + response.message); // Mostrar mensaje de error
                }
            },
            
        });
    }
});
  $.ajax({
    url: 'get_categories.php', //devuelve las categorías
    method: 'GET',
    dataType: 'json',
    success: function (data) {
        var categoriesDropdown = $('#serviceCategory');
        categoriesDropdown.empty(); // Limpiar el select
        categoriesDropdown.append('<option value="" disabled selected>Selecciona una categoría</option>');
        data.forEach(function (category) {
            categoriesDropdown.append('<option value="' + category.id_category + '">' + category.name + '</option>');
        });
    },
    error: function () {
        alert('Error al cargar las categorías.');
    }
});
// guardar servicio
$('#saveService').on('click', function () {
  var formData = $('#addServiceForm').serialize(); // datos del formulario
  $.ajax({
      url: 'add_service.php',
      method: 'POST',
      data: formData,
      dataType: 'json', // Asegúrate de que la respuesta sea JSON
      success: function (response) {
          if (response.success) {
              alert(response.message);
              $('#addServiceModal').modal('hide');
              $('#addServiceForm')[0].reset(); // Resetear el formulario
              $('#myTable').DataTable().ajax.reload(); // Recargar la tabla
          } else {
              alert('Error: ' + response.message);
          }
      },
      error: function () {
          alert('Error al procesar la solicitud.');
      }
  });
});

$('#saveCategory').on('click', function () {
  var formData = $('#addCategoryForm').serialize(); // Serializar datos del formulario

  // Enviar la categoría al servidor
  $.ajax({
      url: 'add_category.php', // Archivo PHP para guardar la categoría
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function (response) {
          if (response.success) {
              alert(response.message);
              $('#addCategoryModal').modal('hide'); // Cerrar el modal
              $('#addCategoryForm')[0].reset(); // Limpiar el formulario
              // Opcional: Recargar categorías dinámicamente en el otro formulario
              $('#serviceCategory').append(
                  `<option value="${response.category_id}">${response.category_name}</option>`
              );
          } else {
              alert('Error: ' + response.message);
          }
      },
      error: function () {
          alert('Error al agregar la categoría.');
      }
  });
}); 
});