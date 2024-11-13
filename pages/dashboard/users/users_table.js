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
        text: "Contraseña",
        data: "password",
        render: function (data, type, row, meta) {
          // Muestra asteriscos por defecto y el botón "Ver"
          return `
            <div class="d-flex justify-content-between">
              <span class="password d-inline-block" data-password="${data}">***************</span>
              <button class="btn btn-secondary btn-sm toggle-password me-3">Ver</button>
            </div>
          `
        }
      },
      {
        text: "Correo",
        data: "email"
      },
      {
        title: "Acciones",
        data: null, // No se toma de los datos, será un campo personalizado
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Editar</button>
          <button class="btn btn-danger btn-sm delete-btn">Eliminar</button>
        `
      }
    ],

    // Carga de datos
    data: [
      { user: "JuanPerez", password: "MOndiaNdR!8", email: "juanperez@mail.com" },
      { user: "MariaLopez", password: "Pass1234!", email: "marialopez@mail.com" },
      { user: "CarlosGomez", password: "1234Gomez!", email: "carlosgomez@mail.com" },
      { user: "AnaMartinez", password: "AnaPass$123", email: "anamartinez@mail.com" },
      { user: "LuisRodriguez", password: "Lui$9876", email: "luisrodriguez@mail.com" },
      { user: "ElenaSanchez", password: "Elena2024#", email: "elenasanchez@mail.com" },
      { user: "DavidPerez", password: "D4vidP@ss!", email: "davidperez@mail.com" },
      { user: "SofiaGarcia", password: "S0f!@Garc!a", email: "sofia@garcia.com" },
      { user: "JorgeMartinez", password: "J0rge#Mart4", email: "jorge.martinez@mail.com" },
      { user: "CarmenDiaz", password: "C@rmen123!", email: "carmendiaz@mail.com" }
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
