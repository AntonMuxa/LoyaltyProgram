define(
    [
        'jquery',
        'ko',
        'uiComponent'
    ],
    function ($,ko, Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Alevel_LoyaltyProgram/js/view/checkout/summary/addpointstototals'
            },
            isCountPoints: function () {
                return true;
            },
            isDisplayed: function () {
                return true;
            },
            usePoints: function () {
                return $.ajax({
                    url: window.checkoutConfig.manage_points,
                    data: {"use_points":$('#use-points').prop("checked"), "quote_id": quote.getQuoteId()},
                    type: "POST",
                    dataType: 'json',
                }).done(function () {
                    getTotals([], false);
                }).fail(
                    function (response) {
                        errorProcessor.process(response);
                    }
                );
            }
        });
    }
);