define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor',
    'Magento_CheckoutAgreements/js/model/agreements-assigner'
], function (
    $,
    wrapper,
    quote,
    customer,
    urlBuilder,
    urlFormatter,
    errorProcessor,
    agreementsAssigner
) {
    'use strict';

    return function (placeOrderAction) {

        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            agreementsAssigner(paymentData);
            let isCustomer = customer.isLoggedIn();
            let quoteId = quote.getQuoteId();
            let url = urlBuilder.createUrl('/order/type/save', {});
            let typeOrderId = $('div[name="shippingAddress.type_order"] .admin__control-radio:checked').val();
            let typeOrderName = $('div[name="shippingAddress.type_order"] input[value=' + typeOrderId + ']').siblings().text();

            if (typeOrderId) {
                let payload = {
                    'cartId': quoteId,
                    'typeOrder': typeOrderId,
                    'typeOrderId': typeOrderId,
                    'name': typeOrderName,
                    'isCustomer': isCustomer
                };

                if (!payload.typeOrderId) {
                    return true;
                }

                let result = true;
                url = urlFormatter.build(url);
                $.ajax({
                    url: url,
                    data: JSON.stringify(payload),
                    dataType: 'text',
                    type: 'POST',
                    contentType: "application/json"
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response, messageContainer);
                    }
                );
            }

            return originalAction(paymentData, messageContainer);
        });
    };
});
