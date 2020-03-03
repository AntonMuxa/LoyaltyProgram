<?php


namespace Alevel\LoyaltyProgram\Block;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;


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
        LoyaltyProgramRepositoryInterface $repository,
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
        $sessionCustomerId = $this->customerSession->getCustomer()->getId();
        $customerData = $this->repository->getById((int)$sessionCustomerId);
        $customerInfo = $customerData->getData();
        return $customerInfo;
    }

    public function getCustomers()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        //$searchCriteria->getSelect()->__toString();
        $customers = $this->repository->getList($searchCriteria)->getItems();

        return $customers;
    }

}