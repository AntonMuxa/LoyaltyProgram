<?php

namespace Alevel\LoyaltyProgram\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;

/**
 * Class ConfigProvider.
 *
 * @package Atom\SurchargePayment\Model\Checkout
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * ConfigProvider constructor.
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Provide configuration action path.
     *
     * @return array
     */
    public function getConfig() : array
    {
        return [
            'manage_points' => $this->getRecollectTotalsPath()
        ];
    }

    /**
     * Get action path for re-collect totals.
     *
     * @return string
     */
    private function getRecollectTotalsPath(): string
    {
        return $this->urlBuilder->getUrl('loyaltyprogram/manage/points', array('_secure'=>true));
    }
}
