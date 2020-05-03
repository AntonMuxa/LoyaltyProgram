<?php

namespace Alevel\LoyaltyProgram\Plugin\Controller\Adminhtml\Group;

use Magento\Framework\Exception\State\InvalidTransitionException;

class Save
{
    private $groupRepository;

    private $groupFactory;

    private $groupResourceModel;

    private $groupRegistry;

    private $groupExtensionFactory;

    public function __construct(
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Customer\Model\GroupFactory $groupFactory,
        \Magento\Customer\Model\ResourceModel\Group $groupResourceModel,
        \Magento\Customer\Model\GroupRegistry $groupRegistry,
        \Magento\Customer\Api\Data\GroupExtensionFactory $groupExtensionFactory
    ) {
        $this->groupRepository = $groupRepository;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $groupResourceModel;
        $this->groupRegistry = $groupRegistry;
        $this->groupExtensionFactory = $groupExtensionFactory;
    }

    public function afterExecute(
        \Magento\Customer\Controller\Adminhtml\Group\Save $subject,
        $result
    ) {

        $id = $subject->getRequest()->getParam('id');

        if ($id !== null) {
            $loyalty_percent = (int)$subject->getRequest()->getParam('loyalty_percent');
            $groupModel = $this->groupRegistry->retrieve($id);
            $groupModel->setData('loyalty_percent', $loyalty_percent);
            $extension = $groupModel->getExtensionAttributes() ? $groupModel->getExtensionAttributes() : $this->groupExtensionFactory->create();
            $extension->setLoyaltyPercent($loyalty_percent);
            $groupModel->setExtensionAttributes($extension);
            try {
                $this->groupResourceModel->save($groupModel);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                if ($e->getMessage() == (string)__('Customer Group already exists.')) {
                    throw new InvalidTransitionException(__('Customer Group already exists.'));
                }
                throw $e;
            }
        }

        return $result;
    }
}
