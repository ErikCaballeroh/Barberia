function getTopServices() {
  $.ajax({
    url: "get_top_services.php",
    type: "GET",
    dataType: "json",
    crossDomain: true
  }).done(function (result) {
    const data = []

    result.forEach(service => {
      data.push({ value: service.total_requests, name: service.service_name })
    })

    const $canvasChart = $("#sales-chart").get(0)
    let myChart = echarts.init($canvasChart)
    // Specify the configuration items and data for the chart
    let option = {
      title: {
        text: 'Servicios mas vendidos'
      },
      tooltip: {},
      series: [
        {
          name: 'Ventas',
          type: 'pie',
          data: data
        }
      ],
      label: {
        show: true,
        formatter: '{b}: {d}%'  // Aquí se agrega el porcentaje
      }
    };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);

  }).fail(function (xhr, status, error) {
    alert(error)
  })
}

$(document).ready(function () {
  getTopServices()
})