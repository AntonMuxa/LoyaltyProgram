<?php

namespace Alevel\LoyaltyProgram\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Quote\Api\CartRepositoryInterface;

/**
 * Points controller
 *
 * @method \Magento\Framework\App\RequestInterface getRequest()
 */
class Points extends AbstractAccount
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     *
     * @param Context $context
     * @param Session $customerSession
     * @param JsonFactory $resultJsonFactory
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        JsonFactory $resultJsonFactory,
        CartRepositoryInterface $cartRepository
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->cartRepository = $cartRepository;
    }

    public function execute()
    {
        try {
            $this->_validateRequest();
            $use_points = $this->getRequest()->getParam('use_points');
            $quoteId = $this->getRequest()->getParam('quote_id');
            $this->customerSession->setUsePoints($use_points === 'true');
            $quote = $this->cartRepository->get($quoteId);
            $quote->collectTotals()->save();

            $response = [
                'errors' => false,
                'message' => __('Updated totals')
            ];
        } catch (LocalizedException $e) {
            $response = [
                'errors' => true,
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            $response = [
                'errors' => true,
                'message' => $e->getMessage(),
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }

    protected function _validateRequest()
    {
        if ($this->getRequest()->getMethod() !== 'POST' || !$this->getRequest()->isXmlHttpRequest()) {
            throw new NotFoundException(__('Request type is incorrect'));
        }
    }
}
