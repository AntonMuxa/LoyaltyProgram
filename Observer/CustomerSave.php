<?php

namespace Alevel\LoyaltyProgram\Observer;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Framework\Event\Observer;

class CustomerSave implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;

    public function __construct(
        LoyaltyProgramRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getData('customer');
        $request = $observer->getData('request');
        $loyalty_program = $request->getParam('loyalty_program');

        $customerData = $this->repository->getById($customer->getId());
        $loyalty_points = is_numeric($loyalty_program['loyalty_points']) ? $loyalty_program['loyalty_points'] : 0;
        $loyalty_parent_ref = is_numeric($loyalty_program['loyalty_parent_ref']) ? $loyalty_program['loyalty_parent_ref'] : 0;
        $customerData->setData('loyalty_points', $loyalty_points);
        $customerData->setData('loyalty_parent_ref', $loyalty_parent_ref);
        $this->repository->save($customerData);

    }
}
