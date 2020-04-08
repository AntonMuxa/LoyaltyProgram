<?php


namespace Alevel\LoyaltyProgram\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class AddPointsInTotal extends Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        Context $context,
        CustomerSession $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }

    public function isChecked()
    {
        return $this->customerSession->getUsePoints();
    }

    public function isLogged() {
        return $this->customerSession->isLoggedIn();
    }
}