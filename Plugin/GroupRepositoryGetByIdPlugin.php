<?php

namespace Alevel\LoyaltyProgram\Plugin;


class GroupRepositoryGetByIdPlugin
{

    public $groupExtensionFactory;

    public $groupRegistry;

    public function __construct(
        \Magento\Customer\Model\GroupRegistry $groupRegistry,
        \Magento\Customer\Api\Data\GroupExtensionFactory $groupExtensionFactory
    )
    {
        $this->groupRegistry = $groupRegistry;
        $this->groupExtensionFactory = $groupExtensionFactory;
    }

    public function afterGetById(
        \Magento\Customer\Api\GroupRepositoryInterface $subject,
        \Magento\Customer\Api\Data\GroupInterface $result
    )
    {
        $id = $result->getId();
        $groupModel = $this->groupRegistry->retrieve($id);
        $percent = $groupModel->getData('loyalty_percent');
        $extension = $result->getExtensionAttributes() ? $result->getExtensionAttributes() : $this->groupExtensionFactory->create();
        $extension->setLoyaltyPercent($percent);
        $result->setExtensionAttributes($extension);
        return $result;
    }
}