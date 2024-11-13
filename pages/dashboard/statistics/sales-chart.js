$(document).ready(function () {
  const $canvasChart = $("#sales-chart").get(0)
  let myChart = echarts.init($canvasChart)

  // Specify the configuration items and data for the chart
  let option = {
    title: {
      text: 'Servicios mas vendidos'
    },
    tooltip: {},
    legend: {
      data: ['Ventas']
    },
    xAxis: {
      data: ['Corte', 'Afeitado', 'Coloración', 'Estilizado', 'Tratamiento Capilar', 'Rasurado Corporal'],
      axisLabel: {
        rotate: 30
      }
    },
    yAxis: {},
    series: [
      {
        name: 'Ventas',
        type: 'bar',
        data: [5, 20, 36, 10, 10, 20]
      }
    ]
  };

  // Display the chart using the configuration items and data just specified.
  myChart.setOption(option);
})