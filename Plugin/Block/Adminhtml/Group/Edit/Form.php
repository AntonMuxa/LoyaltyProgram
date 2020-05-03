<?php

namespace Alevel\LoyaltyProgram\Plugin\Block\Adminhtml\Group\Edit;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Customer\Api\Data\GroupInterfaceFactory;
use Magento\Customer\Api\GroupRepositoryInterface;

class Form
{
    protected $_loyaltyProgramRepository;

    protected $_groupRepository;

    protected $_group;

    public function __construct(
        LoyaltyProgramRepositoryInterface $_loyaltyProgramRepository,
        GroupRepositoryInterface $_groupRepository,
        GroupInterfaceFactory $_group
    ) {
        $this->_loyaltyProgramRepository = $_loyaltyProgramRepository;
        $this->_groupRepository = $_groupRepository;
        $this->_group = $_group;
    }
    public function aroundGetFormHtml(
        \Magento\Customer\Block\Adminhtml\Group\Edit\Form $subject,
        \Closure $proceed
    ) {
        $percent = 0;
        $group_id = $subject->getRequest()->getParam('id');
        if ($group_id  !== null && $group_id > 0) {
            $customerData = $this->_groupRepository->getById($group_id);
            $extensions = $customerData->getExtensionAttributes();
            $percent = $extensions->getLoyaltyPercent();
        }
        $form = $subject->getForm();
        if (is_object($form)) {
            $fieldset = $form->getElement('base_fieldset');
            $fieldset->addField(
                'loyalty_percent',
                'text',
                [
                    'name' => 'loyalty_percent',
                    'label' => __('Loyalty Percent'),
                    'title' => __('Loyalty Percent'),
                    'required' => false,
                    'value' => $percent
                ]
            );

            $subject->setForm($form);
        }

        return $proceed();
    }
}
