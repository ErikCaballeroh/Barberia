$(document).ready(function () {
  const $canvasChart = $("#appointments-chart").get(0)
  let myChart = echarts.init($canvasChart)

  // Specify the configuration items and data for the chart
  let option = {
    title: {
      text: 'Citas por dia'
    },
    tooltip: {},
    legend: {
      data: ['Citas']
    },
    xAxis: {
      type: "category",
      data: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      axisLabel: {
        rotate: 30
      }
    },
    yAxis: {},
    series: [
      {
        name: 'Citas por dia',
        type: 'line',
        data: [12, 6, 9, 14, 16, 13, 18]
      }
    ]
  };

  // Display the chart using the configuration items and data just specified.
  myChart.setOption(option);
})