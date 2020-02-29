<?php


namespace Alevel\LoyaltyProgram\Model;


use Alevel\LoyaltyProgram\Api\Model\LoyaltyProgramInterface;
use Alevel\User\Model\ResourceModel\LoyaltyProgram as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class LoyaltyProgram extends AbstractModel implements LoyaltyProgramInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}