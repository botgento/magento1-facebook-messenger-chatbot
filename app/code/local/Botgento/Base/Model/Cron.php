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

class Botgento_Base_Model_Cron
{
    public function syncData()
    {
        $botHelper = Mage::helper('botgento');

        foreach (Mage::app()->getWebsites() as $website) {
            $websiteId = $website->getId();
            $storesArray = array();
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                foreach ($stores as $store) {
                    $storesArray[] = $store->getId();
                }
            }

            $data = $botHelper->getAbandonedCartData($storesArray);

            $totalSyncCount = count($data);

            if ($totalSyncCount > 0) {
                $jsonData = array('user_data' => Mage::helper('core')->jsonEncode($data));

                $token = $botHelper->getWebsiteApiKeyByWebsiteId($websiteId);
                $websiteHash = $botHelper->getWebsiteHashByWebsiteId($websiteId);

                $auth = array('Website-Hash:'.$websiteHash, 'Website-Token:'.$token);

                $url = $botHelper->getBotgentoUrl().'v1/botgento/abandoned-cart';
                $result = $botHelper->getCurlData($url, $auth, $jsonData);

                $syncLogModel = Mage::getModel('botgento/synclog');
                $syncLogModel->setType('abandoned_cart');
                $syncLogModel->setWebsiteId($websiteId);
                if (is_array($result)) {
                    if ($result['status']) {
                        $syncLogModel->setStatus('success');
                        $syncLogModel->setTotalSyncData($totalSyncCount);
                    } else {
                        $syncLogModel->setStatus('failed');
                        $syncLogModel->setErrorDetails($result['message']);
                    }
                } else {
                    $syncLogModel->setStatus('failed');
                }

                $syncLogModel->setCreatedAt(now());
                $syncLogModel->save();
                $syncLogModel->unsetData();
            }
        }
    }

    public function instockAlert()
    {
        $botHelper = Mage::helper('botgento');

        foreach (Mage::app()->getWebsites() as $website) {
            $websiteId = $website->getId();

            $data = $botHelper->getInStockAlertData($website);
            $totalInStockAlertCount = count($data);

            if (!empty($totalInStockAlertCount)) {
                $instockAlertData = array_chunk($data, 10);

                $token = $botHelper->getWebsiteApiKeyByWebsiteId($websiteId);
                $websiteHash = $botHelper->getWebsiteHashByWebsiteId($websiteId);


                $auth = array('Authorization:Bearer '.$token);

                $url = $botHelper->getBotgentoApiUrl($websiteHash."/back-in-stock-message");

                foreach ($instockAlertData as $instockData) {
                    $instockAlertArray = array();
                    $instockIdsArray = array();

                    foreach ($instockData as $instock) {
                        if (isset($instock['instock_ids'])) {
                            foreach ($instock['instock_ids'] as $instockId) {
                                $instockIdsArray[] = $instockId;
                            }
                        }

                        unset($instock['instock_ids']);
                        $instockAlertArray[] = $instock;
                    }

                    $jsonData = array('alert_items' => Mage::helper('core')->jsonEncode($instockAlertArray));

                    $result = $botHelper->getCurlData($url, $auth, $jsonData);

                    if (is_array($result) && $result['status'] == 'success') {
                        foreach ($instockIdsArray as $alertId) {
                            $inStockModel = Mage::getModel('botgento/instockalert')->load($alertId);
                            if (!empty($inStockModel)) {
                                $inStockModel->setIsNotificationSent(1);
                                $inStockModel->setUpdatedAt(now());
                                $inStockModel->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
