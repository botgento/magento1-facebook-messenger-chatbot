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

class Botgento_Base_V1_ServiceController extends Mage_Core_Controller_Front_Action
{
    protected $_authorized = true;

    /**
     * Pre Dispatch
     *
     * @return void
     * @throws Zend_Controller_Request_Exception
     */
    public function preDispatch()
    {
        parent::preDispatch();
        Mage::app()->getResponse()->setHeader('Content-type', 'application/json');
        $params = json_decode($this->getRequest()->getParam('payload'), true);
        $apiKey = $this->getBotHelper()->getWebsiteApiKey();
        if (isset($params['type']) && $params['type'] == "config.details.save" && $apiKey == "") {
            return false;
        }

        if ($this->getRequest()->getHeader('Authorization') != $apiKey
            && $params['type'] != "ping"
        ) {
            $data = array(
                'status' => 'fail',
                'message' => 'Authorization Failed'
            );
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
            $this->_authorized = false;
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    /**
     * Helper
     *
     * @return Botgento_Base_Helper_Data|Mage_Core_Helper_Abstract
     */
    public function getBotHelper()
    {
        return Mage::helper('botgento');
    }

    /**
     * Index Action
     *
     * @return string
     * @throws Mage_Core_Exception
     */
    public function indexAction()
    {
        $params = json_decode($this->getRequest()->getParam('payload'), true);
        $data = null;
        if ($params['type'] != "" && $this->_authorized) {
            if ($params['type'] == 'categories.list') {
                $data = $this->getBotHelper()
                    ->getCategoryListApi($params['options']['offset'], $params['options']['limit']);
            } elseif ($params['type'] == "category.detail") {
                $data = $this->getBotHelper()->getCategoryDetailApi($params['options']);
            } elseif ($params['type'] == "products.list") {
                $data = $this->getBotHelper()
                    ->getProductListApi($params['options'], $params['options']['offset'], $params['options']['limit']);
            } elseif ($params['type'] == "product.detail") {
                $data = $this->getBotHelper()->getProductDetailApi($params['options']);
            } elseif ($params['type'] == "catalog.details") {
                $data = $this->getBotHelper()->getCatalogDetailApi($params['options']);
            } elseif ($params['type'] == "ping") {
                $data = $this->getBotHelper()->getPingApi();
            } elseif ($params['type'] == "config.details.save") {
                $data = $this->getBotHelper()->getConfigDetailSaveApi($params['options']);
            } elseif ($params['type'] == "order.lists") {
                $data = $this->getBotHelper()->getOrderListApi($params['options']);
            } elseif ($params['type'] == "order.detail") {
                $data = $this->getBotHelper()->getOrderDetailApi($params['options']);
            } elseif ($params['type'] == "wishlist.items") {
                $data = $this->getBotHelper()->getWhishlistItemsApi($params['options']);
            } elseif ($params['type'] == "purge.data") {
                $data = $this->getBotHelper()->purgeBotgentoData();
            } elseif ($params['type'] == "data") {
                $data = $this->getBotHelper()->sendTableDataToBotgento($params['options']);
            } elseif ($params['type'] == "store.sync.attributes") {
                $data = $this->getBotHelper()->saveAttributeDataToTable($params['options']);
            } elseif ($params['type'] == "quote.orders") {
                $data = $this->getBotHelper()->getOrderStatusFromQuote($params['options']);
            } else {
                $data = array(
                    'status'=>'Success',
                    'message'=>'There is no matching API found.'
                );
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
        }
    }
}