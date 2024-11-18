function getAppointmentsByDay() {
  $.ajax({
    url: "get_appointments_by_days.php",
    type: "GET",
    dataType: "json",
    crossDomain: true
  }).done(function (result) {
    console.log(result)

    const days = [], total = []

    result.forEach(el => {
      days.push(el.day_week)
      total.push(el.total_appointments)
    })

    console.log(days)
    console.log(total)

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
        data: days,
        axisLabel: {
          rotate: 30
        }
      },
      yAxis: {},
      series: [
        {
          name: 'Citas por dia',
          type: 'line',
          data: total
        }
      ]
    };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);

  }).fail(function (xhr, status, error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error,
    });
  })
}

$(document).ready(function () {
  getAppointmentsByDay()
})