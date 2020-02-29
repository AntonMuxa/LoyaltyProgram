<?php


namespace Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alevel\User\Model\ResourceModel\LoyaltyProgram as ResourceModel;
use Alevel\User\Model\LoyaltyProgram as Model;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->init(Model::class, ResourceModel::class);
    }
}