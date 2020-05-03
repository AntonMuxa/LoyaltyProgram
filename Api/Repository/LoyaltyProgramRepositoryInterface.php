<?php

namespace Alevel\LoyaltyProgram\Api\Repository;

use ALevel\LoyaltyProgram\Api\Model\LoyaltyProgramInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface LoyaltyProgramRepositoryInterface
{
    /**
     * @param int $id
     * @throws NoSuchEntityException
     * @return LoyaltyProgramInterface
     */
    public function getById(int $id) : LoyaltyProgramInterface;

    public function getByEmail(string $email): LoyaltyProgramInterface;

    public function save(LoyaltyProgramInterface $customer): LoyaltyProgramInterface;

    public function getPoints($id);
}
