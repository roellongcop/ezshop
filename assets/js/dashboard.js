var _initStatsWidget2 = function() {
    var element = document.getElementById("kt_stats_widget_2_chart");

    if (!element) {
        return;
    }

    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    35, 30, 35
                ],
                backgroundColor: [
                    KTAppSettings['colors']['gray']['gray-300'],
                    KTAppSettings['colors']['gray']['gray-400'],
                    KTAppSettings['colors']['theme']['base']['primary']
                ]
            }],
            labels: [
                'Angular',
                'CSS',
                'HTML'
            ]
        },
        options: {
            cutoutPercentage: 75,
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'top',
            },
            title: {
                display: false,
                text: 'Technology'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10,
                caretPadding: 0,
                displayColors: false,
                backgroundColor: KTAppSettings['colors']['theme']['base']['primary'],
                titleFontColor: '#ffffff',
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            }
        }
    };

    var ctx = element.getContext('2d');
    var myDoughnut = new Chart(ctx, config);
}


var _initStatsWidget3 = function({data, categories}) {
    var element = document.getElementById("kt_stats_widget_3_chart");

    if (!element) {
        return;
    }

    var options = {
        series: [{
            name: 'Orders',
            data: data
        }],
        chart: {
            type: 'area',
            height: 100,
            toolbar: {
                show: false
            },
            style: {
                borderradiusbottom: '$card-border-radius',
            },
            zoom: {
                enabled: false
            },
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {},
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'solid',
            opacity: 1
        },
        stroke: {
            curve: 'smooth',
            show: true,
            width: 3,
            colors: [KTAppSettings['colors']['theme']['base']['primary']]
        },
        xaxis: {
            categories: categories,
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            },
            labels: {
                show: false,
                style: {
                    colors: KTAppSettings['colors']['gray']['gray-500'],
                    fontSize: '12px',
                    fontFamily: KTAppSettings['font-family']
                }
            },
            crosshairs: {
                show: false,
                position: 'front',
                stroke: {
                    color: KTAppSettings['colors']['gray']['gray-300'],
                    width: 1,
                    dashArray: 3
                }
            },
            tooltip: {
                enabled: true,
                formatter: undefined,
                offsetY: 0,
                style: {
                    fontSize: '12px',
                    fontFamily: KTAppSettings['font-family']
                }
            }
        },
        yaxis: {
            labels: {
                show: false,
                style: {
                    colors: KTAppSettings['colors']['gray']['gray-500'],
                    fontSize: '12px',
                    fontFamily: KTAppSettings['font-family']
                }
            }
        },
        states: {
            normal: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            hover: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            active: {
                allowMultipleDataPointsSelection: false,
                filter: {
                    type: 'none',
                    value: 0
                }
            }
        },
        tooltip: {
            style: {
                fontSize: '12px',
                fontFamily: KTAppSettings['font-family']
            },
            y: {
                formatter: function(val) {
                    return val;
                }
            }
        },
        colors: [KTAppSettings['colors']['theme']['light']['primary']],
        markers: {
            colors: [KTAppSettings['colors']['theme']['light']['primary']],
            strokeColor: [KTAppSettings['colors']['theme']['base']['primary']],
            strokeWidth: 3
        }
    };

    var chart = new ApexCharts(element, options);
    chart.render();
}

_initStatsWidget2();


$.ajax({
    url: app.baseUrl + "dashboard/monthly-orders",
    method: 'get',
    data: {
        year: $('.dashboard-page').data('year'),
    },
    dataType: 'json',
    success: function(s) {
        if (s.status == 'success') {
            _initStatsWidget3({
                data: s.totals,
                categories: s.months
            });

            $('.total-orders').html(s.totalOrders);
        }
    },
    error: (e) => {
        console.log(e)
    }
})
