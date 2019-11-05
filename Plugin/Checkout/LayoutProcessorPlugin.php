<?php

namespace Checkout\Task\Plugin\Checkout;

/**
 * LayoutProcessorPlugin class.
 *
 * @author      Radu Ardeleanu <raduardeleanu91@gmail.com>
 */
class LayoutProcessorPlugin
{
    /**
     * Adds the External Order Id input field on the shipping checkout step.
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $externalOrderIdCode = 'external_order_id';

        $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $externalOrderIdCode,
            'label' => 'External Order Id',
            'provider' => 'checkoutProvider',
            'sortOrder' => 55,
            'validation' => [
                'required-entry' => true,
                'max_text_length' => 40,
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$externalOrderIdCode] = $customField;

        return $jsLayout;
    }
}
