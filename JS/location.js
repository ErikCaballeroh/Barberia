// Obtener el enlace por ID
const googleMapsLink = document.getElementById('googleMapsLink');

// Verificar si el enlace existe antes de proceder
if (googleMapsLink) {
  // Hacer una solicitud AJAX para obtener los datos
  fetch('/barberia/php/getLocation.php')
    .then(response => response.json())
    .then(data => {
      // Si el enlace de Google Maps existe en los datos recibidos
      if (data.googlemaps_link) {
        googleMapsLink.href = data.googlemaps_link;
      } else {
        // Usar un enlace genérico si no se encuentra un enlace específico
        googleMapsLink.href = 'https://www.google.com/maps';
      }
    })
    .catch(error => {
      console.error('Error al obtener los datos de contacto:', error);
      // En caso de error, usar un enlace genérico
      googleMapsLink.href = 'https://www.google.com/maps';
    });
}