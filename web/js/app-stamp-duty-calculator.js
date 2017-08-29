/**
 * Created by robert on 16-6-24.
 */

/**
 * Tax bracket object.
 */
function Bracket(min, max, base, rate) {
    this.min = min;
    this.max = max;
    this.base = base;
    this.rate = rate;
}
/**
 * Check if given number is within the range. This check considers the
 * range as a inclusive set i.e., [min, max].
 *
 * Same as number ∈ [min, max].
 *
 * @param   {number} number Number to check.
 * @returns {boolean} True if number is in (inclusive) range, otherwise false.
 */
Bracket.prototype.contains = function (number) {
    return this.min <= number && number <= this.max;
};
/**
 * detect radio button changed action
 */

$(".stamp_duty_calcualte").change( stampDutypCalculation);
$(".firb_surcharge_calcualte").change( firbSurchargeCalculation);

$( "#stamp_duty_tooltips" ).click(function() {
    stampDutypCalculation();
});

/**
 * calculate firb surcharge for AU states
 */
function firbSurchargeCalculation() {
    var client_type = $('input[name="client_type"]:checked').val();
    var states = $('input[name="state"]:checked').val();

    if(states=='VIC' && client_type=='firb'){
        $('input[name=firb_surcharge]').val((price * 0.07).toFixed(0));
    }
    else if(states=='NSW' && client_type=='firb'){
        $('input[name=firb_surcharge]').val((price * 0.04).toFixed(0));
    }
    else if(states=='QLD' && client_type=='firb'){
        $('input[name=firb_surcharge]').val((price * 0.03).toFixed(0));
    }else{
        $('input[name=firb_surcharge]').val(0);
    }
}
/**
 * calculate stamp duty for AU states
 */
