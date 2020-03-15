<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Alevel\LoyaltyProgram\Model\Total;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Model\QuoteValidator;


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

    /**
     * @var \Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface
     */
    private $repository;

    private $points;

    public function __construct(
        QuoteValidator $quoteValidator,
        CustomerSession $session,
        LoyaltyProgramRepositoryInterface $repository
    )
    {
        $this->quoteValidator = $quoteValidator;
        $this->_customerSession = $session;
        $this->repository = $repository;
    }
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }

        $balance = 0;
        if($this->_customerSession->isLoggedIn()) {
            $customerData = $this->repository->getById((int)$this->_customerSession->getId());
            $this->points = $customerData->getData('loyalty_points');
            $balance = -$this->points;
        }

        $total->setTotalAmount('loyalty', $balance);
        $total->setBaseTotalAmount('loyalty', $balance);

        $total->setLoyalty($balance);
        $total->setBaseLoyalty($balance);

        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

        return $this;
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
        return [
            'code' => 'loyalty',
            'title' => 'Loyalty Total',
            'value' => $this->points
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Loyalty Discount');
    }
}