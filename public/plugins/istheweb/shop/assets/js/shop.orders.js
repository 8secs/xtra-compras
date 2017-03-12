+function ($) { "use strict";

    var OrdersUpdate = function() {

        this.viewPdfUpdate = function(data) {

            if(typeof data.url !== 'undefined'){
                console.log(data.url);
                var folder = "";
                var protocol = "";
                if(window.location.hostname == 'localhost') {
                    folder = '/quicksteam/';
                    protocol = 'http://';
                }
                else {
                    folder = '/';
                    protocol = 'https://';
                }
                window.open(protocol+window.location.hostname+folder+data.url, '_blank');
            }else{
                console.log("no existe");
            }
        }
    };

    $.ordersUpdate = new OrdersUpdate;

}(window.jQuery);