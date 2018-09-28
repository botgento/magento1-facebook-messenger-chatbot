<?php
/**
 * Botgento
 *
 * @category    Botgento
 * @package     Botgento_Base
 * @author      Botgento Team <support@botgento.com>
 * @copyright   Botgento (https://www.botgento.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Botgento_Base_Model_Observer
{
    const COOKIE_NAME = 'bgc_uuid';
    /**
     * @return Botgento_Base_Helper_Data|Mage_Core_Helper_Abstract
     */
    public function getBotHelper()
    {
        return Mage::helper('botgento');
    }

    /**
     * Message will send to customer in Facebook messenger.
     *
     * @param Varien_Event_Observer $observer Observer
     *
     * @return void
     * @throws Exception
     */
    public function optInMessageApi(Varien_Event_Observer $observer)
    {
        if (Mage::app()->getRequest()->getPost('fbmessenger') == 'checked' && $this->getBotHelper()->isEnable()) {
            $token = $this->getBotHelper()->getWebsiteApiKey();
            $websiteHash = $this->getBotHelper()->getWebsiteHash();

            /** @var  $order Mage_Sales_Model_Order */
            $order = $observer->getEvent()->getOrder();
            $isPrimary = 1;
            if ($order->getCustomerIsGuest()) {
                $isPrimary = 0;
            }

            $url = $this->getBotHelper()->getBotgentoApiUrl("$websiteHash/checkbox-checked");

            $payload = Mage::helper('sales')->__('Thank You for your order.');
            $userRef = Mage::app()->getRequest()->getPost('user_ref');
            $email = $order->getCustomerEmail();
            $auth = array('Authorization:' . $token);
            if (Mage::app()->getRequest()->getPost('optin')) {
                $payload = array('payload' => $payload, 'email' => $email, 'is_primary' => $isPrimary);
            } else {
                $payload = array('payload' => $payload, 'email' => $email,
                    'user_ref' => $userRef, 'is_primary' => $isPrimary);
            }

            $result = $this->getBotHelper()->getCurlData($url, $auth, $payload);

            $recipientId = Mage::app()->getRequest()->getPost('user_ref');
            $collection = Mage::getModel('botgento/user')->getCollection()
                ->addFieldToFilter('email', $order->getCustomerEmail());
            if (count($collection) == 0) {
                $model = Mage::getModel('botgento/user');
                $model->setCustomerId($order->getCustomerId());
                $model->setEmail($order->getCustomerEmail());
                $model->setSubscriberId($recipientId);
                $model->setCreatedTime(now());
                $model->save();
            } else {
                $collection = $collection->getFirstItem();
                $model = Mage::getModel('botgento/user')->load($collection->getBotgentoId());
                $model->setCustomerId($order->getCustomerId());
                $model->setSubscriberId($recipientId);
                $model->save();
            }

            // Order Information
            $order = $observer->getEvent()->getOrder();
            $_shippingAddress = $order->getShippingAddress();
            $ruleName = "";
            foreach (explode(",", $order->getAppliedRuleIds()) as $ruleId) {
                $rule = Mage::getModel('salesrule/rule')->load($ruleId);
                $ruleName = $rule->getName();
            }

            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $elements[] = array(
                    "title" => $item->getName(),
                    "subtitle" => "",
                    "quantity" => $item->getQtyOrdered(),
                    "price" => $item->getPrice(),
                    "currency" => $order->getOrderCurrencyCode(),
                    "image_url" => $product->getImageUrl()
                );
            }

            $data = array(
                'template_type' => 'receipt',
                'recipient_name' => $order->getCustomerName(),
                'order_number' => $order->getIncrementId(),
                'currency' => $order->getOrderCurrencyCode(),
                'payment_method' => $order->getPayment()->getMethodInstance()->getTitle(),
                'order_url' => Mage::getUrl("sales/order/view/") . 'order_id/' . $order->getId(),
                'timestamp' => strtotime($order->getCreatedAtStoreDate()),
                'address' => array(
                    "street_1" => $order->getBillingAddress()->getStreet(1),
                    "street_2" => $order->getBillingAddress()->getStreet(2),
                    "city" => $_shippingAddress->getCity(),
                    "postal_code" => $_shippingAddress->getPostcode(),
                    "state" => $_shippingAddress->getRegion() === null ?
                        Mage::app()->getLocale()->getCountryTranslation($_shippingAddress->getCountry()) :
                        $_shippingAddress->getRegion(),
                    "country" => $_shippingAddress->getCountry()
                ),
                "summary" => array(
                    "subtotal" => $order->getSubtotal(),
                    "shipping_cost" => $order->getShippingAmount(),
                    "total_tax" => $order->getTaxAmount(),
                    "total_cost" => $order->getGrandTotal()
                ),
                'elements' => $elements
            );

            $discount = abs($order->getDiscountAmount());
            if ($ruleName && $discount) {
                $data['adjustments'] = array(
                    array(
                        "name" => $ruleName,
                        "amount" => $discount
                    )
                );
            }

            $curlPostFields = array('payload' => json_encode($data),
                'user_ref' => Mage::app()->getRequest()->getPost('user_ref'),
                'email' => $order->getCustomerEmail(),
                'quote_id' => $order->getQuoteId()
            );
            $modelApi = Mage::getModel('botgento/apidata');
            $sendTime = Mage::getModel('core/date')->date(
                'Y-m-d H:i:s',
                strtotime(now() . +$this->getBotHelper()->getOrderSendTime() . "seconds")
            );
            $modelApi->setApidata(json_encode($curlPostFields));
            $modelApi->setEmail($order->getCustomerEmail());
            $modelApi->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
            $modelApi->setOrderId($order->getIncrementId());
            $modelApi->setRecipientId($recipientId);
            $modelApi->setIsGuest($isPrimary);
            $modelApi->setSendTime($sendTime);
            $modelApi->setStatus(0);
            $modelApi->save();
        }
    }

    /**
     * Send order data to botgento
     *
     * @return bool
     * @throws Exception
     */
    public function sendDataToBotgento()
    {
        foreach (Mage::app()->getWebsites() as $website) {
            /**
             * @var  $website Mage_Core_Model_Website
             */
            $storeId = $website->getDefaultGroup()->getDefaultStore()->getId();
            Mage::app()->setCurrentStore($storeId);
            if ($this->getBotHelper()->isEnable() && $this->getBotHelper()->sendOrderDetail()) {
                $websiteHash = $this->getBotHelper()->getWebsiteHash();
                $collection = Mage::getModel('botgento/apidata')->getCollection()
                            ->addFieldToFilter('website_id', $website->getWebsiteId())
                            ->addFieldToFilter('status', 0)
                            ->addFieldToFilter('cron_exec_count', array('lt'=>5));
                foreach ($collection as $_collection) {
                    if (strtotime($_collection->getSendTime()) <=
                        strtotime(Mage::getModel('core/date')->date('Y-m-d H:i:s'))) {
                        $token = $this->getBotHelper()->getWebsiteApiKey();
                        $url = $this->getBotHelper()->getBotgentoApiUrl("$websiteHash/order-confirmation");
                        $auth = array('Authorization:Bearer ' . $token);
                        $payload = json_decode($_collection->getApidata(), true);
                        $result = $this->getBotHelper()->getCurlData($url, $auth, $payload);
                        $cronExecCount = $_collection->getCronExecCount();
                        $execCount = empty($cronExecCount)?0:$cronExecCount;
                        $execCount++;
                        $model = Mage::getModel('botgento/apidata')->load($_collection->getBotgentoDataId());
                    if ($result['status'] == 'success') {
                        $model->setStatus(1);
                    }

                        $model->setCronExecCount($execCount);
                        $model->save();
                    }
                }
            }
        }
    }

    /**
     * Send Enable/Disable status to botgento
     *
     */
    public function sendStatusToBotgento()
    {
        $websiteCode = Mage::app()->getRequest()->getParam('website');
        /**
         * @var  $website Mage_Core_Model_Website
         */
        $website = Mage::getModel("core/website")->load($websiteCode);
        $storeId = $website->getDefaultGroup()->getDefaultStore()->getId();
        Mage::app()->setCurrentStore($storeId);
        $websiteHash = $this->getBotHelper()->getWebsiteHash();
        $token = $this->getBotHelper()->getWebsiteApiKey();
        $url = $this->getBotHelper()->getBotgentoApiUrl("$websiteHash/set-extension-status");
        $auth = array('Authorization:Bearer' . $token);
        $payload = array('is_extension_enable' => Mage::getStoreConfig('base_options/botgento/enabled'));
        $this->getBotHelper()->getCurlData($url, $auth, $payload);
    }

    /**
     * Send Shipment data to botgento
     *
     * @param Varien_Event_Observer $observer
     */
    public function sendShipmentDataToBotgento(Varien_Event_Observer $observer)
    {
       /**
        * @var $shipment Mage_Sales_Model_Order_Shipment
        * @var $order Mage_Sales_Model_Order
        */
        $shipment = $observer->getEvent()->getShipment();
        $order = Mage::getModel('sales/order')->load($shipment->getOrderId());
        $storeId = $order->getStoreId();
        Mage::app()->setCurrentStore($storeId);
        if ($this->getBotHelper()->isEnable() && $this->getBotHelper()->sendShipmentDetail()) {
            $websiteHash = $this->getBotHelper()->getWebsiteHash();
            $url = $this->getBotHelper()->getBotgentoApiUrl("$websiteHash/order-shipment");
            $token = $this->getBotHelper()->getWebsiteApiKey();
            /** @var Mage_Sales_Model_Order_Address $address */
            $address = Mage::getModel('sales/order_address')
                ->load($shipment->getShippingAddressId());
            $customerName = $address->getFirstname() . " " . $address->getLastname();
            $email = $order->getCustomerEmail();
            $trackingNumbers = "";
            $addressStr = implode(', ', array_filter(array($address->getStreet1(), $address->getStreet2()))) . ', ';
            $addressStr .= $address->getCity() . ' ,' . $address->getRegion() . ', ';
            $addressStr .= $address->getCountryModel()->getName() . ' ,' . $address->getPostcode();

            $allTracks = $shipment->getAllTracks();
            if ($track = end($allTracks)) {
                $trackingNumbers = $track->getNumber();
                $carrier = $track->getTitle();
            }

            $apiData = Mage::getModel('botgento/apidata')
                ->load($order->getIncrementId(), 'order_id');
            $apiData->setStatus(1);
            $userRef = $apiData->getRecipientId();
            $payload = array(
                'email' => $order->getCustomerEmail(),
                'user_ref' => $userRef,
                'payload' => json_encode(
                    array(
                        'recipient_name' => $customerName,
                        'order_number' => $order->getIncrementId(),
                        'shipping_carrier' => $carrier,
                        'tracking_number' => $trackingNumbers,
                        'shipping_address' => $addressStr,
                    )
                )
            );

            $auth = array('Authorization:' . $token);
            $result = $this->getBotHelper()->getCurlData($url, $auth, $payload);
        }
    }

    /**
     * Add data in subscriber mapping table when quote created
     *
     * @param Varien_Event_Observer $observer
     */
    public function quoteSaveAfter(Varien_Event_Observer $observer) 
    {

        $quote = $observer->getEvent()->getQuote();

        if ($quote->getId()) {
            $quoteId = $quote->getId();
            $uuid = $this->getBotHelper()->getUuid();
            $collection = Mage::getModel('botgento/subscribermapping')
                ->getCollection()
                ->addFieldToFilter("quote_id", $quoteId)
                ->addFieldToFilter("uuid", $uuid);
            if (!$collection->getSize()) {
                $subscriberMappingModel = Mage::getModel('botgento/subscribermapping');
                $subscriberMappingModel->setQuoteId($quoteId);
                $subscriberMappingModel->setUuid($uuid);

                $cookie = Mage::getModel('core/cookie')->get(Botgento_Base_Helper_Data::BGC_OPTION_COOKIE_NAME);
                if (!empty($cookie) && $cookie == 1) {
                    $subscriberMappingModel->setIsButtonPress(1);
                } else {
                    $subscriberMappingCollection = Mage::getModel('botgento/subscribermapping')
                        ->getCollection()
                        ->addFieldToFilter("uuid", $uuid)
                        ->getLastItem();
                    if ($subscriberMappingCollection->hasData()) {
                        $subscriberMappingModel->setIsButtonPress($subscriberMappingCollection->getIsButtonPress());
                    } else {
                        $subscriberMappingModel->setIsButtonPress(0);
                    }
                }

                $subscriberMappingModel->save();
            }
        }
    }

    /**
     * Change the data in subscriber mapping table when customer login and quotes are merged
     *
     * @param Varien_Event_Observer $observer
     */
    public function loadCustomerQuoteBefore(Varien_Event_Observer $observer) 
    {

        $quoteId = $observer->getEvent()->getCheckoutSession()->getQuoteId();
        $customerQuote = Mage::getModel('sales/quote')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByCustomer(Mage::getSingleton('customer/session')->getCustomerId());

        if ($customerQuote->getId() && $quoteId != $customerQuote->getId()) {
            $uuid = $this->getBotHelper()->getUuid();

            $collection = Mage::getModel('botgento/subscribermapping')
                ->getCollection()
                ->addFieldToFilter("quote_id", $quoteId)
                ->getLastItem();

            $custQuoteSubsrcibeMappingCol = Mage::getModel('botgento/subscribermapping')
                ->getCollection()
                ->addFieldToFilter("quote_id", $customerQuote->getId())
                ->addFieldToFilter("uuid", $uuid)
                ->getLastItem();

            if ($custQuoteSubsrcibeMappingCol->hasData()) {
                $subscriberMappingModel = Mage::getModel('botgento/subscribermapping')->load($collection->getId());
                $subscriberMappingModel->delete();
            } else {
                if ($collection->getId()) {
                    $subscriberMappingModel = Mage::getModel('botgento/subscribermapping')->load($collection->getId());
                    $subscriberMappingModel->setQuoteId($customerQuote->getId());
                    $subscriberMappingModel->save();
                }
            }
        }
    }

    /**
     * Send cookie and order data to botgento after order placed
     *
     * @param Varien_Event_Observer $observer
     */
    public function sendCookieDataToBotgento(Varien_Event_Observer $observer) 
    {

        $order = $observer->getEvent()->getOrder();
        $cookies = Mage::getModel('core/cookie')->get();
        $bgUtmCookies = array();
        foreach ($cookies as $key=>$value) {
            if (stripos($key, 'bg_utm') === 0) {
                $bgUtmCookies[$key] = $value;
            }
        }

        if (!empty($bgUtmCookies)) {
            $websiteHash = $this->getBotHelper()->getWebsiteHashByCurrentWebsite();
            $token = $this->getBotHelper()->getWebsiteApiKeyByCurrentWebsite();
            $url = $this->getBotHelper()->getBotgentoApiUrl($websiteHash."/conversion");

            $data = array();
            $data['type'] = 'abandoned-cart';
            $data['customer_email'] = $order->getCustomerEmail();
            $data['order_id'] = $order->getIncrementId();
            $data['order_amount'] = $order->getBaseGrandTotal();
            $data['subtotal'] = $order->getBaseSubtotal();
            $data['order_currency_code'] = $order->getBaseCurrencyCode();
            $data['order_currency_symbol'] = Mage::app()->getLocale()
                ->currency($order->getBaseCurrencyCode())->getSymbol();
            $data['cookies'] = $bgUtmCookies;

            $jsonData = array('conversion_data' => Mage::helper('core')->jsonEncode($data));

            $auth = array('Authorization:Bearer '.$token);

            $result = $this->getBotHelper()->getCurlData($url, $auth, $jsonData);

            if (is_array($result) && $result['status'] == 'success') {
                foreach ($bgUtmCookies as $cookieName=>$cookieValue) {
                    Mage::getModel('core/cookie')->delete($cookieName);
                }
            }
        }
    }
}