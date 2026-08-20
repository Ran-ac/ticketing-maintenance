$(function () {

  var options_sales_overview = {
    series: [
      {
        name: "Concerns per Branch",
        data: totals,
      },
    ],
    chart: {
      type: "bar",
      height: 275,
      toolbar: { show: false },
    },
    xaxis: {
      type: "category",
      categories: branches,
    },
  };

  var chart = new ApexCharts(
    document.querySelector("#sales-overview"),
    options_sales_overview
  );

  chart.render();

});