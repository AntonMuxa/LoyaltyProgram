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

    /**
     * @param string $email
     * @return LoyaltyProgramInterface
     */
    public function getByEmail(string $email): LoyaltyProgramInterface;

    /**
     * @param LoyaltyProgramInterface $customer
     * @return LoyaltyProgramInterface
     */
    public function save(LoyaltyProgramInterface $customer): LoyaltyProgramInterface;

    /**
     * @param $id
     * @return mixed
     */
    public function getPoints($id);
}
