function getSettings() {
  $.ajax({
    url: "get_settings.php",
    type: "GET",
    dataType: "json",
    crossDomain: true
  }).done(function (result) {

    $("#opening-time").val(result.opening_time)
    $("#closing-time").val(result.closing_time)
    $("#max-clients").val(result.max_clients)

    const $checkboxes = $(".form-check-input")

    let days = result.service_days
    let binario = days.toString(2); // Convierte el número a binario
    let binario7bits = binario.padStart(7, '0') // Completa 7 bits y transforma en un arreglo
    let daysArray = binario7bits.split('') // Completa 7 bits y transforma en un arreglo

    $checkboxes.each(function (i, checkbox) {
      if (daysArray[i] == 1) $(checkbox).prop("checked", true) // Marca los chekbox si el dia esta marcado en el arreglo
    })

  }).fail(function (xhr, status, error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error,
    });
  })
}

function updateSettings(formData) {
  $.ajax({
    url: "update_settings.php",
    type: "POST",
    contentType: 'application/json; charset=utf-8',
    dataType: "json",
    crossDomain: true,
    data: JSON.stringify(formData)
  }).done(function (response) {

    console.log(response)

    if (response.success) {
      Swal.fire({
        title: "Actualizado!",
        text: response.success,
        icon: "success"
      });
    } else if (response.error) {
      Swal.fire({
        title: "Error!",
        text: response.error,
        icon: "error"
      });
      alert(response.error)
    }

  }).fail(function (xhr, status, error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error,
    });
  })
}

function loadHours(id) {
  const $select = $(`#${id}`);
  $select.empty(); // Limpia el select en caso de que ya tenga opciones

  for (let hora = 0; hora < 24; hora++) {
    const formatoHoraInput = hora.toString().padStart(2, '0') + ':00';
    const formatoHora = hora.toString().padStart(2, '0') + ':00:00';
    $select.append($('<option>', { value: formatoHora, text: formatoHoraInput }));
  }
}

$(document).ready(function () {
  loadHours("opening-time")
  loadHours("closing-time")
  getSettings()
})

$("#form-settings").on("submit", function (e) {
  e.preventDefault()

  const $checkboxes = $(".form-check-input")
  let days = []
  $checkboxes.each(function (i, checkbox) {
    if ($(checkbox).is(":checked")) days[i] = 1
    else days[i] = 0
  })
  days = parseInt(days.join(''), 2)


  const formUpdateData = {
    opening_time: $('#opening-time').val(),
    closing_time: $('#closing-time').val(),
    max_clients: parseInt($('#max-clients').val(), 10),
    service_days: days
  }

  Swal.fire({
    title: "Realizar cambios?",
    text: "Se aplicaran estos cambios en el sistema",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, aplicar cambios",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      updateSettings(formUpdateData)
    }
  });

})