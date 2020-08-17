define([
    'underscore',
    'Magento_Ui/js/form/element/post-code',
    "uiRegistry",
    "Pashko_ZipLookup/js/model/graphql"
], function (_, Component, registry, graphql) {
    'use strict';

    return Component.extend({
        defaults: {
            imports: {
                onChange: '${ $.parentName }.postcode:value',
            },
            modules: {
                address: '${ $.parentName }',
            }
        },

        /**
         * @param {String} value
         */
        onChange: function (value) {
            this.zipLookup(value);
        },

        /**
         * @param {String} value
         */
        zipLookup: function (value) {
            var $this = this;
            var error;
            var addressType = this.address().parentName.split(".").pop();
            var request = `{ziplookup(zip:"${value}"){zip,country_id,region_id,region,city}}`;
            graphql.query(request).then(function (data){
                if(data.errors) {
                    error = data.errors.shift();
                    if(error.extensions.category == "graphql-no-such-entity") {
                        $this.setValidation("validate-zip-code", {valid: false } );
                    }
                } else if(data.data) {
                    $this.address().source.set(addressType + ".country_id", data.data.ziplookup.country_id);
                    $this.address().source.set(addressType + ".region", data.data.ziplookup.region);
                    $this.address().source.set(addressType + ".region_id", data.data.ziplookup.region_id);
                    $this.address().source.set(addressType + ".city", data.data.ziplookup.city);
                    $this.setValidation("validate-zip-code", {valid: true} );
                }
            });
        }
    });
});
