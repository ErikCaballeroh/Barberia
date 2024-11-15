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
      { title: "Categoria", data: "category" },
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
  // Función para cargar las categorías dinámicamente desde el servidor
function loadCategories() {
  $.ajax({
    type: 'GET',
    url: 'get_categories.php',
    success: function(response) {
        console.log(response); // Verifica la respuesta
        
        // No es necesario usar JSON.parse() porque la respuesta es un objeto JavaScript
        var categories = response;

        // Limpiar las opciones del select antes de agregar las nuevas
        $('#serviceCategory').empty();

        // Agregar una opción por defecto
        $('#serviceCategory').append('<option value="" disabled selected>Selecciona una categoría</option>');

        // Agregar las categorías desde la base de datos
        categories.forEach(function(category) {
            $('#serviceCategory').append('<option value="' + category.id_category + '">' + category.name + '</option>');
        });
    },
    error: function() {
        alert('Error al cargar las categorías');
    }
});
}


  // Inicializar los modales de Bootstrap
  var addServiceModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
  var addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));

  // Mostrar el modal para agregar un nuevo servicio
  $('#addServiceBtn').on('click', function() {
    addServiceModal.show();
  });

  // Mostrar el modal para agregar una nueva categoría
  $('#addCategoryBtn').on('click', function() {
    addCategoryModal.show();
  });

  // Enviar el formulario de agregar servicio
  $('#saveService').on('click', function() {
    var formData = $('#addServiceForm').serialize();
    
    $.ajax({
      type: 'POST',
      url: 'add_service.php', // Archivo PHP que procesará el formulario
      data: formData,
      success: function(response) {
        alert('Servicio agregado correctamente');
        addServiceModal.hide(); // Cerrar el modal
        $('#myTable').DataTable().ajax.reload(); // Recargar la tabla
      },
      error: function() {
        alert('Error al agregar el servicio');
      }
    });
  });

  // Enviar el formulario de agregar categoría
  $('#saveCategoryBtn').on('click', function() {
    var categoryName = $('#categoryName').val();
    
    $.ajax({
      type: 'POST',
      url: 'add_category.php', // Archivo PHP que procesará la categoría
      data: { name: categoryName },
      success: function(response) {
        alert('Categoría agregada correctamente');
        addCategoryModal.hide(); // Cerrar el modal
        loadCategories(); // Recargar las categorías después de agregar una nueva
      },
      error: function() {
        alert('Error al agregar la categoría');
      }
    });
  });

});