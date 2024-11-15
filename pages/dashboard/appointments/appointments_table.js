$(document).ready(function () {
  // Inicializar el DataTable
  $("#myTable").DataTable({
    ajax: "getAppointments.php", // Ruta al archivo PHP
    // Definimos las columnas iniciales
    columns: [
      { title: "Usuario", data: "user" },
      { title: "Fecha", data: "date" },
      { title: "Hora", data: "time" },
      { title: "Servicio", data: "service" },
      {
        title: "Acciones",
        data: null, // No se toma de los datos, será un campo personalizado
        defaultContent: `
          <button class="btn btn-primary btn-sm edit-btn">Ver detalles</button>
        `
      }
    ],

    // Carga de datos de prueba
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
});