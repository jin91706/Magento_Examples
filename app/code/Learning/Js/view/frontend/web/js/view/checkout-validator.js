define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Learning_Js/js/model/checkout-validator'
    ],
    function (Component, additionalValidators, yourValidator) {
        'use strict';
        additionalValidators.registerValidator(yourValidator);
        return Component.extend({});
    }
);
