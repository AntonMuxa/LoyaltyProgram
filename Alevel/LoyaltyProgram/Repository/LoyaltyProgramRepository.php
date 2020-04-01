<?php

namespace Alevel\LoyaltyProgram\Repository;

use Alevel\LoyaltyProgram\Api\Model\LoyaltyProgramInterface;
use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram as ResourceModel;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram\Collection;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram\CollectionFactory;
use Alevel\LoyaltyProgram\Model\LoyaltyProgramFactory as ModelFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;

//use Alevel\LoyaltyProgram\Api\Repository\SearchResultsInterface;
//use Alevel\LoyaltyProgram\Model\LoyaltyProgram;
//use Alevel\LoyaltyProgram\Model\LoyaltyProgramFactory as FactoryModel;

class LoyaltyProgramRepository implements LoyaltyProgramRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resource;
    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collection;
    /**
     * @var CollectionProcessorInterface
     */
    private $processor;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        ResourceModel $resource,
        ModelFactory $modelFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    )
    {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->collection = $collectionFactory;
        $this->processor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): LoyaltyProgramInterface
    {
        $customer = $this->modelFactory->create();

        $this->resource->load($customer, $id);

        if(empty($customer->getId())) {
            throw new NoSuchEntityException(__('Customer %1 not found', $id));
        }

        return $customer;
    }

    public function getPoints(int $id) {
        $customerData = $this->getById($id);
        return $customerData->getData('loyalty_points');
    }
}
