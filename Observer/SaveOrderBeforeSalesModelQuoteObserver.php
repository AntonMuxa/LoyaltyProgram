<?php

namespace Alevel\LoyaltyProgram\Observer;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Magento\Quote\Model\Quote;

class SaveOrderBeforeSalesModelQuoteObserver implements ObserverInterface
{
    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;

    private $groupRepository;

    public function __construct(
        LoyaltyProgramRepositoryInterface $repository,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    ) {
        $this->repository = $repository;
        $this->groupRepository = $groupRepository;
    }

    public function execute(Observer $observer)
    {
        /* @var Order $order */
        $order = $observer->getEvent()->getData('order');
        /* @var Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        foreach (['loyalty', 'base_loyalty'] as $code) {
            if ($quote->hasData($code)) {
                $order->setData($code, $quote->getData($code));
            }
        }

        $customer_id = $order->getData('customer_id');
        $sub_total = $order->getData('subtotal');

        if ($customer_id) {
            $customerData = $this->repository->getById($customer_id);
            $loyalty_parent_ref = $customerData->getData('loyalty_parent_ref');
            $loyalty_points = $customerData->getData('loyalty_points');
            $quote_points = $quote->getData('loyalty');
            if(($loyalty_points - $quote_points) < 0) {
                $counted_points = 0;
            } else {
                $counted_points = $loyalty_points - $quote_points;
            }

            $customerData->setData('loyalty_points', $counted_points);
            $this->repository->save($customerData);
            if ($loyalty_parent_ref) {
                $customerRefData = $this->repository->getById($loyalty_parent_ref);
                $customer_group_id = $customerRefData->getData('group_id');
                if ($customer_group_id) {
                    $groupData = $this->groupRepository->getById($customer_group_id);
                    $loyalty_percent = $groupData->getExtensionAttributes()->getLoyaltyPercent();
                    $loyalty_points = ceil($sub_total * ($loyalty_percent / 100));
                    $old_loyalty_points = $customerRefData->getData('loyalty_points');
                    $customerRefData->setData('loyalty_points', $old_loyalty_points + $loyalty_points);
                    $this->repository->save($customerRefData);
                }
            }
        }

        return $this;
    }
}
