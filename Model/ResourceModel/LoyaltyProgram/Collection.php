<?php


namespace Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram as ResourceModel;
use Alevel\LoyaltyProgram\Model\LoyaltyProgram as Model;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}