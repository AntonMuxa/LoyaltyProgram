<?php


namespace Alevel\LoyaltyProgram\Block;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\UrlInterface;

class AddPointsInTotal extends Template
{
    private $repository;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        LoyaltyProgramRepositoryInterface $repository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlInterface $urlBuilder
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->repository = $repository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_urlBuilder = $urlBuilder;
    }

    public function isChecked()
    {
        return $this->customerSession->getUsePoints();
    }

    public function isLogged() {
        return $this->customerSession->isLoggedIn();
    }
}