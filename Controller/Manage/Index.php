<?php

namespace Alevel\LoyaltyProgram\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

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
