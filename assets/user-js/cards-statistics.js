/**
 * Statistics Cards
 */

'use strict';

(function () {
  let cardColor, shadeColor, labelColor, headingColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    headingColor = config.colors.headingColor;
    shadeColor = '';
  }

  // Donut Chart Colors
  const chartColors = {
    donut: {
      series1: '#66C732',
      series2: '#8DE45F',
      series3: '#AAEB87',
      series4: '#E3F8D7'
    }
  };

  // Fetching dynamic values from the div
  const leadsReportChartEl = document.querySelector('#leadsReportChart');
  if (leadsReportChartEl !== null) {
    const totalPlans = parseInt(leadsReportChartEl.getAttribute('data-plans')) || 0;
    const totalLottery = parseInt(leadsReportChartEl.getAttribute('data-lottery')) || 0;
    const totalPercentage = parseInt(leadsReportChartEl.getAttribute('data-total-percentage')) || 0;

    // Order Statistics Chart
    const leadsReportChartConfig = {
      chart: {
        height: 157,
        width: 130,
        parentHeightOffset: 0,
        type: 'donut'
      },
      labels: ['Plans', 'Lottery'],
      series: [totalPlans, totalLottery], // Dynamic series
      stroke: {
        width: 0
      },
      dataLabels: {
        enabled: false,
        formatter: function (val, opt) {
          return parseInt(val) + '%';
        }
      },
      legend: {
        show: false
      },
      tooltip: {
        theme: false
      },
      grid: {
        padding: {
          top: 15
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              value: {
                fontSize: '1.5rem',
                fontFamily: 'Public Sans',
                color: headingColor,
                fontWeight: 500,
                offsetY: -15,
                formatter: function (val) {
                  return parseInt(val) + '%';
                }
              },
              name: {
                offsetY: 20,
                fontFamily: 'Public Sans'
              },
              total: {
                show: true,
                fontSize: '15px',
                fontFamily: 'Public Sans',
                label: 'Of Target',
                color: legendColor,
                formatter: function (w) {
                  return totalPercentage + '%'; // Dynamic total percentage
                }
              }
            }
          }
        }
      }
    };

    const leadsReportChart = new ApexCharts(leadsReportChartEl, leadsReportChartConfig);
    leadsReportChart.render();
  }
})();
