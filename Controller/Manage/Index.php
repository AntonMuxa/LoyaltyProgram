<?php


namespace Alevel\LoyaltyProgram\Controller\Manage;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session;
use Magento\Customer\Controller\AbstractAccount;

/**
 * Class Show.
 *
 * @package Alevel\LoyaltyProgram\Controller\Manage
 */
class Index extends AbstractAccount
{
    /**
     * Render posts.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}