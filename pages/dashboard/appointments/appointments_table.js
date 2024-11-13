$(document).ready(function () {
  // Inicializamos el DataTable
  $("#myTable").DataTable({
    // Definimos las columnas iniciales
    columns: [
      {
        text: "Usuario",
        data: "user"
      },
      {
        text: "Fecha",
        data: "date",
      },
      {
        text: "Hora",
        data: "time"
      },
      {
        text: "Servicio",
        data: "service"
      },
      {
        title: "Acciones",
        data: null, // No se toma de los datos, será un campo personalizado
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Ver detlles</button>
        `
      }
    ],

    // Carga de datos
    data: [
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
      { user: "JuanPerez", date: "11/12/2024", time: "14:00", service: "Corte de cabello" },
    ],

    pageLength: 5, // Número de filas por página
    lengthMenu: [5, 10, 15, 20], // Opciones disponibles para que el usuario elija el número de filas
  });

  // Evento para mostrar u ocultar la contraseña
  $('#myTable').on('click', '.toggle-password', function () {
    let passwordSpan = $(this).siblings('.password');
    let currentPassword = passwordSpan.data('password');

    if (passwordSpan.text() === "***************") {
      passwordSpan.text(currentPassword); // Mostrar la contraseña
      $(this).text("Ocultar"); // Cambiar texto del botón a "Ocultar"
    } else {
      passwordSpan.text("***************"); // Ocultar la contraseña
      $(this).text("Ver"); // Cambiar texto del botón a "Ver"
    }
  });
});
