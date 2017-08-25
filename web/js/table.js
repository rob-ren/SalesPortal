(function($) {
    "use strict";

    $('#inboxTable').tablesorter({
        headers: {
            0: {
                sorter: true
            },
            1: {
                sorter: true
            },
            2: {
                sorter: true
            },
            3: {
                sorter: true
            },
            4: {
                sorter: false
            }
        }
    });

})(jQuery);