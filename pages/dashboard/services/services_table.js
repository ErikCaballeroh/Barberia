$(document).ready(function () {
  // Inicializamos el DataTable
  $("#myTable").DataTable({
    // Definimos las columnas iniciales
    columns: [
      {
        text: "Servicio",
        data: "service"
      },
      {
        text: "Descripcion",
        data: "description"
      },
      {
        text: "Precio",
        data: "price"
      },
      {
        text: "Categoria",
        data: "category"
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
      { "service": "Corte", "description": "Corte de cabello clásico y moderno", "price": "$120", "category": "Servicio individual" },
      { "service": "Afeitado", "description": "Afeitado completo con toalla caliente", "price": "$80", "category": "Servicio individual" },
      { "service": "Corte y Afeitado", "description": "Corte de cabello y afeitado completo", "price": "$180", "category": "Servicio combinado" },
      { "service": "Perfilado de Barba", "description": "Perfilado y mantenimiento de barba", "price": "$100", "category": "Servicio individual" },
      { "service": "Coloración", "description": "Tinte para cabello corto", "price": "$150", "category": "Servicio individual" },
      { "service": "Masaje Capilar", "description": "Relajación con masaje capilar", "price": "$50", "category": "Servicio adicional" },
      { "service": "Tratamiento Capilar", "description": "Hidratación profunda para el cabello", "price": "$130", "category": "Servicio individual" },
      { "service": "Corte de Cabello Infantil", "description": "Corte de cabello para niños", "price": "$90", "category": "Servicio individual" },
      { "service": "Estilizado", "description": "Peinado y estilizado para eventos", "price": "$70", "category": "Servicio adicional" },
      { "service": "Rasurado Corporal", "description": "Rasurado en áreas específicas", "price": "$100", "category": "Servicio adicional" }
    ],

    pageLength: 5, // Número de filas por página
    lengthMenu: [5, 10, 15, 20], // Opciones disponibles para que el usuario elija el número de filas
  });
});
