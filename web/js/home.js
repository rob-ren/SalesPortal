(function ($) {
    "use strict";

    // Signup Form

    $("#signup_submit").click(function () {
        //get input field values
        var user_first_name = $('input[name=first_name]').val();
        var user_last_name = $('input[name=last_name]').val();
        var user_email = $('input[name=email]').val();
        var user_password = $('input[name=password]').val();
        var user_confirm_password = $('input[name=confirm_password]').val();
        var proceed = true;

        var post_data, output;

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {
                'first_name': user_first_name,
                'last_name': user_last_name,
                'email': user_email,
                'password': user_password,
                'confirm_password': user_confirm_password
            };
            //Ajax post data to server
            $.ajax({
                type: "POST",
                url: "/register",
                data: post_data,
                success: function (response) {
                    output = '<div class="success"><p style="text-align:left; color:orangered;">' + response.msg + '</p></div>';
                    console.log(post_data);
                    console.log(response);
                    $("#result").hide().html(output).slideDown();
                },
                error: function (response) {
                    output = '<div class="error"><p style="text-align:left; color:orangered;">' + response.msg + '</p></div>';
                    $("#result").hide().html(output).slideDown();
                }

            });

        }
    });

    // functionality for custom dropdown select list
    $('.dropdown-select li a').click(function () {
        if (!($(this).parent().hasClass('disabled'))) {
            $(this).prev().prop("checked", true);
            $(this).parent().siblings().removeClass('active');
            $(this).parent().addClass('active');
            $(this).parent().parent().siblings('.dropdown-toggle').children('.dropdown-label').html($(this).text());
            $('#type_input').val($(this).text());
        }
    });

    $('#state_dropdown').click(function () {
        document.getElementById('hidden_state').value = document.getElementById("state_query").innerHTML;
    });
    $('#type_dropdown').click(function () {
        document.getElementById('hidden_type').value = document.getElementById("type_query").innerHTML;
    });

    var options = {
        zoom: 14,
        mapTypeId: 'Styled',
        disableDefaultUI: true,
        mapTypeControlOptions: {
            mapTypeIds: ['Styled']
        },
        scrollwheel: false
    };
    var styles = [{
        stylers: [{
            hue: "#cccccc"
        }, {
            saturation: -100
        }]
    }, {
        featureType: "road",
        elementType: "geometry",
        stylers: [{
            lightness: 100
        }, {
            visibility: "simplified"
        }]
    }, {
        featureType: "road",
        elementType: "labels",
        stylers: [{
            visibility: "on"
        }]
    }, {
        featureType: "poi",
        stylers: [{
            visibility: "off"
        }]
    }];

    var markers = [];
    var props = [{
        title: 'Modern Residence in New York',
        image: '1-1-thmb.png',
        type: 'For Sale',
        price: '$1,550,000',
        address: '39 Remsen St, Brooklyn, NY 11201, USA',
        bedrooms: '3',
        bathrooms: '2',
        area: '3430 Sq Ft',
        position: {
            lat: 40.696047,
            lng: -73.997159
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Hauntingly Beautiful Estate',
        image: '2-1-thmb.png',
        type: 'For Rent',
        price: '$1,750,000',
        address: '169 Warren St, Brooklyn, NY 11201, USA',
        bedrooms: '2',
        bathrooms: '2',
        area: '4430 Sq Ft',
        position: {
            lat: 40.688042,
            lng: -73.996472
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Sophisticated Residence',
        image: '3-1-thmb.png',
        type: 'For Sale',
        price: '$1,340,000',
        address: '38-62 Water St, Brooklyn, NY 11201, USA',
        bedrooms: '2',
        bathrooms: '3',
        area: '2640 Sq Ft',
        position: {
            lat: 40.702620,
            lng: -73.989682
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'House With a Lovely Glass-Roofed Pergola',
        image: '4-1-thmb.png',
        type: 'For Sale',
        price: '$1,930,000',
        address: 'Wunsch Bldg, Brooklyn, NY 11201, USA',
        bedrooms: '3',
        bathrooms: '2',
        area: '2800 Sq Ft',
        position: {
            lat: 40.694355,
            lng: -73.985229
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Luxury Mansion',
        image: '5-1-thmb.png',
        type: 'For Rent',
        price: '$2,350,000',
        address: '95 Butler St, Brooklyn, NY 11231, USA',
        bedrooms: '2',
        bathrooms: '2',
        area: '2750 Sq Ft',
        position: {
            lat: 40.686838,
            lng: -73.990078
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Modern Residence in New York',
        image: '1-1-thmb.png',
        type: 'For Sale',
        price: '$1,550,000',
        address: '39 Remsen St, Brooklyn, NY 11201, USA',
        bedrooms: '3',
        bathrooms: '2',
        area: '3430 Sq Ft',
        position: {
            lat: 40.703686,
            lng: -73.982910
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Hauntingly Beautiful Estate',
        image: '2-1-thmb.png',
        type: 'For Rent',
        price: '$1,750,000',
        address: '169 Warren St, Brooklyn, NY 11201, USA',
        bedrooms: '2',
        bathrooms: '2',
        area: '4430 Sq Ft',
        position: {
            lat: 40.702189,
            lng: -73.995098
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Sophisticated Residence',
        image: '3-1-thmb.png',
        type: 'For Sale',
        price: '$1,340,000',
        address: '38-62 Water St, Brooklyn, NY 11201, USA',
        bedrooms: '2',
        bathrooms: '3',
        area: '2640 Sq Ft',
        position: {
            lat: 40.687417,
            lng: -73.982653
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'House With a Lovely Glass-Roofed Pergola',
        image: '4-1-thmb.png',
        type: 'For Sale',
        price: '$1,930,000',
        address: 'Wunsch Bldg, Brooklyn, NY 11201, USA',
        bedrooms: '3',
        bathrooms: '2',
        area: '2800 Sq Ft',
        position: {
            lat: 40.694120,
            lng: -73.974413
        },
        markerIcon: "marker-green.png"
    }, {
        title: 'Luxury Mansion',
        image: '5-1-thmb.png',
        type: 'For Rent',
        price: '$2,350,000',
        address: '95 Butler St, Brooklyn, NY 11231, USA',
        bedrooms: '2',
        bathrooms: '2',
        area: '2750 Sq Ft',
        position: {
            lat: 40.682665,
            lng: -74.000934
        },
        markerIcon: "marker-green.png"
    }];

    if (!(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch)) {
        $('body').addClass('no-touch');
    }

    $('.dropdown-select li a').click(function () {
        if (!($(this).parent().hasClass('disabled'))) {
            $(this).prev().prop("checked", true);
            $(this).parent().siblings().removeClass('active');
            $(this).parent().addClass('active');
            $(this).parent().parent().siblings('.dropdown-toggle').children('.dropdown-label').html($(this).text());
        }
    });

    $('#advanced').click(function () {
        $('.adv').toggleClass('hidden-xs');
    });

    $('.home-navHandler').click(function () {
        $('.home-nav').toggleClass('active');
        $(this).toggleClass('active');
    });

    //Enable swiping
    $(".carousel-inner").swipe({
        swipeLeft: function (event, direction, distance, duration, fingerCount) {
            $(this).parent().carousel('next');
        },
        swipeRight: function () {
            $(this).parent().carousel('prev');
        }
    });

    $('.modal-su').click(function () {
        $('#signin').modal('hide');
        $('#signup').modal('show');
    });

    $('.modal-si').click(function () {
        $('#signup').modal('hide');
        $('#signin').modal('show');
    });

    $('input, textarea').placeholder();

    setTimeout(function () {
        $('body').removeClass('notransition');

//        if ($('#home-map').length > 0) {
//            map = new google.maps.Map(document.getElementById('home-map'), options);
//            var styledMapType = new google.maps.StyledMapType(styles, {
//                name : 'Styled'
//            });
//
//            map.mapTypes.set('Styled', styledMapType);
//            map.setCenter(new google.maps.LatLng(40.6984237,-73.9890044));
//            map.setZoom(14);
//
//            addMarkers(props, map);
//        }
    }, 300);

})(jQuery);