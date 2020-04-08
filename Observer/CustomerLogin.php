<?php

namespace Alevel\LoyaltyProgram\Observer;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Alevel\LoyaltyProgram\Cookie\CustomCookie;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;

class CustomerLogin implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomCookie
     */
    private $customCookie;
    /**
     * @inheritDoc
     */

    public function __construct(
        LoyaltyProgramRepositoryInterface $repository,
        CustomerSession $customerSession,
        CustomCookie $customCookie
    ) {
        $this->repository = $repository;
        $this->customerSession = $customerSession;
        $this->customCookie = $customCookie;
    }

    public function execute(Observer $observer)
    {
        $ref_link = $this->customCookie->getCustomCookie('ref-link');
        if (!empty($ref_link)) {
            $customerData = $this->repository->getByEmail($ref_link);
            $customerId = $customerData->getData('entity_id');
            if ($customerId > 0) {
                $loyaltyParentRef = $customerData->getData('loyalty_parent_ref');
                if ($customerId > 0 && $loyaltyParentRef == 0) {
                    $customerData->setData('loyalty_parent_ref', $customerId);
                    $this->repository->save($customerData);
                }
            }
        }
    }
}
