// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

const companyColors = {
  'GAOC - Maintenance IR Form':        '#4e73df',
  'Novodental - Maintenance IR Form':  '#1cc88a',
  'GSS - Maintenance IR Form':         '#f6c23e',
  'GGC Offices - Maintenance IR Form': '#36b9cc',
};

$.get(window.companyConcernUrl, function (res) {
  const colors = res.labels.map(l => companyColors[l] || '#adb5bd');

  new Chart(document.getElementById("companyConcernChart"), {
    type: 'doughnut',
    data: {
      labels: res.labels,
      datasets: [{
        data: res.values,
        backgroundColor: colors,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: { display: false },
      cutoutPercentage: 80,
    },
  });

  // Build legend from the real data
  const legend = $('#companyConcernLegend').empty();
  res.labels.forEach((label, i) => {
    legend.append(
      $('<span class="me-3 d-inline-block"></span>')
        .append($('<i class="fas fa-circle"></i>').css('color', colors[i]))
        .append(document.createTextNode(' ' + label.replace(' - Maintenance IR Form', '') + ' (' + res.values[i] + ')'))
    );
  });
}).fail(function (xhr) {
  console.error('Company chart failed:', xhr.status, xhr.responseText);
});