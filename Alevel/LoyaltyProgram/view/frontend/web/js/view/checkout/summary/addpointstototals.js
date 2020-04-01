define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/get-totals',
        'Magento_Customer/js/model/customer'
    ],
    function ($,ko, Component, quote, getTotals, customer) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Alevel_LoyaltyProgram/js/view/checkout/summary/addpointstototals'
            },
            isCountPoints: window.checkoutConfig.getUsePoints,
            isDisplayed: function () {
                return customer.isLoggedIn();
            },
            usePoints: function () {
                return $.ajax({
                    url: window.checkoutConfig.managePointsPath,
                    data: {"use_points":$('#use-points').prop("checked"), "quote_id": quote.getQuoteId()},
                    type: "POST",
                    dataType: 'json',
                }).done(function () {
                    getTotals([], false);
                }).fail(function (response) {
                    errorProcessor.process(response);
                });
            }
        });
    }
);