// Hacer una solicitud AJAX para obtener los datos
fetch('getAbout.php')
.then(response => response.json())
.then(data => {
  // Insertar el enlace de Google Maps y el número de WhatsApp en el HTML
  if (data.google_maps && data.whatsapp_number) {
    document.getElementById('googleMapsLink').href = data.google_maps;
  } else {
    console.error("No se encontraron los datos de contacto.");
  }
})
.catch(error => {
  console.error('Error al obtener los datos de contacto:', error);
});