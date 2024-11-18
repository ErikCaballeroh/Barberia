// Fetch para obtener el número desde el servidor
fetch('/barberia/pages/php/getContact.php')
.then(response => response.json())
.then(data => {
  const whatsappButton = document.getElementById('whatsappButton');
  const serviceNumber = data.service_number || '1234567890'; // Número predeterminado
  whatsappButton.href = `https://wa.me/${serviceNumber}`;
})
.catch(error => {
  console.error('Error al obtener el número de WhatsApp:', error);
  // Si hay un error, asigna el número predeterminado
  document.getElementById('whatsappButton').href = 'https://wa.me/1234567890';
});