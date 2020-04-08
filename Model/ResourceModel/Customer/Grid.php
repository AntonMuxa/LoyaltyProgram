<?php

namespace Alevel\LoyaltyProgram\Model\ResourceModel\Customer;

class Grid
{
    public static $table = 'customer_grid_flat';

    public static $leftJoinTable = 'customer_entity';

    public function afterSearch($interceptor, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {
            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);

            $collection
                ->getSelect()
                ->joinLeft(
                    ['ce'=>$leftJoinTableName],
                    "ce.entity_id = main_table.entity_id",
                    [
                        'loyalty_points' => 'ce.loyalty_points'
                    ]
                );

            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);

            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where)->group('main_table.entity_id');
        }
        return $collection;
    }
}
