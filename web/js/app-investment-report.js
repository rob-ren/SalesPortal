/**
 * Created by robert on 16-6-9.
 */


// when year=1, hide the advanced report
if (years >1) {
    $('#advancd_collapse').removeClass('hidden');
    $('#remind_info').toggleClass('hidden');
} else {
    $('#advancd_collapse').toggleClass('hidden');
    $('#remind_info').removeClass('hidden');
}

// add body corp
$('#body_corp_plus').click(function (e) {
    e.preventDefault();
    var body_corp = document.getElementById('body_corp').value;
    var currentVal = parseInt(body_corp);
    if (!isNaN(currentVal)) {
        document.getElementById('body_corp').value = (currentVal + 500).toFixed(0);
    } else {
        document.getElementById('body_corp').value = 0;
    }
});
// This button will decrement the value till 0
$("#body_corp_minus").click(function (e) {
    e.preventDefault();
    var body_corp = document.getElementById('body_corp').value;
    var currentVal = parseInt(body_corp);
    if (!isNaN(currentVal) && currentVal > 0) {
        document.getElementById('body_corp').value = (currentVal - 500).toFixed(0);
    } else {
        document.getElementById('body_corp').value = 0;
    }
});
$('#year_plus').click(function (e) {
    e.preventDefault();
    var year = document.getElementById('year').value;
    var currentVal = parseInt(year);
    if (!isNaN(currentVal)) {
        document.getElementById('year').value = currentVal + 1;
    } else {
        document.getElementById('year').value = 0;
    }
});
// This button will decrement the value till 0
$("#year_minus").click(function (e) {
    e.preventDefault();
    var year = document.getElementById('year').value;
    var currentVal = parseInt(year);
    if (!isNaN(currentVal) && currentVal > 0) {
        document.getElementById('year').value = currentVal - 1;
    } else {
        document.getElementById('year').value = 0;
    }
});
function localFunction() {
    $('input[name=stamp_duty]').val((price * 0.055).toFixed(0));
}
function firbFunction() {
    $('input[name=stamp_duty]').val((price * 0.085).toFixed(0));
}

// change weekly rent by price
function rentWeeklyCalculate() {
    $('input[name=rent_weekly]').val((price * 0.05 /52).toFixed(0));
}
$(".rent_weekly").change(rentWeeklyCalculate);

// Using CommonJS
// get calculate value for rental yearly

var format_rental_income_per_year = [];
var format_rental_income_per_year_title = [];
var today = new Date();
var year = today.getFullYear();
//var title_rental_income = Translator.trans('barchart.title_rent_income');
var title_rental_income = 'barchart.title_rent_income';
// start draw chart rental_yearly and property value
var ctx_rental_year = document.getElementById("rental_yearly_chart");
for (var i = 0; i < rental_income_per_year.length; i++) {
    var format_rent_income_value = rental_income_per_year[i].toFixed(0);
    var format_bar_year = year + i;
    format_rental_income_per_year.push(format_rent_income_value);
    format_rental_income_per_year_title.push(format_bar_year);
}
var rental_year_chart = new Chart(ctx_rental_year, {
    type: 'bar',
    data: {
        labels: format_rental_income_per_year_title,
        datasets: [{
            label: title_rental_income,
            data: format_rental_income_per_year,
            backgroundColor: 'rgba(15, 85, 249, 0.2)',
            borderColor: 'rgba(15, 85, 249, 1)',
            borderWidth: 1,
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label;
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return datasetLabel + ':  ' + '$' + Math.round(value).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                },
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (value, index, values) {
                        return '$ ' + Math.round(value).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    }
                },
            }]
        },
        responsive: true
    }
});

