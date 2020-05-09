<?php

namespace Alevel\LoyaltyProgram\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.3') < 0) {
            $columns = [
                    'quote' => [
                        'loyalty' => [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Loyalty points'
                        ],
                        'base_loyalty'=> [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Base Loyalty points'
                        ]
                    ],
                    'quote_address' => [
                        'loyalty' => [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Loyalty points'
                        ],
                        'base_loyalty'=> [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Base Loyalty points'
                        ]
                    ],
                    'sales_order' => [
                        'loyalty' => [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Loyalty points'
                        ],
                        'base_loyalty'=> [
                            'type' => Table::TYPE_DECIMAL,
                            'nullable' => false,
                            'default'  => 0.0,
                            'comment'  => 'Base Loyalty points'
                        ]
                    ],
                ];

            $connection = $setup->getConnection();

            foreach ($columns as $tableName => $columnData) {
                foreach ($columnData as $columnName => $definition) {
                    $connection->addColumn(
                            $connection->getTableName($tableName),
                            $columnName,
                            $definition
                        );
                }
            }
        }

        $setup->endSetup();
    }
}
