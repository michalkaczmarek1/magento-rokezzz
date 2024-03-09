define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor'
], function (
    $,
    wrapper,
    quote,
    urlBuilder,
    urlFormatter,
    errorProcessor
) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            let quoteId = quote.getQuoteId();
            let url = urlBuilder.createUrl('/order/type/save', {});
            let typeOrderId = $('div[name="shippingAddress.type_order"] .admin__control-radio:checked').val();
            let typeOrderName = $('div[name="shippingAddress.type_order"] input[value=' + typeOrderId + ']').siblings().text();

            if (typeOrderId) {
                let payload = {
                    'cartId': quoteId,
                    'typeOrderId': typeOrderId,
                    'name': typeOrderName
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
                        errorProcessor.process(response);
                    }
                );
            }

            return originalAction();
        });
    };
});
