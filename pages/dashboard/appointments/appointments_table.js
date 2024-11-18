$(document).ready(function () {
  $("#myTable").DataTable({
    ajax: {
      url: "getAppointments.php",
      type: "GET",
      dataType: "json",
      dataSrc: "",
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos:", error);
        alert("Error al cargar los datos. Por favor, inténtalo más tarde.");
      }
    },
    columns: [
      { data: "user" },
      { data: "date" },
      { data: "time" },
      { data: "service" }
    ],
    pageLength: 5,
    lengthMenu: [5, 10, 15, 20]
  });
});