<?php

namespace Checkout\Task\Observer;

/**
 * SaveToOrder observer class.
 *
 * @author      Radu Ardeleanu <raduardeleanu91@gmail.com>
 */
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Triggered on sales_model_service_quote_submit_before
     * Transfers external_order_id from the quote to the order object.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $order->setData('external_order_id', $quote->getExternalOrderId());
    }
}
