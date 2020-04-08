<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Alevel\LoyaltyProgram\Model\Total;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Loyalty extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */

    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        LoyaltyProgramRepositoryInterface $repository,
        CustomerSession $customerSession
    ) {
        $this->priceCurrency = $priceCurrency;
        $this->repository = $repository;
        $this->customerSession = $customerSession;
        $this->setCode('loyalty');
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
        if ($quote->getCustomerId() == 0) {
            return $this;
        }

        $points = $this->repository->getPoints($quote->getCustomerId());
        $balance = $this->convertToQuoteCurrency($quote, $points);
        $grand_total = (float)$quote->getData('grand_total');

        $total->setLoyalty($balance);
        $total->setBaseLoyalty($balance);

        if ($this->customerSession->getUsePoints()) {
            if ($grand_total > 0 && $grand_total <= $balance) {
                $balance = $grand_total;
            } elseif ($grand_total == 0) {
                $balance = 0;
            }

            $total->setTotalAmount($this->getCode(), -$balance);
            $total->setBaseTotalAmount($this->getCode(), -$balance);
        }

        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $points = $this->repository->getPoints($quote->getCustomerId());
        return [
            'code' =>  $this->getCode(),
            'title' => $this->getLabel(),
            'value' => $points
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Loyalty Points');
    }

    /**
     * @param  \Magento\Quote\Api\Data\CartInterface $quote
     * @param  float $baseAmount
     *
     * @return float
     */
    public function convertToQuoteCurrency(
        \Magento\Quote\Api\Data\CartInterface $quote,
        $baseAmount
    ) {
        return $this->priceCurrency->convertAndRound(
            $baseAmount,
            $quote->getStore(),
            $quote->getCurrency()
        );
    }
}
