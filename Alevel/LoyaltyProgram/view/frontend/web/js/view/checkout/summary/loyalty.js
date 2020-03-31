define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals',
        'Magento_Customer/js/model/customer'
    ],
    function (
        Component,
        quote,
        priceUtils,
        totals,
        customer
        ) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Alevel_LoyaltyProgram/checkout/summary/loyalty'
            },
            totals: quote.getTotals(),
            isDisplayed: function() {
                return (this.isFullMode() && customer.isLoggedIn());
            },
            getValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = totals.getSegment('loyalty').value;
                }
                return this.getFormattedPrice(price);
            },
            getBaseValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = this.totals()['base_loyalty'];
                }
                return priceUtils.formatPrice(price, quote.getBasePriceFormat());
            }
        });
    }
);