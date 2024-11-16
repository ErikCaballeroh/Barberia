$(document).ready(function () {
  // Inicializar el DataTable
  $("#myTable").DataTable({
    
    ajax: {
      url: "getAppointments.php", // Archivo PHP que genera el JSON
      type: "GET", // Método de solicitud (GET en este caso)
      dataType: "json", // Especifica el tipo de datos esperado
      dataSrc: "", // El JSON contiene directamente un array
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos:", status, error); // Mensaje en consola para depuración
        alert("No se pudieron cargar los datos. Por favor, inténtalo más tarde."); // Notifica al usuario
      },
    },
    // Definimos las columnas iniciales
    columns: [
      { title: "Usuario", data: "user" },
      { title: "Fecha", data: "date" },
      { title: "Hora", data: "time" },
      { title: "Servicio", data: "service" },
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