<?php


namespace Alevel\LoyaltyProgram\Controller\Manage;


use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class UpdateSession extends AbstractAccount
{
    /**
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
//        $credentials = null;
//        $httpBadRequestCode = 400;
//
//        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
//        $resultRaw = $this->resultRawFactory->create();
//        try {
//            $credentials = $this->helper->jsonDecode($this->getRequest()->getContent());
//        } catch (\Exception $e) {
//            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
//        }
//        if (!$credentials || $this->getRequest()->getMethod() !== 'POST' || !$this->getRequest()->isXmlHttpRequest()) {
//            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
//        }
//
//        $response = [
//            'errors' => false,
//            'message' => __('Login successful.')
//        ];
//        try {
//            $customer = $this->customerAccountManagement->authenticate(
//                $credentials['username'],
//                $credentials['password']
//            );
//            $this->customerSession->setCustomerDataAsLoggedIn($customer);
//            $redirectRoute = $this->getAccountRedirect()->getRedirectCookie();
//            if ($this->cookieManager->getCookie('mage-cache-sessid')) {
//                $metadata = $this->cookieMetadataFactory->createCookieMetadata();
//                $metadata->setPath('/');
//                $this->cookieManager->deleteCookie('mage-cache-sessid', $metadata);
//            }
//            if (!$this->getScopeConfig()->getValue('customer/startup/redirect_dashboard') && $redirectRoute) {
//                $response['redirectUrl'] = $this->_redirect->success($redirectRoute);
//                $this->getAccountRedirect()->clearRedirectCookie();
//            }
//        } catch (LocalizedException $e) {
//            $response = [
//                'errors' => true,
//                'message' => $e->getMessage(),
//            ];
//        } catch (\Exception $e) {
//            $response = [
//                'errors' => true,
//                'message' => __('Invalid login or password.'),
//            ];
//        }
//        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
//        $resultJson = $this->resultJsonFactory->create();
//        return $resultJson->setData($response);
            $response = [
                'errors' => false,
                'message' => __('its ok'),
            ];
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}