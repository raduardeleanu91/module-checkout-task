<?php

namespace Checkout\Task\Block\Adminhtml\Order\View;

/**
 * ExternalOrderId adminhtml block class.
 *
 * @author      Radu Ardeleanu <raduardeleanu91@gmail.com>
 */
class ExternalOrderId extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * ExternalOrderId constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;

        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getCurrentOrder()
    {
        return $this->orderRepository->get($this->getRequest()->getParam('order_id'));
    }
}
