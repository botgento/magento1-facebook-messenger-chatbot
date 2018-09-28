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

class Botgento_Base_CartController extends Mage_Core_Controller_Front_Action
{
    /**
     * Add Action
     *
     */
    public function addAction()
    {
        $productId = $this->getRequest()->getParam('id');
        if ($productId != "") {
            $product = Mage::getModel('catalog/product')->load($productId);
            if ($product->canConfigure()) {
                Mage::getSingleton('core/session')
                    ->addError(Mage::helper('catalog')->__('Please specify the product\'s required option(s).'));
                return Mage::app()->getFrontController()->getResponse()->setRedirect($product->getProductUrl());
            } else {
                return Mage::app()->getFrontController()
                    ->getResponse()
                    ->setRedirect(Mage::helper('checkout/cart')->getAddUrl($product));
            }
        }
    }

    /**
     * Add quote Action
     *
     */
    public function addquoteAction()
    {
        $quoteId = $this->getRequest()->getParam('id');

        if ($quoteId) {
            $quote = Mage::getModel('sales/quote')->load($quoteId);

            if ($quote->getId() && $quote->getIsActive() == 1) {
                if ($quote->getItemsCount() > 0) {
                    $params = $this->getRequest()->getParams();
                    unset($params['id']);

                    foreach ($params as $paramName => $paramValue) {
                        Mage::getModel('core/cookie')->set($paramName, $paramValue, 86400*7);
                    }

                    Mage::getSingleton('checkout/session')->setQuoteId($quote->getId());

                    return $this->_redirectUrl(Mage::helper('checkout/url')->getCheckoutUrl());
                } else {
                    Mage::getSingleton('core/session')
                        ->addError(Mage::helper('botgento')->__('You have no items in your shopping cart.'));
                }
            } else {
                Mage::getSingleton('core/session')
                    ->addError(Mage::helper('botgento')->__('Requested quote does not exist'));
            }

            return $this->_redirect('/');
        }
    }
}