function stampDutypCalculation() {
    var states = $('input[name="state"]:checked').val();
    var first_home = $('input[name="first_home"]:checked').val();
    var property_type = $('input[name="property_type"]:checked').val();
    var full_stamp_duty = null;
    var states_array = ['VIC','NSW','ACT','QLD','TAS','WA','SA'];
    var brackets = null;
    switch (states) {
        case 'VIC':
            if (property_type == 'investment_property') {
                brackets = [
                    new Bracket(0, 25000, 0, 1.4),
                    new Bracket(25000, 130000, 350, 2.4),
                    new Bracket(130000, 960000, 2870, 6),
                    new Bracket(960000, Infinity, 0, 5.5)
                ];
            } else {
                brackets = [
                    new Bracket(0, 25000, 0, 1.4),
                    new Bracket(25000, 130000, 350, 2.4),
                    new Bracket(130000, 440000, 2870, 5),
                    new Bracket(440000, 550000, 18370, 6),
                    new Bracket(130000, 600000, 2870, 6),
                    new Bracket(130000, 960000, 2870, 6),
                    new Bracket(960000, Infinity, 0, 5.5)
                ];
            }
            break;
        case 'NSW':
            if (first_home == 'yes' && property_type == 'primary_residence') {
                brackets = [
                    new Bracket(0, 550000, 0, 0),
                    new Bracket(550000, 650000, -136070, 24.74),
                    new Bracket(300000, 1000000, 8990, 4.5),
                    new Bracket(1000000, 3000000, 40490, 5.5),
                    new Bracket(3000000, Infinity, 150490, 7)
                ];
            }
            else {
                brackets = [
                    new Bracket(0, 14000, 0, 1.25),
                    new Bracket(14000, 30000, 175, 1.5),
                    new Bracket(30000, 80000, 415, 1.75),
                    new Bracket(80000, 300000, 1290, 3.5),
                    new Bracket(300000, 1000000, 8990, 4.5),
                    new Bracket(1000000, Infinity, 40490, 5.5)
                ];
            }
            break;
        case 'ACT':
            brackets = [
                new Bracket(0, 0, 0, 0),
                new Bracket(0, 200000, 20, 1.48),
                new Bracket(200000, 300000, 2960, 2.5),
                new Bracket(300000, 500000, 5460, 4),
                new Bracket(500000, 750000, 13460, 5),
                new Bracket(750000, 1000000, 25960, 6.5),
                new Bracket(1000000, 1454999, 42210, 7),
                new Bracket(0, Infinity, 0, 5.09)
            ];
            break;
        case 'QLD':
            if (property_type == 'primary_residence' && first_home == 'no') {
                brackets = [
                    new Bracket(0, 350000, 0, 1),
                    new Bracket(350000, 540000, 3500, 3.5),
                    new Bracket(540000, 1000000, 10150, 4.5),
                    new Bracket(1000000, Infinity, 30850, 5.75)
                ];
            }
            else if (property_type == 'primary_residence' && first_home == 'yes') {
                brackets = [
                    new Bracket(0, 500000, 0, 0),
                    new Bracket(350000, 505000, -5250, 3.5),
                    new Bracket(350000, 510000, -4375, 3.5),
                    new Bracket(350000, 515000, -3500, 3.5),
                    new Bracket(350000, 520000, -2625, 3.5),
                    new Bracket(350000, 525000, -1750, 3.5),
                    new Bracket(350000, 530000, -875, 3.5),
                    new Bracket(350000, 535000, 0, 3.5),
                    new Bracket(350000, 540000, 875, 3.5),
                    new Bracket(540000, 545000, 8400, 4.5),
                    new Bracket(540000, 550000, 9275, 4.5),
                    new Bracket(540000, 1000000, 10150, 4.5),
                    new Bracket(1000000, Infinity, 30850, 5.75)
                ];
            }
            else {
                brackets = [
                    new Bracket(0, 5000, 0, 0),
                    new Bracket(5000, 75000, 0, 1.5),
                    new Bracket(75000, 540000, 1050, 3.5),
                    new Bracket(540000, 1000000, 17325, 4.5),
                    new Bracket(1000000, Infinity, 38025, 5.75)
                ];
            }
            break;
        case 'TAS':
            brackets = [
                new Bracket(0, 0, 0, 0),
                new Bracket(0, 3000, 50, 0),
                new Bracket(3000, 25000, 50, 1.75),
                new Bracket(25000, 75000, 435, 2.25),
                new Bracket(75000, 200000, 1560, 3.5),
                new Bracket(200000, 375000, 5935, 4),
                new Bracket(375000, 725000, 12935, 4.25),
                new Bracket(725000, Infinity, 27810, 4.5)
            ];
            break;
        case 'WA':
            brackets = [
                new Bracket(0, 80000, 0, 1.9),
                new Bracket(80000, 100000, 1520, 2.85),
                new Bracket(100000, 250000, 2090, 3.8),
                new Bracket(250000, 500000, 7790, 4.75),
                new Bracket(500000, Infinity, 19665, 5.15)
            ];
            break;
        case 'SA':
            brackets = [
                new Bracket(0, 12000, 0, 1),
                new Bracket(12000, 30000, 120, 2),
                new Bracket(30000, 50000, 480, 3),
                new Bracket(50000, 100000, 1080, 3.5),
                new Bracket(100000, 200000, 2830, 4),
                new Bracket(200000, 250000, 6830, 4.25),
                new Bracket(250000, 300000, 8955, 4.75),
                new Bracket(300000, 500000, 11330, 5),
                new Bracket(500000, Infinity, 21330, 5.5)
            ];
            break;
        default:
            brackets = [
                new Bracket(0, Infinity, 0, 0),
            ];
            break;
    }
    /**
     * start calculation
     */
    function part(bracket, price) {
        var over = Math.ceil((price - bracket.min) / 100);
        return (bracket.base + (over * bracket.rate));
    }

    function part_nsw(bracket, price) {
        var over = Math.ceil((price - bracket.min) / 100);
        return (bracket.base + (over * bracket.rate));
    }

    var bracket = brackets.filter(function (b) {
        return b.contains(price);
    }).shift();
    if (!bracket) {
        throw new Error('Could not find the tax bracket for ' + price);
    }
    //var stamp_duty_tooltips= "dd";
    var stamp_duty_tooltips= Translator.trans('stamp_duty.tooltips');

    if (states == 'NSW' && first_home == 'yes' && property_type == 'primary_residence' && bracket.max == 650000 && bracket.min == 550000) {
        var result = bracket.base + price * bracket.rate / 100;
        $('#stamp_duty_tooltips').attr('data-original-title', states+' '+stamp_duty_tooltips+' $'+result);
    }
    // else if (states == 'VIC' && bracket.min == 960000) {
    //     var result = price * bracket.rate / 100;
    //     $('#stamp_duty_tooltips').attr('data-original-title', states+' '+stamp_duty_tooltips+' $'+result);
    // }
    else if (states == 'VIC' && first_home == 'yes' && property_type == 'primary_residence' && bracket.max <= 600000) {
        var result = part(bracket, price) / 2;
        $('#stamp_duty_tooltips').attr('data-original-title', states+' '+stamp_duty_tooltips+' $'+result);
    }
    else if (full_stamp_duty == null && states == "VIC"){
        var result = vic_stamp_duty;
        if (bracket.min == 960000){
            var full_stamp_value = price * bracket.rate / 100;
        } else{
            var full_stamp_value = part(bracket, price);
        }
        $('#stamp_duty_tooltips').attr('data-original-title', states+' '+stamp_duty_tooltips+' $'+full_stamp_value);
    }
    else if (states_array.indexOf(states)<0){
        var result = 0;
    }
    else {
        var result = part(bracket, price);
        $('#stamp_duty_tooltips').attr('data-original-title', states+' '+stamp_duty_tooltips+' $'+result);
    }
    $('input[name=stamp_duty]').val(result);
}

window.onload =  function(){
    stampDutypCalculation();
    firbSurchargeCalculation();
}