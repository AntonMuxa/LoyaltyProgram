<?php

namespace Alevel\LoyaltyProgram\Repository;

use Alevel\LoyaltyProgram\Api\Model\LoyaltyProgramInterface;
use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Alevel\LoyaltyProgram\Model\LoyaltyProgramFactory as ModelFactory;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram as ResourceModel;
use Alevel\LoyaltyProgram\Model\ResourceModel\LoyaltyProgram\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;

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
    ) {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->collection = $collectionFactory;
        $this->processor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param int $id
     * @return LoyaltyProgramInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): LoyaltyProgramInterface
    {
        $customer = $this->modelFactory->create();

        $this->resource->load($customer, $id);

        if (empty($customer->getId())) {
            throw new NoSuchEntityException(__('Customer %1 not found', $id));
        }

        return $customer;
    }

    /**
     * @param string $email
     * @return LoyaltyProgramInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $email): LoyaltyProgramInterface
    {
        $customer = $this->modelFactory->create();

        $this->resource->load($customer, $email, 'email');

        if (empty($customer->getId())) {
            throw new NoSuchEntityException(__('Customer %1 not found', $email));
        }

        return $customer;
    }

    /**
     * @param LoyaltyProgramInterface $customer
     * @return LoyaltyProgramInterface
     */
    public function save(LoyaltyProgramInterface $customer): LoyaltyProgramInterface
    {
        try {
            $this->resource->save($customer);
        } catch (\Exception $e) {
            // added logger
            throw new CouldNotSaveException(__("Customer could not save"));
        }

        return $customer;
    }

    public function getPoints($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $customerData = $this->getById($id);
            return $customerData->getData('loyalty_points');
        } else {
            return 0;
        }
    }
}
