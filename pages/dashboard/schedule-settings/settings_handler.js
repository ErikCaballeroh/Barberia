function getSettings() {
  $.ajax({
    url: "get_settings.php",
    type: "GET",
    dataType: "json",
    crossDomain: true
  }).done(function (result) {
    console.log(result)

    let $checkboxes = $(".form-check-input")

    let days = result.service_days
    let binario = days.toString(2); // Convierte el número a binario
    let binario7bits = binario.padStart(7, '0') // Completa 7 bits y transforma en un arreglo
    let daysArray = binario7bits.split('') // Completa 7 bits y transforma en un arreglo


    $checkboxes.each(function (i, checkbox) {
      console.log(daysArray[i], checkbox)
      if (daysArray[i] == 1) $(checkbox).prop("checked", true)
    })

    console.log(result.service_days)
  }).fail(function (xhr, status, error) {
    alert(error)
  })
}

$(document).ready(function () {
  getSettings()

})