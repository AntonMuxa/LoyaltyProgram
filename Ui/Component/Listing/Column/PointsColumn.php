<?php
namespace Alevel\LoyaltyProgram\Ui\Component\Listing\Column;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PointsColumn extends Column
{
    protected $customerFactory;
    protected $_searchCriteria;
    protected $repository;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        SearchCriteriaBuilder $criteria,
        LoyaltyProgramRepositoryInterface $repository,
        array $components = [],
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->_searchCriteria  = $criteria;
        $this->repository = $repository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $points = $this->repository->getPoints($item["entity_id"]);
                $item[$this->getData('name')] = $points;
            }
        }
        return $dataSource;
    }
}
