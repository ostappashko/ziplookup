define(
    ['jquery'], function($) {
        "use strict";

        return {
            /**
             * GraphQl ready json string should be passed in here.
             * This method does not perform additional validation
             * @param {String} query
             */
            query: function(query) {
                return $.ajax({
                    url: "/graphql",
                    type: "GET",
                    contentType: "application/json",
                    dataType:'json',
                    data: {query: query}
                });
            }
        }
});
