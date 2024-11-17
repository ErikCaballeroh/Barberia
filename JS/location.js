// Hacer una solicitud AJAX para obtener los datos
fetch('/barberia/pages/php/getLocation.php')
  .then(response => response.json())
  .then(data => {
    const googleMapsLink = document.getElementById('googleMapsLink');
    
    // Si el enlace existe, úsalo; de lo contrario, redirige a Google Maps genérico
    if (data.googlemaps_link) {
      googleMapsLink.href = data.googlemaps_link;
    } else {
      // Enlace genérico a Google Maps
      googleMapsLink.href = 'https://www.google.com/maps';
    }
  })
  .catch(error => {
    console.error('Error al obtener los datos de contacto:', error);
    // Si ocurre un error, usar el enlace genérico
    document.getElementById('googleMapsLink').href = 'https://www.google.com/maps';
  });