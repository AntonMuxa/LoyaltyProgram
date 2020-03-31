<?php


namespace Alevel\LoyaltyProgram\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Points controller
 *
 * @method \Magento\Framework\App\RequestInterface getRequest()
 */
class Points extends AbstractAccount
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository
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
            //$quote = $this->cartRepository->get($quoteId);
            //$quote->collectTotals()->save();


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