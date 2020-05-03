<?php

namespace Alevel\LoyaltyProgram\Block\Adminhtml\Customeredit\Tab;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Backend\Block\Widget\Form;

class View extends \Magento\Backend\Block\Template implements \Magento\Ui\Component\Layout\Tabs\TabInterface
{
    //protected $_template = 'tab/customtab_view.phtml';

    protected $_loyaltyProgramRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        LoyaltyProgramRepositoryInterface $_loyaltyProgramRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_loyaltyProgramRepository = $_loyaltyProgramRepository;
    }
    public function getCustomerId()
    {
        return $this->getRequest()->getParam('id');
    }
    public function getTabLabel()
    {
        return __('Loyalty Program');
    }
    public function getTabTitle()
    {
        return __('Loyalty Program');
    }

    public function canShowTab()
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }
    public function isHidden()
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }
    public function getTabClass()
    {
        return '';
    }

    public function getTabUrl()
    {
        return '';
    }
    public function isAjaxLoaded()
    {
        return false;
    }
    public function getPoints()
    {
        return $this->_loyaltyProgramRepository->getPoints($this->getCustomerId());
    }
}
