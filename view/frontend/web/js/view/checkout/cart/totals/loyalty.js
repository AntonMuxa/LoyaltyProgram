define(
    [
        'Alevel_LoyaltyProgram/js/view/checkout/summary/loyalty',
        'Magento_Customer/js/model/customer',
    ],
    function (Component, customer) {
        'use strict';

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return (this.isFullMode() && customer.isLoggedIn());
            }
        });
    }
);