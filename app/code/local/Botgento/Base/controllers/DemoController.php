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

class Botgento_Base_DemoController extends Mage_Core_Controller_Front_Action
{
    /**
     * Bgc Action
     *
     */
    public function bgcAction()
    {
        $botHelper = Mage::helper('botgento');
        $authId = $this->getRequest()->getHeader('Authorization');
        $auth = $botHelper->getWebsiteApiKey();

        if (!empty($auth) && $auth == $authId) {
            $quoteId = Mage::getSingleton('checkout/session')->getQuoteId();
            $uuid = $botHelper->getUuid();

            $collection = Mage::getModel('botgento/subscribermapping')
                ->getCollection()
                ->addFieldToFilter("quote_id", $quoteId)
                ->addFieldToFilter('uuid', $uuid)
                ->getLastItem();

            if ($collection->getId()) {
                $subscriberMappingModel = Mage::getModel('botgento/subscribermapping')->load($collection->getId());
                $subscriberMappingModel->setIsButtonPress(1);
                $subscriberMappingModel->save();
            }

            $result = "Success";
        } else {
            $result = "Failed";
        }

        $this->getResponse()->setHeader('Content-type', 'text/plain');
        return $this->getResponse()->setBody($result);

    }
}