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

class Botgento_Base_InstockController extends Mage_Core_Controller_Front_Action
{
    public function alertAction()
    {
        $productId = $this->getRequest()->getParam('product_id');

        $uuid = $this->getRequest()->getParam('uuid');

        if (!empty($productId) && !empty($uuid)) {
            $collection = Mage::getModel('botgento/instockalert')
                ->getCollection()
                ->addFieldToFilter("product_id", $productId)
                ->addFieldToFilter("uuid", $uuid)
                ->addFieldToFilter("is_notification_sent", 0);

            if (!$collection->getSize()) {
                $websiteId = Mage::app()->getWebsite()->getId();
                $model = Mage::getModel('botgento/instockalert');
                $model->setUuid($uuid);
                $model->setProductId($productId);
                $model->setWebsiteId($websiteId);
                $model->setIsNotificationSent(0);
                $model->setCreatedAt(now());
                $model->setUpdatedAt(now());
                $model->save();

                $result = "Subscribed successfully";
            } else {
                $result = "You have allready subscribed for this";
            }

            $this->getResponse()->setHeader('Content-type', 'text/plain');
            return $this->getResponse()->setBody($result);
        }
    }
}