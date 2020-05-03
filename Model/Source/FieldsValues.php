<?php

namespace Alevel\LoyaltyProgram\Model\Source;

use Alevel\LoyaltyProgram\Api\Repository\LoyaltyProgramRepositoryInterface;
use Magento\Framework\Data\ValueSourceInterface;

class FieldsValues implements ValueSourceInterface
{
    /**
     * @var LoyaltyProgramRepositoryInterface
     */
    private $repository;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        LoyaltyProgramRepositoryInterface $repository
    ) {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function getCustomerId()
    {
        return $this->request->getParam('id');
    }

    public function getValue($name)
    {
        $customer_data = $this->repository->getById($this->getCustomerId());
        $value = $customer_data->getData($name);
        return !empty($value) ? $value : 0;
    }
}
