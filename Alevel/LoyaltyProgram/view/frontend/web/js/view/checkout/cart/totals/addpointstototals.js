define(
    [
        'ko',
        'uiComponent'
    ],
    function (ko, Component) {
        "use strict";

        return Component.extend({
            defaults: {
                template: 'Alevel_LoyaltyProgram/js/view/checkout/cart/totals/addpointstototals'
            },
            isCountPoints: true
        });
    }
);