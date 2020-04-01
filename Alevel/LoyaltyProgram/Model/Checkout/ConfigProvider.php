<?php

namespace Alevel\LoyaltyProgram\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\Session as CustomerSession;

class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * ConfigProvider constructor.
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder,
        CustomerSession $customerSession
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->customerSession = $customerSession;
    }

    /**
     * Provide configuration action path.
     *
     * @return array
     */
    public function getConfig() : array
    {
        return [
            'managePointsPath' => $this->getRecollectTotalsPath(),
            'getUsePoints' => $this->getUsePoints()
        ];
    }

    /**
     * Get action path for re-collect totals.
     *
     * @return string
     */
    private function getRecollectTotalsPath(): string
    {
        return $this->urlBuilder->getUrl('loyaltyprogram/manage/points');
    }

    private function getUsePoints()
    {
        return $this->customerSession->getUsePoints();
    }
}
