<?php

namespace Alevel\LoyaltyProgram\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Manage extends Template
{
    private $repository;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        CustomerRepositoryInterface $repository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->repository = $repository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getPoints()
    {
        $points = 101;
        return $points;
    }

    public function getSessionCustomerId()
    {
        return $this->customerSession->getId();
    }

    public function getCustomerById()
    {
        $sessionCustomerId = $this->getSessionCustomerId();
        //$customerInfa = $this->customerSession->getCustomerData();
        $customerData = $this->repository->getById((int)$sessionCustomerId);
        //$customerInfo = $customerData->getData();
        $getCustomAttributes = $customerData->getCustomAttributes();
        $getCustomAttributes = $getCustomAttributes;
        $customerData = $customerData;

        return $customerData;
    }
}
