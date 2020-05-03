<?php

namespace Alevel\LoyaltyProgram\Setup;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;

    private $eavSetupFactory;
    /**
     * @var Config
     */
    private $eavConfig;
    /**
     * @var Attribute
     */
    private $attributeResource;

    /**
     * Init
     *
     * @param CustomerSetupFactory $customerSetupFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     * @param Attribute $attributeResource
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        Attribute $attributeResource
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
        $this->attributeResource = $attributeResource;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->removeAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, 'loyalty_points');
            //$this->createLoyaltyPointsAttribute($setup);
        }
        $setup->endSetup();
    }

    public function createLoyaltyPointsAttribute($setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeCode = 'loyalty_points';
        $eavSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            $attributeCode,
            [
                'type' => 'int',
                'label' => 'Loyalty Points',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'default' => '0',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
                'position' => 100,
                'system' => 0,
            ]
        );

        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            $attributeCode
        );

        $attribute = $this->eavConfig->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, $attributeCode);
        // used_in_forms are of these types you can use forms key according to your need ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address', 'customer_account_create']
        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        );
        $this->attributeResource->save($attribute);
    }
}
