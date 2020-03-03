<?php


namespace Alevel\LoyaltyProgram\Api\Repository;

use ALevel\LoyaltyProgram\Api\Model\LoyaltyProgramInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface LoyaltyProgramRepositoryInterface
{
    /**
     * @param int $id
     * @throws NoSuchEntityException
     * @return LoyaltyProgramInterface
     */
    public function getById(int $id) : LoyaltyProgramInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResultsInterface;

}