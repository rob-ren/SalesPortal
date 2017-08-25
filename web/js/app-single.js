(function ($) {
    "use strict";

    // Contact Form

    $("#btn-submit").click(function () {
        //get input field values
        var user_name = $('input[name=full_name]').val();
        var user_email = $('input[name=email_address]').val();
        var user_message = $('textarea[name=apply_message]').val();
        var user_subject = $('input[name=email_subject]').val();
        var user_receiver = $('input[name=receiver]').val();
        var user_project = $('input[name=project_title]').val();
        //simple validation at client's end
        var proceed = true;
        if (user_name == "") {
            proceed = false;
        }
        if (user_email == "") {
            proceed = false;
        }
        if (user_message == "") {
            proceed = false;
        }

        var post_data, output;

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {
                'full_name': user_name,
                'email_address': user_email,
                'apply_message': user_message,
                'email_subject': user_subject,
                'receiver': user_receiver,
                'project_title': user_project
            };
            //Ajax post data to server
            $.ajax({
                type: "POST",
                url: "/apply_msg",
                data: post_data,
                success: function (response) {
                    output = '<div class="success"><p style="text-align:left; color:orangered;">' + response.msg + '</p></div>';
                    //reset values in all input fields
                    $('#full_name').val('');
                    $('#email_address').val('');
                    $('#apply_message').val('');
                    $("#result").hide().html(output).slideDown();
                },
                error: function (response) {
                    output = '<div class="error"><p style="text-align:left; color:#fff;">' + response.msg + '</p></div>';
                    $("#result").hide().html(output).slideDown();
                }

            });

        }
    });

    // Custom options for map
    var options = {
        zoom: 14,
        mapTypeId: 'Styled',
        disableDefaultUI: true,
        mapTypeControlOptions: {
            mapTypeIds: ['Styled']
        }
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

    var newMarker = null;
    var markers = [];

    // json for properties markers on map
    var props = [];
    var project_price;
    if (project['min_price'] <= "1.00") {
        project_price = 'Consult Us for Price';
    }
    else {
        project_price = '$ ' + Math.round(project['min_price']).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '+';
    }
    var address_url = project['address'].replace(/ /g, "-");
    address_url = address_url.replace(/,/g, "");

    props.push(
        {
            id: project['id'],
            title: project['title'],
            image: project['front_image'],
            type: "On Sale",
            price: project_price,
            address: project['address'],
            address_url: address_url,
            position: {
                lat: project['latitude'],
                lng: project['longitude']
            },
            markerIcon: "marker-red.png"
        });

    // custom infowindow object
    var infobox = new InfoBox({
        disableAutoPan: false,
        maxWidth: 202,
        pixelOffset: new google.maps.Size(-101, -285),
        zIndex: null,
        boxStyle: {
            background: "url('../images/infobox-bg.png') no-repeat",
            opacity: 1,
            width: "202px",
            height: "245px"
        },
        closeBoxMargin: "28px 26px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        pane: "floatPane",
        enableEventPropagation: false
    });

    // function that adds the markers on map
    var addMarkers = function (props, map) {
        $.each(props, function (i, prop) {
            var latlng = new google.maps.LatLng(prop.position.lat, prop.position.lng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: new google.maps.MarkerImage(
                    '../images/' + prop.markerIcon,
                    null,
                    null,
                    null,
                    new google.maps.Size(36, 36)
                ),
                draggable: false,
                animation: google.maps.Animation.DROP,
            });
            var infoboxContent = '<div class="infoW">' +
                '<div class="propImg">' +
                '<img src="../' + prop.image + '">' +
                '<div class="propBg">' +
                '<div class="propPrice">' + prop.price + '</div>' +
                '<div class="propType">' + prop.type + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="paWrapper">' +
                '<div class="propTitle">' + prop.title + '</div>' +
                '<div class="propAddress">' + prop.address + '</div>' +
                '</div>' +
                '<div class="clearfix"></div>' +
                '<div class="infoButtons">' +
                '<a class="btn btn-sm btn-round btn-gray btn-o closeInfo">Close</a>' +
                '<a href="' + prop.id + '" class="btn btn-sm btn-round btn-green viewInfo">View</a>' +
                '</div>' +
                '</div>';

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infobox.setContent(infoboxContent);
                    infobox.open(map, marker);
                }
            })(marker, i));

            $(document).on('click', '.closeInfo', function () {
                infobox.open(null, null);
            });

            markers.push(marker);
        });
    }

    var map;
    var windowHeight;
    var windowWidth;
    var contentHeight;
    var contentWidth;
    var isDevice = true;

    // calculations for elements that changes size on window resize
    var windowResizeHandler = function () {
        windowHeight = window.innerHeight;
        windowWidth = $(window).width();
        contentHeight = windowHeight - $('#header').height();
        contentWidth = $('#content').width();

        $('#leftSide').height(contentHeight);
        $('.closeLeftSide').height(contentHeight);
        $('#wrapper').height(contentHeight);
        $('#mapView').height(contentHeight);
        $('#content').height(contentHeight);
        setTimeout(function () {
            $('.commentsFormWrapper').width(contentWidth);
        }, 300);

        if (map) {
            google.maps.event.trigger(map, 'resize');
        }

        // Add custom scrollbar for left side navigation
        if (windowWidth > 767) {
            $('.bigNav').slimScroll({
                height: contentHeight - $('.leftUserWraper').height()
            });
        } else {
            $('.bigNav').slimScroll({
                height: contentHeight
            });
        }
        if ($('.bigNav').parent('.slimScrollDiv').size() > 0) {
            $('.bigNav').parent().replaceWith($('.bigNav'));
            if (windowWidth > 767) {
                $('.bigNav').slimScroll({
                    height: contentHeight - $('.leftUserWraper').height()
                });
            } else {
                $('.bigNav').slimScroll({
                    height: contentHeight
                });
            }
        }

        // reposition of prices and area reange sliders tooltip
        var priceSliderRangeLeft = parseInt($('.priceSlider .ui-slider-range').css('left'));
        var priceSliderRangeWidth = $('.priceSlider .ui-slider-range').width();
        var priceSliderLeft = priceSliderRangeLeft + ( priceSliderRangeWidth / 2 ) - ( $('.priceSlider .sliderTooltip').width() / 2 );
        $('.priceSlider .sliderTooltip').css('left', priceSliderLeft);

        var areaSliderRangeLeft = parseInt($('.areaSlider .ui-slider-range').css('left'));
        var areaSliderRangeWidth = $('.areaSlider .ui-slider-range').width();
        var areaSliderLeft = areaSliderRangeLeft + ( areaSliderRangeWidth / 2 ) - ( $('.areaSlider .sliderTooltip').width() / 2 );
        $('.areaSlider .sliderTooltip').css('left', areaSliderLeft);
    }

    var repositionTooltip = function (e, ui) {
        var div = $(ui.handle).data("bs.tooltip").$tip[0];
        var pos = $.extend({}, $(ui.handle).offset(), {
            width: $(ui.handle).get(0).offsetWidth,
            height: $(ui.handle).get(0).offsetHeight
        });
        var actualWidth = div.offsetWidth;

        var tp = {left: pos.left + pos.width / 2 - actualWidth / 2}
        $(div).offset(tp);

        $(div).find(".tooltip-inner").text(ui.value);
    }

    windowResizeHandler();
    $(window).resize(function () {
        windowResizeHandler();
    });

    setTimeout(function () {
        $('body').removeClass('notransition');

        map = new google.maps.Map(document.getElementById('mapView'), options);
        var styledMapType = new google.maps.StyledMapType(styles, {
            name: 'Styled'
        });

        map.mapTypes.set('Styled', styledMapType);
        map.setCenter(new google.maps.LatLng(props[0].position.lat, props[0].position.lng));
        map.setZoom(14);

        if ($('#address').length > 0) {
            newMarker = new google.maps.Marker({
                position: new google.maps.LatLng(props[0].position.lat, props[0].position.lng),
                map: map,
                icon: new google.maps.MarkerImage(
                    'images/marker-new.png',
                    null,
                    null,
                    // new google.maps.Point(0,0),
                    null,
                    new google.maps.Size(36, 36)
                ),
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

            google.maps.event.addListener(newMarker, "mouseup", function (event) {
                var latitude = this.position.lat();
                var longitude = this.position.lng();
                $('#latitude').text(this.position.lat());
                $('#longitude').text(this.position.lng());
                $('#latitude_input').val(this.position.lat());
                $('#longitude_input').val(this.position.lng());
            });
        }

        addMarkers(props, map);
    }, 300);

    if (!(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch)) {
        $('body').addClass('no-touch');
        isDevice = false;
    }

    // Header search icon transition
    $('.search input').focus(function () {
        $('.searchIcon').addClass('active');
    });
    $('.search input').blur(function () {
        $('.searchIcon').removeClass('active');
    });

    // Notifications list items pulsate animation
    $('.notifyList a').hover(
        function () {
            $(this).children('.pulse').addClass('pulsate');
        },
        function () {
            $(this).children('.pulse').removeClass('pulsate');
        }
    );

    // Exapnd left side navigation
    var navExpanded = false;
    $('.navHandler, .closeLeftSide').click(function () {
        if (!navExpanded) {
            $('.logo').addClass('expanded');
            $('#leftSide').addClass('expanded');
            if (windowWidth < 768) {
                $('.closeLeftSide').show();
            }
            $('.hasSub').addClass('hasSubActive');
            $('.leftNav').addClass('bigNav');
            if (windowWidth > 767) {
                $('.full').addClass('m-full');
            }
            windowResizeHandler();
            navExpanded = true;
        } else {
            $('.logo').removeClass('expanded');
            $('#leftSide').removeClass('expanded');
            $('.closeLeftSide').hide();
            $('.hasSub').removeClass('hasSubActive');
            $('.bigNav').slimScroll({destroy: true});
            $('.leftNav').removeClass('bigNav');
            $('.leftNav').css('overflow', 'visible');
            $('.full').removeClass('m-full');
            navExpanded = false;
        }
    });

    // functionality for map manipulation icon on mobile devices
    $('.mapHandler').click(function () {
        if ($('#mapView').hasClass('mob-min') ||
            $('#mapView').hasClass('mob-max') ||
            $('#content').hasClass('mob-min') ||
            $('#content').hasClass('mob-max')) {
            $('#mapView').toggleClass('mob-max');
            $('#content').toggleClass('mob-min');
        } else {
            $('#mapView').toggleClass('min');
            $('#content').toggleClass('max');
        }

        setTimeout(function () {
            var priceSliderRangeLeft = parseInt($('.priceSlider .ui-slider-range').css('left'));
            var priceSliderRangeWidth = $('.priceSlider .ui-slider-range').width();
            var priceSliderLeft = priceSliderRangeLeft + ( priceSliderRangeWidth / 2 ) - ( $('.priceSlider .sliderTooltip').width() / 2 );
            $('.priceSlider .sliderTooltip').css('left', priceSliderLeft);

            var areaSliderRangeLeft = parseInt($('.areaSlider .ui-slider-range').css('left'));
            var areaSliderRangeWidth = $('.areaSlider .ui-slider-range').width();
            var areaSliderLeft = areaSliderRangeLeft + ( areaSliderRangeWidth / 2 ) - ( $('.areaSlider .sliderTooltip').width() / 2 );
            $('.areaSlider .sliderTooltip').css('left', areaSliderLeft);

            if (map) {
                google.maps.event.trigger(map, 'resize');
            }

            $('.commentsFormWrapper').width($('#content').width());
        }, 300);

    });

    // Expand left side sub navigation menus
    $(document).on("click", '.hasSubActive', function () {
        $(this).toggleClass('active');
        $(this).children('ul').toggleClass('bigList');
        $(this).children('a').children('.arrowRight').toggleClass('fa-angle-down');
    });

    if (isDevice) {
        $('.hasSub').click(function () {
            $('.leftNav ul li').not(this).removeClass('onTap');
            $(this).toggleClass('onTap');
        });
    }

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
        if (!($(this).parent().hasClass('disabled'))) {
            document.getElementById('hidden_state').value = document.getElementById("state_query").innerHTML;
        }
    });
    $('#type_dropdown').click(function () {
        if (!($(this).parent().hasClass('disabled'))) {
            document.getElementById('hidden_type').value = document.getElementById("type_query").innerHTML;
        }
    });
    $('.keyword_input').keyup(function () {
        var n1 = document.getElementById('keyword_input');
        var n2 = document.getElementById('hidden_keyword');
        n2.value = n1.value;
    });

    var min_price, max_price;
    if (document.getElementById('hidden_min_price') != null) {
        min_price = document.getElementById('hidden_min_price').value;
        if (!min_price) {
            min_price = 0;
        }
    }
    if (document.getElementById('hidden_max_price') != null) {
        max_price = document.getElementById('hidden_max_price').value;
        if (!max_price) {
            max_price = 5000000;
        }
    }
    $('.priceSlider').slider({
        range: true,
        min: 0,
        max: 5000000,
        values: [min_price, max_price],
        step: 10000,
        slide: function (event, ui) {
            $('.priceSlider .sliderTooltip .stLabel').html(
                '$' + ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") +
                ' <span class="fa fa-arrows-h"></span> ' +
                '$' + ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
            );
            var priceSliderRangeLeft = parseInt($('.priceSlider .ui-slider-range').css('left'));
            var priceSliderRangeWidth = $('.priceSlider .ui-slider-range').width();
            var priceSliderLeft = priceSliderRangeLeft + ( priceSliderRangeWidth / 2 ) - ( $('.priceSlider .sliderTooltip').width() / 2 );
            $('.priceSlider .sliderTooltip').css('left', priceSliderLeft);
            var max_val = ui.values[1];
            var min_val = ui.values[0];
            $(".form_max_price").val(max_val);
            $(".form_min_price").val(min_val);
        }
    });
    if (min_price >= 0 && max_price <= 5000000) {
        $('.priceSlider .sliderTooltip .stLabel').html(
            '$' + min_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") +
            ' <span class="fa fa-arrows-h"></span> ' +
            '$' + max_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
        );
    }
    var priceSliderRangeLeft = parseInt($('.priceSlider .ui-slider-range').css('left'));
    var priceSliderRangeWidth = $('.priceSlider .ui-slider-range').width();
    var priceSliderLeft = priceSliderRangeLeft + ( priceSliderRangeWidth / 2 ) - ( $('.priceSlider .sliderTooltip').width() / 2 );
    $('.priceSlider .sliderTooltip').css('left', priceSliderLeft);

    $('.areaSlider').slider({
        range: true,
        min: 0,
        max: 20000,
        values: [5000, 10000],
        step: 10,
        slide: function (event, ui) {
            $('.areaSlider .sliderTooltip .stLabel').html(
                ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' Sq Ft' +
                ' <span class="fa fa-arrows-h"></span> ' +
                ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' Sq Ft'
            );
            var areaSliderRangeLeft = parseInt($('.areaSlider .ui-slider-range').css('left'));
            var areaSliderRangeWidth = $('.areaSlider .ui-slider-range').width();
            var areaSliderLeft = areaSliderRangeLeft + ( areaSliderRangeWidth / 2 ) - ( $('.areaSlider .sliderTooltip').width() / 2 );
            $('.areaSlider .sliderTooltip').css('left', areaSliderLeft);
        }
    });
    $('.areaSlider .sliderTooltip .stLabel').html(
        $('.areaSlider').slider('values', 0).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' Sq Ft' +
        ' <span class="fa fa-arrows-h"></span> ' +
        $('.areaSlider').slider('values', 1).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' Sq Ft'
    );
    var areaSliderRangeLeft = parseInt($('.areaSlider .ui-slider-range').css('left'));
    var areaSliderRangeWidth = $('.areaSlider .ui-slider-range').width();
    var areaSliderLeft = areaSliderRangeLeft + ( areaSliderRangeWidth / 2 ) - ( $('.areaSlider .sliderTooltip').width() / 2 );
    $('.areaSlider .sliderTooltip').css('left', areaSliderLeft);

    $('.volume .btn-round-right').click(function () {
        var currentVal = parseInt($(this).siblings('input').val());
        if (currentVal < 10) {
            $(this).siblings('input').val(currentVal + 1);
        }
    });
    $('.volume .btn-round-left').click(function () {
        var currentVal = parseInt($(this).siblings('input').val());
        if (currentVal > 1) {
            $(this).siblings('input').val(currentVal - 1);
        }
    });

    $('.handleFilter').click(function () {
        $('.filterForm').slideToggle(200);
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

    $(".carousel-inner .card").click(function () {
        window.open($(this).attr('data-linkto'), '_self');
    });

    $('#content').scroll(function () {
        if ($('.comments').length > 0) {
            var visible = $('.comments').visible(true);
            if (visible) {
                $('.commentsFormWrapper').addClass('active');
            } else {
                $('.commentsFormWrapper').removeClass('active');
            }
        }
    });

    $('.btn').click(function () {
        if ($(this).is('[data-toggle-class]')) {
            $(this).toggleClass('active ' + $(this).attr('data-toggle-class'));
        }
    });

    $('.tabsWidget .tab-scroll').slimScroll({
        height: '235px',
        size: '5px',
        position: 'right',
        color: '#939393',
        alwaysVisible: false,
        distance: '5px',
        railVisible: false,
        railColor: '#222',
        railOpacity: 0.3,
        wheelStep: 10,
        allowPageScroll: true,
        disableFadeOut: false
    });

    $('.progress-bar[data-toggle="tooltip"]').tooltip();
    $('.tooltipsContainer .btn').tooltip();

    $("#slider1").slider({
        range: "min",
        value: 50,
        min: 1,
        max: 100,
        slide: repositionTooltip,
        stop: repositionTooltip
    });
    $("#slider1 .ui-slider-handle:first").tooltip({
        title: $("#slider1").slider("value"),
        trigger: "manual"
    }).tooltip("show");

    $("#slider2").slider({
        range: "max",
        value: 70,
        min: 1,
        max: 100,
        slide: repositionTooltip,
        stop: repositionTooltip
    });
    $("#slider2 .ui-slider-handle:first").tooltip({
        title: $("#slider2").slider("value"),
        trigger: "manual"
    }).tooltip("show");

    $("#slider3").slider({
        range: true,
        min: 0,
        max: 500,
        values: [190, 350],
        slide: repositionTooltip,
        stop: repositionTooltip
    });
    $("#slider3 .ui-slider-handle:first").tooltip({
        title: $("#slider3").slider("values", 0),
        trigger: "manual"
    }).tooltip("show");
    $("#slider3 .ui-slider-handle:last").tooltip({
        title: $("#slider3").slider("values", 1),
        trigger: "manual"
    }).tooltip("show");

    $('#autocomplete').autocomplete({
        source: ["ActionScript", "AppleScript", "Asp", "BASIC", "C", "C++", "Clojure", "COBOL", "ColdFusion", "Erlang", "Fortran", "Groovy", "Haskell", "Java", "JavaScript", "Lisp", "Perl", "PHP", "Python", "Ruby", "Scala", "Scheme"],
        focus: function (event, ui) {
            var label = ui.item.label;
            var value = ui.item.value;
            var me = $(this);
            setTimeout(function () {
                me.val(value);
            }, 1);
        }
    });

    $('#tags').tagsInput({
        'height': 'auto',
        'width': '100%',
        'defaultText': 'Add a tag',
    });

    $('#datepicker').datepicker();

    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    // functionality for autocomplete address field
    if ($('#address').length > 0) {
        var address = document.getElementById('address');
        var addressAuto = new google.maps.places.Autocomplete(address);

        google.maps.event.addListener(addressAuto, 'place_changed', function () {
            var place = addressAuto.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }
            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }

            if (!place.geometry) {
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
            }
            newMarker.setPosition(place.geometry.location);
            newMarker.setVisible(true);

            $('#latitude').text(newMarker.getPosition().lat());
            $('#longitude').text(newMarker.getPosition().lng());
            $('#latitude_input').val(newMarker.getPosition().lat());
            $('#longitude_input').val(newMarker.getPosition().lng());

            return false;
        });
    }

    $('input, textarea').placeholder();

})(jQuery);