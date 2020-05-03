<?php

namespace Alevel\LoyaltyProgram\Observer;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Framework\Event\Observer;

class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
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
        $quote = $observer->getData('quote');
        $order = $observer->getData('order');
        $customer_id = $order->getData('customer_id');
        $sub_total = $order->getData('subtotal');
        if ($customer_id) {
            $customerData = $this->repository->getById($customer_id);
            $loyalty_parent_ref = $customerData->getData('loyalty_parent_ref');
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
    }
}
