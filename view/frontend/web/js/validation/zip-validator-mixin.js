define([
    'jquery',
    'jquery/validate'
    ], function ($) {
        "use strict";
        return function (validator) {
            // Realistically this is a validation method that just gets updated by the view model with updated info
            validator.addRule(
                'validate-zip-code',
                function (value, params, additionalParams) {
                    if(params.valid === false) {
                        return false;
                    } else {
                        return true;
                    }
                },
                $.mage.__("This Zip Code is not valid!")
            );
            return validator;
        };
    });
