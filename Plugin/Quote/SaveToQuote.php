<?php

namespace Checkout\Task\Plugin\Quote;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * SaveToQuote class.
 *
 * @author      Radu Ardeleanu <raduardeleanu91@gmail.com>
 */
class SaveToQuote
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * SaveToQuote constructor.
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     */
    public function __construct(\Magento\Quote\Model\QuoteRepository $quoteRepository) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Validates external_order_id (NotEmpty, StringLength < 40) then sets it to the quote object or throws error.
     *
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     * @throws CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Zend_Validate_Exception
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        if (!$extensionAttributes = $addressInformation->getExtensionAttributes()) {
            return;
        }

        $externalOrderId = $extensionAttributes->getExternalOrderId();

        if (!\Zend_Validate::is(trim($externalOrderId), 'StringLength', ['max' => 40])) {
            throw new CouldNotSaveException(__('External Order Id should have a length of max 40 characters.'));
        } elseif (!\Zend_Validate::is(trim($externalOrderId), 'NotEmpty')) {
            throw new CouldNotSaveException(__('External Order Id should not be empty.'));
        } else {
            $quote = $this->quoteRepository->getActive($cartId);
            $quote->setExternalOrderId($externalOrderId);
        }
    }
}
