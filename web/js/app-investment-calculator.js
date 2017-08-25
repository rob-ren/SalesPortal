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
        document.getElementById('year').value = currentVal+1;
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
        document.getElementById('year').value = currentVal-1;
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

function rentWeeklyCalculate() {
    $('input[name=rent_weekly]').val((price * 0.05 /52).toFixed(0));
}
$(".rent_weekly").change(rentWeeklyCalculate);
window.onload = rentWeeklyCalculate;