// start draw chart property_value
var format_property_value_per_year = [];
var format_property_value_per_year_title = [];
var format_loan_value_per_year = [];
//var title_property_value = Translator.trans('barchart.title_property_value');
//var title_loan_value = Translator.trans('barchart.title_total_loan');
var title_property_value = 'barchart.title_property_value';
var title_loan_value = 'barchart.title_total_loan';
var ctx_property_value = document.getElementById("property_value_chart");
for (var i = 0; i < property_value_per_year.length; i++) {
    var format_property_value_value = property_value_per_year[i].toFixed(0);
    var format_bar_title = year + i;
    format_property_value_per_year.push(format_property_value_value);
    format_loan_value_per_year.push(total_loan);
    format_property_value_per_year_title.push(format_bar_title);
}
var property_chart = new Chart(ctx_property_value, {
    type: 'bar',
    data: {
        labels: format_property_value_per_year_title,
        datasets: [{
            label: title_property_value,
            data: format_property_value_per_year,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: title_loan_value,
            data: format_loan_value_per_year,
            backgroundColor: 'rgba(151, 115, 247, 0.2)',
            borderColor: 'rgba(151,115,247,1)',
            borderWidth: 1
        }]
    },
    options: {
        tooltips: {
            mode: 'label',
            callbacks: {
                label: function (tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label;
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return datasetLabel + ':  ' + '$' + Math.round(value).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                },
            }
        },
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (value, index, values) {
                        return '$ ' + Math.round(value).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    }
                }
            }]
        },
        responsive: true
    }
});

// start draw chart total_return_chart
var format_total_return_year = [];
var format_total_return_year_average = [];
var format_total_return_year_title = [];
var ctx_total_return = document.getElementById("total_return_chart");
for (var i = 0; i < total_return_year.length; i++) {
    var format_total_return_year_value = total_return_year[i].toFixed(1);
    var format_total_return_year_average_value = total_return_year_average[i].toFixed(1);
    var format_bar_title = year + i;
    format_total_return_year.push(format_total_return_year_value);
    format_total_return_year_average.push(format_total_return_year_average_value);
    format_total_return_year_title.push(format_bar_title);
}
var total_return_chart = new Chart(ctx_total_return, {
    type: 'bar',
    data: {
        labels: format_total_return_year_title,
        datasets: [{
            //label: Translator.trans('barchart.title_total_return'),
            label:'barchart.title_total_return',
            data: format_total_return_year,
            backgroundColor: 'rgba(15,218,249,0.2)',
            borderColor: 'rgba(15,218,249,1)',
            borderWidth: 1
        }, {
            //label: Translator.trans('barchart.title_annual_return'),
            label: 'barchart.title_annual_return',
            data: format_total_return_year_average,
            backgroundColor: 'rgba(15,249,116,0.2)',
            borderColor: 'rgba(15,249,116, 1)',
            borderWidth: 1
        }]
    },
    options: {
        tooltips: {
            mode: 'label',
            callbacks: {
                label: function (tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label;
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return datasetLabel + ':  ' + value + '%';
                },
            }
        },
        responsive: true,
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (value, index, values) {
                        return value + "%";
                    }
                }
            }]
        }
    },

});

// start draw chart expanse_percentage

var ctx_expanse_percentage = document.getElementById("expanse_percentage_chart");

var expanse_percentage_chart = new Chart(ctx_expanse_percentage, {
    type: 'pie',
    data: {
        labels: [
            // Translator.trans('barchart.title_out_of_pocket'),
            // Translator.trans('barchart.title_total_loan'),
            // Translator.trans('barchart.title_total_loan_interest'),
            // Translator.trans('barchart.title_misc_fee_total'),
            'barchart.title_out_of_pocket',
            'barchart.title_total_loan',
            'barchart.title_total_loan_interest',
            'barchart.title_misc_fee_total',
        ],
        datasets: [{
            data: [
                out_of_pocket,
                total_loan,
                total_loan_interest,
                misc_fee_total,
            ],
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(15,249,116,0.2)', 'rgba(15, 85, 249, 0.2)', 'rgba(245, 233, 65, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(15,249,116,1)', 'rgba(15, 85, 249, 1)', 'rgba(245, 233, 65, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var value = data.datasets[0].data[tooltipItem.index];
                    var label = data.labels[tooltipItem.index];
                    var percentage = Math.round(value / total_expenses * 100);
                    return label + ': ' + percentage.toFixed(1) + '%';
                }
            }
        },
    },
});