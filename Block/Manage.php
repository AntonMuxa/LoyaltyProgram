<?php

namespace Alevel\LoyaltyProgram\Block;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Alevel\LoyaltyProgram\Cookie\CustomCookie;

class Manage extends Template
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CustomCookie
     */
    private $customCookie;

    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        LoyaltyProgramRepositoryInterface $repository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlInterface $urlBuilder,
        CustomCookie $customCookie
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->repository = $repository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->urlBuilder = $urlBuilder;
        $this->customCookie = $customCookie;
    }

    public function getPoints()
    {
        return $this->repository->getPoints($this->getSessionCustomerId());
    }

    public function getSessionCustomerId()
    {
        return $this->customerSession->getId();
    }

    public function getCustomerById()
    {
        return $this->repository->getById((int)$this->getSessionCustomerId());
    }

    public function getRefferalLink()
    {
        $customerData = $this->getCustomerById();
        return $this->urlBuilder->getUrl('/', ['_query' => ['ref-link' => $customerData['email']]]);
    }

}
