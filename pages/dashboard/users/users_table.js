$(document).ready(function () {
  // Inicializamos el DataTable sin datos estáticos y configuramos las columnas
  const table = $("#myTable").DataTable({
    ajax: {
      url: "get_users.php",
      type: "GET",
      dataType: "json",
      dataSrc: "", // Define que los datos se extraigan directamente del array en la respuesta
      error: function (xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: "Error al cargar los datos: " + status + " " + error,
        });
      },
    },
    columns: [
      {
        title: "Usuario",
        data: "username",
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
        },
      },
      {
        title: "Correo",
        data: "email",
      },
      {
        title: "Acciones",
        data: null,
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Editar</button>
          <button class="btn btn-danger btn-sm delete-btn">Eliminar</button>
        `,
      },
    ],
    pageLength: 5,
    lengthMenu: [5, 10, 15, 20],
  });

  // Evento para mostrar u ocultar la contraseña 
  $('#myTable').on('click', '.toggle-password', function () {
    let passwordSpan = $(this).siblings('.password');
    let currentPassword = passwordSpan.attr('data-password');
    if (passwordSpan.text() === "***************") {
      passwordSpan.text(currentPassword); // Mostrar la contraseña 
      $(this).text("Ocultar"); // Cambiar texto del botón a "Ocultar" 
    } else {
      passwordSpan.text("***************"); // Ocultar la contraseña 
      $(this).text("Ver"); // Cambiar texto del botón a "Ver" 
    }
  });
  $("#myTable").on("click", ".edit-btn", function () {
    // Obtener los datos de la fila donde se hizo clic
    let rowData = table.row($(this).parents("tr")).data();

    // Rellenar el formulario del modal con los datos del usuario
    $("#userId").val(rowData.id_user); // Asignar el ID del usuario al campo oculto
    $("#username").val(rowData.username); // Asignar el nombre de usuario al campo de texto
    $("#email").val(rowData.email); // Asignar el correo electrónico al campo de texto

    // Mostrar el modal de edición
    $("#editUserModal").modal("show");
  });

  // Enviar cambios al backend al guardar en el modal de edición
  $("#editUserForm").on("submit", function (e) {
    e.preventDefault();
    // Obtener los valores de los campos del formulario
    const userId = $("#userId").val();
    const username = $("#username").val();
    const email = $("#email").val();

    // Validar que todos los campos estén completos
    if (!userId || !username || !email) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos incompletos',
        text: "Por favor, complete todos los campos.",
      });
      return; // Detener el envío si algún campo está vacío
    }

    const formData = {
      id_user: userId,
      username: username,
      email: email
    };

    $.ajax({
      url: "update_user.php", // Archivo PHP para actualizar los datos
      type: "POST",
      data: formData,
      dataType: "json", // Asegúrate de recibir la respuesta como JSON
      success: function (response) {


        // Si la respuesta es exitosa
        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: response.message,
          }); // Mostrar mensaje de éxito
          table.ajax.reload(); // Recargar la tabla
          $("#editUserModal").modal("hide"); // Ocultar el modal
        } else {

          // Si la respuesta tiene un error, mostrarlo
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error al actualizar el usuario: ' + (response.error || 'Desconocido'),
          });

        }
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Error en la solicitud',
          text: 'Error en la solicitud: ' + status + ' ' + error,
        });
      }
    });
  });

  $("#myTable").on("click", ".delete-btn", function () {
    const rowData = table.row($(this).parents("tr")).data();



    // Verificar que rowData contiene un id_user
    if (!rowData || !rowData.id_user) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "No se ha encontrado el ID del usuario.",
      });
      return;  // Detener el proceso si no se encuentra el ID
    }


    if (confirm(`¿Estás seguro de que deseas eliminar a ${rowData.username}?`)) {
      $.ajax({
        url: "delete_user.php", // Archivo PHP para eliminar el usuario
        type: "POST",
        data: { id_user: rowData.id_user },
        dataType: "json", // Asegúrate de recibir la respuesta como JSON
        success: function (response) {


          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Usuario eliminado',
              text: 'El usuario ha sido eliminado correctamente',
            });
            table.ajax.reload(); // Recargar la tabla
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Error al eliminar el usuario: ' + (response.error || 'Desconocido'),
            });
          }
        },
        error: function (xhr, status, error) {

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error en la solicitud AJAX: ' + status + ' ' + error,
          });
        }
      });
    }
  });
}); 