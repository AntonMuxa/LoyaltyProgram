<?php

namespace Alevel\LoyaltyProgram\Observer;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Alevel\LoyaltyProgram\Cookie\CustomCookie;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\RequestInterface;

class LayoutRenderBeforeCmsIndexIndex implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CustomCookie
     */
    private $customCookie;

    public function __construct(
        RequestInterface $request,
        LoyaltyProgramRepositoryInterface $repository,
        CustomCookie $customCookie
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->customCookie = $customCookie;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $ref_link = $this->request->getParam('ref-link');
        if (!empty($ref_link)) {
            $customerData = $this->repository->getByEmail($ref_link);
            $customerId = $customerData->getData('entity_id');
            if ($customerId > 0) {
                $this->customCookie->setCustomCookie('ref-link', $ref_link);
            }
        }
        $var = $_COOKIE;
        return $this;
    }
}
