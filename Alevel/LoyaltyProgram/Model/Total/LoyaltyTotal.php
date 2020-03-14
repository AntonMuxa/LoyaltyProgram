<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Alevel\LoyaltyProgram\Model\Total;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;


class LoyaltyTotal extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $_customerSession;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Quote\Model\QuoteValidator $quoteValidator
    )
    {
        $this->quoteValidator = $quoteValidator;
        $this->_customerSession = $session;
    }
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        /*$items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }*/

        $balance = -100;
       /* if($this->customerLoggedIn() && true) {
            $balance = -100;
        }*/

        $total->setTotalAmount('loyalty', $balance);
        $total->setBaseTotalAmount('loyalty', $balance);

        $total->setLoyalty($balance);
        $total->setBaseLoyalty($balance);

        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

        return $this;
    }

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $loyaltypoints = $total->getLoyalty();
        return [
            'code' => 'loyalty',
            'title' => 'Loyalty Total',
            'value' => $loyaltypoints
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Loyalty');
    }

    public function customerLoggedIn()
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}