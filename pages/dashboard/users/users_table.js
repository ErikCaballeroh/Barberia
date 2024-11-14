$(document).ready(function () {
  // Inicializamos el DataTable sin datos estáticos y configuramos las columnas
  const table = $("#myTable").DataTable({
    ajax: {
      url: "get_users.php",
      type: "GET",
      dataType: "json",
      dataSrc: "", // Define que los datos se extraigan directamente del array en la respuesta
      error: function (xhr, status, error) {
        alert("Error al cargar los datos:", status, error);
      }
    },
    columns: [
      {
        title: "Usuario",
        data: "username"
      },
      {
        title: "Contraseña",
        data: "password",
        render: function (data, type, row, meta) {
          return `
            <div class="d-flex justify-content-between">
              <span class="password d-inline-block" data-password="${data}">***************</span>
              <button class="btn btn-secondary btn-sm toggle-password me-3">Ver</button>
            </div>
          `;
        }
      },
      {
        title: "Correo",
        data: "email"
      },
      {
        title: "Acciones",
        data: null,
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Editar</button>
          <button class="btn btn-danger btn-sm delete-btn">Eliminar</button>
        `
      }
    ],
    pageLength: 5,
    lengthMenu: [5, 10, 15, 20]
  });

  // Evento para mostrar u ocultar la contraseña
  $('#myTable').on('click', '.toggle-password', function () {
    let passwordSpan = $(this).siblings('.password');
    let currentPassword = passwordSpan.data('password');

    if (passwordSpan.text() === "***************") {
      passwordSpan.text(currentPassword);
      $(this).text("Ocultar");
    } else {
      passwordSpan.text("***************");
      $(this).text("Ver");
    }
  });
});
