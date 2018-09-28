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

/**
 * Class Botgento_Base_Helper_Data
 */
class Botgento_Base_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_BOTGENTO_ENABLE = 'base_options/botgento/enabled';
    const XML_PATH_BOTGENTO_KEY_VALID = 'botgento/key/valid';
    const XML_PATH_BOTGENTO_API_KEY = 'base_options/botgento/api_key';
    const XML_PATH_BOTGENTO_CHECKBOX_ENABLE = 'base_options/botgento/checkbox_enable';
    const XML_PATH_BOTGENTO_FACEBOOK_BUTTON = 'base_options/botgento/facebook_button';
    const XML_PATH_BOTGENTO_SEND_ORDER_DETAIL = 'base_options/order/order_confirmation';
    const XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL = 'base_options/order/shipment_details';
    const XML_PATH_BOTGENTO_MESSENGERAPP_ID = 'botgento/messengerapp/id';
    const XML_PATH_BOTGENTO_FBPAGE_ID = 'botgento/fb/page_id';
    const XML_PATH_BOTGENTO_WEBSITE_HASH = 'botgento/website/hash';
    const XML_PATH_BOTGENTO_ORDER_SEND_TIME = 'base_options/order/send_timer';
    const XML_PATH_BOTGENTO_INSTOCK_ENABLE = 'base_options/instock/enabled';
    const XML_PATH_BOTGENTO_INSTOCK_BUTTON_TEXT = 'base_options/instock/button_text';
    const XML_PATH_BOTGENTO_INSTOCK_BUTTON_COLOR = 'base_options/instock/button_color';
    const XML_PATH_BOTGENTO_INSTOCK_BUTTON_SIZE = 'base_options/instock/button_size';
    const BGC_UUID_COOKIE_NAME = 'bgc_uuid';
    const BGC_OPTION_COOKIE_NAME = 'bgc_optin';

    /**
     * Get Botgento status
     *
     * @param null|int $store The store id
     *
     * @return bool
     */
    public function isEnable($store = null)
    {
        if (Mage::getStoreConfig(self::XML_PATH_BOTGENTO_ENABLE, $store)
            && Mage::getStoreConfig(self::XML_PATH_BOTGENTO_KEY_VALID, $store)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get Facebook checkbox status
     *
     * @return bool
     */
    public function isFacebookCheckboxEnable()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_BOTGENTO_CHECKBOX_ENABLE);
    }

    /**
     * Get website api key
     *
     * @return mixed
     */
    public function getWebsiteApiKey()
    {
        return Mage::getStoreConfig(self::XML_PATH_BOTGENTO_API_KEY);
    }

    /**
     * Get website api key by current website scope
     *
     * @return mixed
     */
    public function getWebsiteApiKeyByCurrentWebsite()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_API_KEY);
    }

    /**
     * Get website api key by website id
     *
     * @return mixed
     */
    public function getWebsiteHashByCurrentWebsite()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_WEBSITE_HASH);
    }

    /**
     * Get website api key by website id
     *
     * @return mixed
     */
    public function getWebsiteApiKeyByWebsiteId($websiteId)
    {
        return Mage::app()->getWebsite($websiteId)->getConfig(self::XML_PATH_BOTGENTO_API_KEY);
    }

    /**
     * Get In stock alert is enable or not
     *
     * @return bool
     */
    public function getInStockEnable()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_INSTOCK_ENABLE);
    }

    /**
     * Get button text for instock alert button
     *
     * @return mixed
     */
    public function getInStockButtonText()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_INSTOCK_BUTTON_TEXT);
    }

    /**
     * Get button color for instock alert button
     *
     * @return mixed
     */
    public function getInStockButtonColor()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_INSTOCK_BUTTON_COLOR);
    }

    /**
     * Get button size for instock alert button
     *
     * @return mixed
     */
    public function getInStockButtonSize()
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_BOTGENTO_INSTOCK_BUTTON_SIZE);
    }

    /**
     * Get website api key by website id
     *
     * @return mixed
     */
    public function getWebsiteHashByWebsiteId($websiteId)
    {
        return Mage::app()->getWebsite($websiteId)->getConfig(self::XML_PATH_BOTGENTO_WEBSITE_HASH);
    }

    /**
     * Get facebook button status
     *
     * @return bool
     */
    public function isShowFacebookButton()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_BOTGENTO_FACEBOOK_BUTTON);
    }

    /**
     * Get is order confirm enable
     *
     * @return bool
     */
    public function sendOrderDetail()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_BOTGENTO_SEND_ORDER_DETAIL);
    }

    /**
     * Get is shipment send enable
     *
     * @return bool
     */
    public function sendShipmentDetail()
    {
        return (bool)Mage::getStoreConfig(
            self::XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL
        );
    }

    /**
     * Get App id
     *
     * @return mixed
     */
    public function getMessengerappId()
    {
        return Mage::getStoreConfig(self::XML_PATH_BOTGENTO_MESSENGERAPP_ID);
    }

    /**
     * Get facebook page id
     *
     * @return mixed
     */
    public function getFbPageId()
    {
        return Mage::getStoreConfig(self::XML_PATH_BOTGENTO_FBPAGE_ID);
    }

    /**
     * Get hash
     *
     * @return mixed
     */
    public function getWebsiteHash()
    {
        return Mage::getStoreConfig(self::XML_PATH_BOTGENTO_WEBSITE_HASH);
    }

    /**
     * Get order send time
     *
     * @return int
     */
    public function getOrderSendTime()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_BOTGENTO_ORDER_SEND_TIME);
    }

    /**
     * Get website url
     *
     * @return string
     */
    public function origin()
    {
        $https = Mage::app()->getRequest()->getServer('HTTPS');
        if ($https) {
            $protocol = ($https && $https != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }

        return $protocol . "://" . Mage::app()->getRequest()->getServer('HTTP_HOST');
    }

    /**
     * Get Category lists
     *
     * @param int $offset Offset
     * @param int $limit  Limit
     *
     * @return array
     */
    public function getCategoryListApi($offset,$limit)
    {
        $data = array();
        try {
            $rootId = Mage::app()->getStore()->getRootCategoryId();
            $collection = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('shop_now', 1)
                ->addAttributeToFilter('is_active', 1)
                ->addAttributeToSelect('*')
                ->addFieldToFilter('path', array('like'=> "1/$rootId/%"));

            $this->setLimit($collection, $limit, $offset);

            $medialUrl = Mage::getBaseDir('media');
            $defaultCategoryImage = (string)Mage::helper('catalog/image')
                ->init(Mage::getModel('catalog/product'), 'image')
                ->resize(600, 315);
            foreach ($collection as $_collection) {
                $imagePath = $medialUrl.DS.'catalog'.DS.'category'.DS.$_collection->getImage();
                if ($_collection->getImage()) {
                    $resizedPath = $medialUrl.DS.'catalog'.DS.'category'.
                        DS.'resizeimage'.DS.$_collection->getImage();
                    $this->getResizeImage($imagePath, $resizedPath, 600, 315);
                    $categoryImage = $medialUrl . '/catalog/category/resizeimage/'.
                        $_collection->getImage();
                } else {
                    $categoryImage = $defaultCategoryImage;
                }

                $thumbPath = $medialUrl.DS.'catalog'.DS.'category'.DS.$_collection->getThumbnail();
                if ($_collection->getThumbnail()) {
                    $resizedThumbPath = $medialUrl.DS.'catalog'.DS.'category'.DS.'resizeimage'
                        .DS.$_collection->getThumbnail();
                    $this->getResizeImage($thumbPath, $resizedThumbPath, 600, 315);
                    $categoryThumb = $medialUrl.'catalog/category/resizeimage/'.
                        $_collection->getThumbnail();
                } else {
                    $categoryThumb = $defaultCategoryImage;
                }

                $data[] = array(
                    "category_id" => $_collection->getId(),
                    "name" => $_collection->getName(),
                    "url_key" => $_collection->getUrlKey(),
                    "thumbnail" => $categoryThumb,
                    "description" => strip_tags($_collection->getDescription()),
                    "image" => $categoryImage,
                    "url_path" => $_collection->getUrlPath(),
                );
            }

            $status = 'success';
        } catch (Exception $e) {
            $status = 'fail';
        }

        $category = array();
        $category['categories']['list'] = $data;
        $category['categories']['item_count'] = count($data);
        $category['categories']['total'] = !empty($collection) ? $collection->getSize() : 0;
        $category['categories']['page'] = floor($offset/$limit) + 1;
        $category['status'] = $status;
        if (empty($data)) {
            $category['message'] = $this->__('No Category Found.');
        }

        return $category;
    }

    /**
     * Get Category details
     *
     * @param array $categories categories
     *
     * @return array
     */
    public function getCategoryDetailApi($categories)
    {
        $data = array();
        try {
            $collection = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('shop_now', 1)
                ->addAttributeToFilter('is_active', 1)
                ->addAttributeToFilter('entity_id', array('in'=> $categories['catId']))
                ->addAttributeToSelect('*');
            $mediaDir = Mage::getBaseUrl('media');
            $mediaUrl = Mage::getBaseUrl('media');
            $defaultCategoryThumb = (string)Mage::helper('catalog/image')
                ->init(Mage::getModel('catalog/product'), 'image')
                ->resize(600, 315);
            foreach ($collection as $_category) {
                $imagePath = $mediaDir.DS.'catalog'.DS.'category'.DS.$_category->getImage();
                if ($_category->getImage()) {
                    $resizedPath = $mediaDir.DS.'catalog'.DS.'category'.DS.'resizeimage'.DS.
                        $_category->getImage();
                    $this->getResizeImage($imagePath, $resizedPath, 600, 315);
                    $categoryImage = $mediaUrl . 'catalog/category/resizeimage/'.
                        $_category->getImage();
                } else {
                    $categoryImage = $defaultCategoryThumb;
                }

                $thumbPath = $mediaDir.DS.'catalog'.DS.'category'.DS.
                    $_category->getThumbnail();
                if ($_category->getThumbnail()) {
                    $resizedThumbPath = $mediaDir.DS.'catalog'.DS.'category'.DS.
                        'resizeimage'.DS.$_category->getThumbnail();
                    $this->getResizeImage($thumbPath, $resizedThumbPath, 600, 315);
                    $categoryThumb = $mediaUrl.'catalog/category/resizeimage/'. $_category
                            ->getThumbnail();
                } else {
                    $categoryThumb = $defaultCategoryThumb;
                }

                if ($_category->getId()) {
                    $data[] = array(
                        "category_id" => $_category->getId(),
                        "name" => $_category->getName(),
                        "url_key" => $_category->getUrlKey(),
                        "thumbnail" => $categoryThumb,
                        "description" => strip_tags($_category->getDescription()),
                        "image" => $categoryImage,
                        "url_path" => $_category->getUrlPath(),
                    );
                }
            }

            $status = "success";
        }catch(Exception $e){
            $status = "fail";
        }

        $catDetail = array();
        $catDetail['categories']['list'] = $data;
        $catDetail['categories']['item_count'] = count($data);
        $catDetail['categories']['total'] = count($categories['catId']);
        $catDetail['status'] = $status;
        if (empty($data)) {
            $catDetail['message'] = $this->__('No Category Found.');
        }

        return $catDetail;
    }

    /**
     * Get products from category
     *
     * @param array $categories Categories
     * @param int   $offset     Offset
     * @param int   $limit      Limit
     * @param bool  $catalog    Catalog
     *
     * @return array
     *
     * @throws Mage_Core_Exception
     */
    public function getProductListApi($categories, $offset, $limit, $catalog = null)
    {
        $data = array();
        $totalCnt = 0;
        $productData = array();
        $visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );

        $categoryId = $categories['catId'][0];
        if ($categoryId == 0) {
            $categoryId = Mage::app()->getStore()->getRootCategoryId();
        }

        $catagory = Mage::getModel('catalog/category')->load($categoryId);
        if ($catagory->getId()) {
            if ($categoryId == 2 && empty($categories['catId'])) {
                $products = Mage::getResourceModel('catalog/product_collection')
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('status', 1)
                    ->addAttributeToFilter('visibility', $visibility)
                    ->addMinimalPrice()
                    ->setOrder('position', 'ASC');
            } else {
                $products = Mage::getResourceModel('catalog/product_collection')
                    ->addCategoryFilter($catagory)
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('status', 1)
                    ->addAttributeToFilter('visibility', $visibility)
                    ->addMinimalPrice()
                    ->setOrder('position', 'ASC');
            }

            $totalCnt = $products->getSize();
            $this->setLimit($products, $limit, $offset);
            $store = Mage::app()->getStore();
            foreach ($products as $product) {
                $data[] = array(
                    "product_id" => $product->getId(),
                    "sku" => $product->getSku(),
                    "product_type" => $product->getTypeID(),
                    "catId" => $product->getCategoryIds(),
                    "name" => $product->getName(),
                    "description" => substr(strip_tags($product->getDescription()), 0, 255),
                    "short_description" => substr(strip_tags($product->getShortDescription()), 0, 255),
                    "status" => $product->getStatus(),
                    "url_key" => $product->getUrlKey(),
                    "thumbnail" => (string)Mage::helper('catalog/image')
                        ->init($product, 'thumbnail')
                        ->constrainOnly(false)
                        ->keepAspectRatio(true)
                        ->keepFrame(true)->resize(80, 80),
                    "image" => (string)Mage::helper('catalog/image')
                        ->init($product, 'small_image')
                        ->constrainOnly(true)
                        ->keepAspectRatio(true)
                        ->keepFrame(true)->resize(600, 315),
                    "url_path" => $product->getUrlPath(),
                    "currency_code" => $store->getCurrentCurrencyCode(),
                    "currency_symbol" => Mage::app()->getLocale()
                        ->currency($store->getCurrentCurrencyCode())->getSymbol(),
                    "currency_name" => Mage::app()->getLocale()
                        ->currency($store->getCurrentCurrencyCode())->getName(),
                    "price" => number_format($product->getPrice(), 2),
                    "final_price" => number_format($product->getFinalPrice(), 2),
                    "special_price" => number_format($product->getSpecialPrice(), 2),
                    "special_from_date" => $product->getSpecialFromDate(),
                    "special_to_date" => $product->getSpecialToDate(),
                    "minimal_price" => number_format($product->getMinimalPrice(), 2),
                    "cart_url" => "botgento/cart/add/id/" . $product->getId()
                );
            }
        }

        if ($catalog) {
            $productData['list'] = $data;
            $productData['item_count'] = count($data);
            $productData['total'] = !empty($products) ? $totalCnt : 0;
            $productData['page'] = floor($offset/$limit) + 1;
        } else {
            $productData['products']['list'] = $data;
            $productData['products']['item_count'] = count($data);
            $productData['products']['total'] = !empty($products) ? $totalCnt : 0;
            $productData['products']['page'] = floor($offset / $limit) + 1;
        }

        try{
            $status = 'success';
        }catch(Exception $e){
            $status = 'fail';
        }

        $productData['status'] = $status;
        if (empty($data)) {
            $productData['message'] = $this->__('No Product Found.');
        }

        return $productData;
    }

    /**
     * Get product details
     *
     * @param array $products Products
     *
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getProductDetailApi($products)
    {
        $data = array();
        $visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );
        $products = Mage::getModel("catalog/product")->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter("sku", array('in' => $products['prodSkus']))
            ->addAttributeToFilter('visibility', $visibility)
            ->addMinimalPrice();
        $store = Mage::app()->getStore();
        foreach ($products as $product) {
            if ($product->getId()) {
                $data[] = array(
                    "product_id" => $product->getId(),
                    "sku" => $product->getSku(),
                    "product_type" => $product->getTypeId(),
                    "catId" => $product->getCategoryIds(),
                    "name" => $product->getName(),
                    "description" => substr(strip_tags($product->getDescription()), 0, 255),
                    "short_description" => substr(strip_tags($product->getShortDescription()), 0, 255),
                    "status" => $product->getStatus(),
                    "url_key" => $product->getUrlKey(),
                    "thumbnail" => (string)Mage::helper('catalog/image')
                        ->init($product, 'thumbnail')
                        ->constrainOnly(false)
                        ->keepAspectRatio(true)
                        ->keepFrame(true)
                        ->resize(80, 80),
                    "image" => (string)Mage::helper('catalog/image')
                        ->init($product, 'small_image')
                        ->constrainOnly(true)
                        ->keepAspectRatio(true)
                        ->keepFrame(true)
                        ->resize(600, 315),
                    "url_path" => $product->getUrlPath(),
                    "currency_code" => $store->getCurrentCurrencyCode(),
                    "currency_symbol" => Mage::app()->getLocale()
                        ->currency($store->getCurrentCurrencyCode())->getSymbol(),
                    "currency_name" => Mage::app()->getLocale()
                        ->currency($store->getCurrentCurrencyCode())->getName(),
                    "price" => number_format($product->getPrice(), 2),
                    "final_price" => number_format($product->getFinalPrice(), 2),
                    "special_price" => number_format($product->getSpecialPrice(), 2),
                    "special_from_date" => $product->getSpecialFromDate(),
                    "special_to_date" => $product->getSpecialToDate(),
                    "minimal_price" => number_format($product->getMinimalPrice(), 2),
                    "cart_url" => "botgento/cart/add/id/" . $product->getId()
                );
            }
        }

        $productData['products']['list'] = $data;
        try{
            $status = 'success';
        }catch(Exception $e){
            $status = 'fail';
        }

        $productData['status'] = $status;
        if (empty($data)) {
            $productData['message'] = $this->__('No Product Found.');
        }

        return $productData;
    }

    /**
     * Get Categories and sub-categories with products count
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getCatalogDetailApi($options)
    {
        $data = array();
        $offset = $options['offset'];
        $limit = $options['limit'];
        $category = array();
        $visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );
        try {
            if ($options['parentCatId'] == 0) {
                $rootId = Mage::app()->getStore()->getRootCategoryId();
                $categories = Mage::getModel('catalog/category')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addIsActiveFilter()
                    ->addAttributeToFilter('shop_now', 1)
                    ->addAttributeToFilter('level', '2')
                    ->addFieldToFilter('path', array('like'=> "1/$rootId/%"));
                $currCatId = Mage::app()->getStore()->getRootCategoryId();
            } else {
                $categories = Mage::getResourceModel('catalog/category_collection')
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('is_active', 1)
                    ->addAttributeToFilter('shop_now', 1)
                    ->addAttributeToFilter('parent_id', $options['parentCatId']);
                $currCatId = $options['parentCatId'];
            }

            $this->setLimit($categories, $limit, $offset);
            $defaultCategoryThumb = (string)Mage::helper('catalog/image')
                ->init(Mage::getModel('catalog/product'), 'image')
                ->resize(600, 315);
            $mediaDir = Mage::getBaseDir('media');
            $mediaUrl = Mage::getBaseUrl('media');
            foreach ($categories as $item) {
                $imagePath = $mediaDir. DS . 'catalog' . DS . 'category' . DS . $item->getImage();
                if ($item->getImage()) {
                    $resizedPath = $mediaDir.DS.'catalog'.DS.'category'
                        .DS.'resizeimage'.DS.$item->getImage();
                    $this->getResizeImage($imagePath, $resizedPath, 600, 315);
                    $categoryImage = $mediaUrl . 'catalog/category/resizeimage/' . $item->getImage();
                } else {
                    $categoryImage = $defaultCategoryThumb;
                }

                $thumbPath = $mediaDir . DS . 'catalog' . DS . 'category' . DS . $item->getThumbnail();
                if ($item->getThumbnail()) {
                    $resizedThumbPath = $mediaDir.DS.'catalog'.DS.'category'
                        .DS.'resizeimage'.DS.$item->getThumbnail();
                    $this->getResizeImage($thumbPath, $resizedThumbPath, 600, 315);
                    $categoryThumb = $mediaUrl.'catalog/category/resizeimage/'.$item->getThumbnail();
                } else {
                    $categoryThumb = $defaultCategoryThumb;
                }

                $categoryCnt = Mage::getResourceModel('catalog/category_collection')
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('is_active', 1)
                    ->addAttributeToFilter('shop_now', 1)
                    ->addAttributeToFilter('parent_id', $item->getId());

                $catagory = Mage::getModel('catalog/category')->load($item->getId());
                $productCnt = Mage::getResourceModel('catalog/product_collection')
                    ->addCategoryFilter($catagory)
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('status', 1)
                    ->addAttributeToFilter('visibility', $visibility)
                    ->addMinimalPrice();

                $data[] = array(
                    "category_id" => $item->getId(),
                    "name" => $item->getName(),
                    "url_key" => $item->getUrlKey(),
                    "thumbnail" => $categoryThumb,
                    "description" => strip_tags($item->getDescription()),
                    "image" => $categoryImage,
                    "url_path" => $item->getUrlPath(),
                    "sub_category_count" => $categoryCnt->getSize(),
                    "product_count" => $productCnt->getSize()
                );
            }

            $products = array();
            if (empty($data)) {
                $catId = array("catId" => array($options['parentCatId']));
                $products = $this->getProductListApi($catId, $offset, $limit, 1);
            }

            $status = 'success';
        }catch(Exception $e){
            $status = 'fail';
            $category['error'] = $e->getMessage();
        }

        $productModel = array();
        $catagory = Mage::getModel('catalog/category')->load($currCatId);
        if ($catagory->getId()) {
            $productModel = Mage::getResourceModel('catalog/product_collection')
                ->addCategoryFilter($catagory)
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('status', 1)
                ->addAttributeToFilter('visibility', $visibility)
                ->addMinimalPrice();
        }

        $category['products_in_current_category'] = !empty($productModel) ? $productModel->getSize() : 0;
        $category['categories']['list'] = $data;
        $category['categories']['item_count'] = count($data);
        $category['categories']['total'] = !empty($categories) ? $categories->getSize() : 0;
        $category['categories']['page'] = floor($offset/$limit) + 1;
        $category['status'] = $status;
        if (empty($data)) {
            $category['categories'] = array();
        }

        $category['products'] = $products;
        return $category;
    }

    /**
     * Ping botgento
     *
     * @return array
     */
    public function getPingApi()
    {
        try{
            $response = array("status"=>"success","code"=>200);
        }catch(Exception $e){
            $response = array(
                "status"=>"fail",
                "code"=>200,
                "message"=> $e->getMessage()
            );
        }

        return $response;
    }

    /**
     * Get System configuration details and save
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getConfigDetailSaveApi($options)
    {
        $websiteId = Mage::app()->getStore()->getWebsiteId();
        /**
         * Config model
         *
         * @var Mage_Core_Model_Config $config Config model
         */
        $config = Mage::getModel('core/config');
        if (!empty($options)) {
            $websiteApiKey = $this->getWebsiteApiKey();
            if (empty($websiteApiKey)) {
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_ENABLE,
                    1, 'websites', $websiteId
                );
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_KEY_VALID,
                    1, 'websites', $websiteId
                );
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_CHECKBOX_ENABLE,
                    1, 'websites', $websiteId
                );
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_FACEBOOK_BUTTON,
                    1, 'websites', $websiteId
                );
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_SEND_ORDER_DETAIL,
                    1, 'websites', $websiteId
                );
                $config->saveConfig(
                    self::XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL,
                    1, 'websites', $websiteId
                );
            }

            $config->saveConfig(
                self::XML_PATH_BOTGENTO_API_KEY,
                $options['website_api_token'], 'websites', $websiteId
            );
            $config->saveConfig(
                self::XML_PATH_BOTGENTO_WEBSITE_HASH,
                $options['website_hash'], 'websites', $websiteId
            );
            $config->saveConfig(
                self::XML_PATH_BOTGENTO_FBPAGE_ID,
                $options['fb_page_id'], 'websites', $websiteId
            );
            $config->saveConfig(
                self::XML_PATH_BOTGENTO_MESSENGERAPP_ID,
                $options['fb_app_id'], 'websites', $websiteId
            );
            $data = array(
                'status'=>'success',
                'code'=> 200
            );
        } else {
            $config->saveConfig(
                self::XML_PATH_BOTGENTO_KEY_VALID,
                0, 'websites', $websiteId
            );
            $data = array(
                'status'=> 'fail',
                'code'=> 200,
                'message'=> 'You have not pass any options.'
            );
        }

        return $data;
    }

    /**
     * Get customer latest orders API
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getOrderListApi($options)
    {
        try{
            $data = array();
            $websiteId = Mage::app()->getStore()->getWebsiteId();
            /**
             * @var  $website Mage_Core_Model_Website
             */
            $website = Mage::getModel('core/website')->load($websiteId);
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                foreach ($stores as $store) {
                    $storeId[] = $store->getId();
                }
            }

            $orderCollection = Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('customer_email', $options['customer_email']);
            $orderCollection->setOrder('created_at', 'DESC');
            $orderCollection->addFieldToFilter('store_id', array("in" => $storeId));
            $this->setLimit($orderCollection, 5, 0);
            foreach ($orderCollection as $_order) {
                $items = $_order->getAllVisibleItems();
                $image = "";
                $item = end($items);
                    $product = Mage::getModel('catalog/product')
                        ->load($item->getProductId());
                    $image = (string)Mage::helper('catalog/image')
                        ->init($product, 'small_image')
                        ->constrainOnly(true)
                        ->keepAspectRatio(true)
                        ->keepFrame(true)
                        ->resize(600, 315);

                $data[] = array(
                    "order_number" => $_order->getIncrementId(),
                    "order_date" => $_order->getCreatedAtStoreDate()
                        ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT),
                    "billing_name" => $_order->getBillingAddress()->getName(),
                    "order_amount" => Mage::helper('core')->currency($_order->getGrandTotal(), true, false),
                    "status" => $_order->getStatus(),
                    "order_image" => $image
                );
            }

            $orders['orders'] = $data;
            if (empty($data)) {
                $orders['message'] = $this->__('No Order Found.');
            }

            $orders['status'] = 'success';
        }catch(Exception $e){
            $orders['error'] = $e->getMessage();
            $orders['status'] = 'fail';
        }

        return $orders;
    }

    /**
     * Get order detail API
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getOrderDetailApi($options)
    {
        $orderData = array();
        try{
            $orderId = $options['order_number'];
            $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
            if ($order->getId()) {
                $_shippingAddress = $order->getShippingAddress();
                $ruleName = "";
                $couponcode = "";
                foreach (explode(",", $order->getAppliedRuleIds()) as $ruleId) {
                    $rule = Mage::getModel('salesrule/rule')->load($ruleId);
                    $ruleName = $rule->getName();
                    $couponcode = $rule->getCouponCode();
                }

                $items = $order->getAllVisibleItems();
                $orderUrl = Mage::getUrl("sales/order/view/");
                foreach ($items as $item) {
                    $product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $elements[] = array(
                        "title" => $item->getName(),
                        "subtitle" => "",
                        "quantity" => (int)$item->getQtyOrdered(),
                        "price" => (float)$item->getPrice(),
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
                    'order_url' => $orderUrl . 'order_id/' . $order->getId(),
                    'timestamp' => strtotime($order->getCreatedAtStoreDate()),
                    'address' => array(
                        "street_1" => $order->getBillingAddress()->getStreet(1),
                        "street_2" => $order->getBillingAddress()->getStreet(2),
                        "city" => $_shippingAddress->getCity(),
                        "postal_code" => $_shippingAddress->getPostcode(),
                        "state" => $_shippingAddress->getRegion(),
                        "country" => $_shippingAddress->getCountry()
                    ),
                    "summary" => array(
                        "subtotal" => (float)$order->getSubtotal(),
                        "shipping_cost" => (float)$order->getShippingAmount(),
                        "total_tax" => (float)$order->getTaxAmount(),
                        "total_cost" => (float)$order->getGrandTotal()
                    ),
                    'elements' => $elements
                );

                if ($ruleName) {
                    $data['adjustments'] = array(
                        array(
                            "name" => $ruleName,
                            "code" => $couponcode,
                            "amount" => abs($order->getDiscountAmount())
                        )
                    );
                }

                $orderData['payload'] = Mage::helper('core')->jsonEncode($data);
                $orderData['status'] = 'success';
            } else {
                $orderData['message'] = $this->__('No data found. Please check the order number');
                $orderData['status'] = 'success';
            }
        }catch(Exception $e){
            $orderData['error'] = $e->getMessage();
            $orderData['status'] = 'fail';
        }

        return $orderData;
    }

    /**
     * Get wishlist items API
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getWhishlistItemsApi($options)
    {
        $wishlistItems = array();
        try{
            $data = array();
            $email = $options['customer_email'];
            $limit = $options['limit'];
            $offset = $options['offset'];
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByEmail($email);
            $wishList = Mage::getSingleton('wishlist/wishlist')
                ->loadByCustomer($customer);
            $wishListItemCollection = $wishList->getItemCollection();
            $this->setLimit($wishListItemCollection, $limit, $offset);
            $totalCnt = $wishListItemCollection->getSize();
            $store = Mage::app()->getStore();
            $currencyCode = $store->getCurrentCurrencyCode();
            $currencySym = Mage::app()->getLocale()
                ->currency($store->getCurrentCurrencyCode())->getSymbol();
            $currencyName = Mage::app()->getLocale()
                ->currency($store->getCurrentCurrencyCode())->getName();
            foreach ($wishListItemCollection as $item) {
                /** @var Mage_Catalog_Model_Product $product */
                $product = $item->getProduct();
                if ($product->getId()) {
                    $data[] = array(
                        "product_id" => $product->getId(),
                        "sku" => $product->getSku(),
                        "product_type" => $product->getTypeID(),
                        "catId" => $product->getCategoryIds(),
                        "name" => $product->getName(),
                        "description" => substr(strip_tags($product->getDescription()), 0, 255),
                        "short_description" => substr(strip_tags($product->getShortDescription()), 0, 255),
                        "status" => $product->getStatus(),
                        "url_key" => $product->getUrlKey(),
                        "thumbnail" => (string)Mage::helper('catalog/image')
                            ->init($product, 'thumbnail')
                            ->constrainOnly(false)
                            ->keepAspectRatio(true)
                            ->keepFrame(true)
                            ->resize(80, 80),
                        "image" => (string)Mage::helper('catalog/image')
                            ->init($product, 'small_image')
                            ->constrainOnly(true)
                            ->keepAspectRatio(true)
                            ->keepFrame(true)
                            ->resize(600, 315),
                        "url_path" => $product->getUrlPath(),
                        "currency_code" => $currencyCode,
                        "currency_symbol" => $currencySym,
                        "currency_name" => $currencyName,
                        "price" => $product->getPrice(),
                        "final_price" => $product->getFinalPrice(),
                        "special_price" => $product->getSpecialPrice(),
                        "special_from_date" => $product->getSpecialFromDate(),
                        "special_to_date" => $product->getSpecialToDate(),
                        "minimal_price" => $product->getMinimalPrice(),
                        "cart_url" => "botgento/cart/add/id/".$product->getId()
                    );
                }
            }

            $wishlistItems['wishlist']['items'] = $data;
            $wishlistItems['status'] = 'success';
            if (empty($data)) {
                $productData['message'] = $this->__('No Product Found.');
            }

            $wishlistItems['wishlist']['item_count'] = count($data);
            $wishlistItems['wishlist']['total'] = !empty($wishListItemCollection) ? $totalCnt : 0;
            $wishlistItems['wishlist']['page'] = floor($offset / $limit) + 1;
        }catch(Exception $e){
            $wishlistItems['error'] = $e->getMessage();
            $wishlistItems['status'] = "fail";
        }

        return $wishlistItems;
    }

    /**
     * Purge website configuration data on request
     *
     * @return array
     */
    public function purgeBotgentoData()
    {
        $data = array();
        try {
            $websiteId = Mage::app()->getStore()->getWebsiteId();
            /**
             * @var  $object Mage_Core_Model_Config
             */
            $object = Mage::getModel('core/config');
            $object->deleteConfig(self::XML_PATH_BOTGENTO_KEY_VALID, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_API_KEY, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_WEBSITE_HASH, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_FBPAGE_ID, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_MESSENGERAPP_ID, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_ENABLE, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_SEND_ORDER_DETAIL, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_CHECKBOX_ENABLE, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_FACEBOOK_BUTTON, 'websites', $websiteId);
            $object->deleteConfig(self::XML_PATH_BOTGENTO_ORDER_SEND_TIME, 'websites', $websiteId);

            $collection = Mage::getModel('botgento/apidata')
                ->getCollection()
                ->addFieldToFilter("website_id", $websiteId);
            foreach ($collection as $item) {
                $item->delete();
            }

            $customers = Mage::getModel('customer/customer')
                ->getCollection()
                ->addFieldToFilter("website_id", $websiteId);
            $botgentoUser = Mage::getModel('botgento/user')
                ->getCollection()
                ->addFieldToFilter("customer_id", array(0,$customers->getColumnValues('entity_id')));
            foreach ($botgentoUser as $_botgentoUser) {
                $_botgentoUser->delete();
            }

            $data['status'] = "sucesss";
        }catch(Exception $e){
            $data['error'] = $e->getMessage();
            $data['status'] = "fail";
        }

        return $data;
    }

    /**
     * Send Table Data to botgento on request
     *
     * @param $options
     * @return array
     */
    public function sendTableDataToBotgento($options)
    {
        $data = array();
        $websiteId = Mage::app()->getStore()->getWebsiteId();
        $limit = $options['limit'];
        $offset = $options['offset'];
        if ($options['table'] == "config") {
            $data[self::XML_PATH_BOTGENTO_KEY_VALID] = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_KEY_VALID);
            $data[self::XML_PATH_BOTGENTO_API_KEY] = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_API_KEY);
            $data[self::XML_PATH_BOTGENTO_WEBSITE_HASH] = Mage::getStoreConfig(
                self::XML_PATH_BOTGENTO_WEBSITE_HASH
            );
            $data[self::XML_PATH_BOTGENTO_FBPAGE_ID] = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_FBPAGE_ID);
            $data[self::XML_PATH_BOTGENTO_MESSENGERAPP_ID]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_MESSENGERAPP_ID);
            $data[self::XML_PATH_BOTGENTO_ENABLE] = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_ENABLE);
            $data[self::XML_PATH_BOTGENTO_SEND_ORDER_DETAIL]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_SEND_ORDER_DETAIL);
            $data[self::XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_SEND_SHIPMENT_DETAIL);
            $data[self::XML_PATH_BOTGENTO_CHECKBOX_ENABLE]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_CHECKBOX_ENABLE);
            $data[self::XML_PATH_BOTGENTO_FACEBOOK_BUTTON]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_FACEBOOK_BUTTON);
            $data[self::XML_PATH_BOTGENTO_ORDER_SEND_TIME]
                = Mage::getStoreConfig(self::XML_PATH_BOTGENTO_ORDER_SEND_TIME);
        } elseif ($options['table'] == "users") {
            $data = Mage::getModel("botgento/user")
                ->getCollection()
                ->addFieldToFilter("website_id", $websiteId);
            $this->setLimit($data, $limit, $offset);
        } elseif ($options['table'] == "orders") {
            $data = Mage::getModel("botgento/apidata")
                ->getCollection()
                ->addFieldToFilter("website_id", $websiteId);
            $this->setLimit($data, $limit, $offset);
        } elseif ($options['table'] == "sync_attributes") {
            $data = Mage::getModel('botgento/syncattributes')
                ->getCollection()
                ->addFieldToFilter('type', $options['type'])
                ->getLastItem();
        }

        return $data;
    }

    /**
     * Save attribute data to table
     *
     * @param $options
     * @return array
     */
    public function saveAttributeDataToTable($options)
    {
        $allowedType = array('abandoned_cart','product_in_stock','orders');

        if (in_array($options['type'], $allowedType)) {
            $atributesJsonData = Mage::helper('core')->jsonEncode($options['attributes_json']);
            $collection = Mage::getModel('botgento/syncattributes')
                ->getCollection()
                ->addFieldToFilter("type", $options['type']);

            if (count($collection) == 0) {
                $model = Mage::getModel('botgento/syncattributes');
                $model->setType($options['type']);
                $model->setAttributesJson($atributesJsonData);
                $model->setCreatedAt(now());
                $model->save();
            } else {
                $collection = $collection->getFirstItem();
                $model = Mage::getModel('botgento/syncattributes')->load($collection->getId());
                $model->setAttributesJson($atributesJsonData);
                $model->setUpdatedAt(now());
                $model->save();
            }

            $response = array(
                'status'=>'Success'
            );
        } else {
            $response = array(
                'status'=>'Success',
                'message'=>'There is no matching Type found for sync attributes.'
            );
        }

        return $response;

    }

    /**
     * Get order is placed or not from quote id
     *
     * @param $options
     * @return array
     */
    public function getOrderStatusFromQuote($options) 
    {
        $quoteId = $options['quote_id'];
        $orderCollection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('quote_id', $quoteId);

        if ($orderCollection->getSize() > 0) {
            $response = array(
                'total_orders'=>'1',
                'status'=>'success'
            );
        } else {
            $response = array(
                'total_orders'=>'0',
                'status'=>'success'
            );
        }

        return $response;
    }

    /**
     * Check customer already register for facebook checkbox plugin
     *
     * @return bool
     */
    public function checkCustomerNotExist()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            $customerCol = Mage::getModel('botgento/user')->getCollection()
                        ->addFieldToFilter('email', $customerData->getEmail())
                        ->addFieldToFilter('customer_id', array("neq" => 0));
            if ($customerCol->getSize()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Resize category images
     *
     * @param $imagePath
     * @param $resizePath
     * @param $width
     * @param $height
     */
    public function getResizeImage($imagePath,$resizePath, $width, $height)
    {
        if (file_exists($imagePath)) {
            $image = new Varien_Image($imagePath);
            $image->constrainOnly(true);
            $image->keepAspectRatio(true);
            $image->keepFrame(true);
            $image->backgroundColor(array(255,255,255));
            $image->resize($width, $height);
            $image->save($resizePath);
        }
    }

    /**
     * Send a HTTP Post request
     *
     * @param $url
     * @param $auth
     * @param $data
     * @return string
     */
    public function getCurlData($url, $auth, $data)
    {
        $curl = new Varien_Http_Adapter_Curl();
        $curl->setConfig(array('header'=> false));
        $curl->write(Zend_Http_Client::POST, $url, '1.1', $auth, $data);
        $response = $curl->read();
        if ($curl->getError()) {
            $errorMsg = $curl->getError();
        }

        $curl->close();

        try {
            $content = Mage::helper('core')->jsonDecode($response, true);
        }
        catch (Exception $e) {
            $content = $e->getMessage();
        }

        return $content;
    }

    /**
     * Set limit
     *
     * @param object $collection collection
     * @param int    $limit      limit
     * @param int    $offset     offset
     *
     * @return void
     */
    protected function setLimit($collection, $limit, $offset)
    {
        $collection->getSelect()->limit($limit, $offset);
    }

    /**
     * Return Botgento API Url
     *
     * @param $params
     * @return string
     */
    public function getBotgentoApiUrl($params)
    {
        return $this->getBotgentoUrl()."fb/".$params;
    }

    /**
     * Return Botgento API Url
     *
     * @param $params
     * @return string
     */
    public function getBotgentoUrl()
    {
        return "https://api.botgento.com/";
    }

    /**
     * Get customer email from customer session
     *
     * @return string|null
     */
    public function getCustomerEmail() 
    {
        $customerEmail = '';
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerEmail = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
        }

        return $customerEmail;
    }

    /**
     * Get session id
     *
     * @return string
     */
    public function getSessionId() 
    {
       return Mage::getSingleton('core/session')->getEncryptedSessionId();
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid() 
    {
        $cookie = Mage::getModel('core/cookie')->get(self::BGC_UUID_COOKIE_NAME);
        if (!empty($cookie)) {
            return $cookie;
        } else {
            $uuid = md5($this->getSessionId());
            Mage::getModel('core/cookie')
                ->set(self::BGC_UUID_COOKIE_NAME, $uuid, 86400*24, null, null, null, false);
        }

        return $uuid;
    }

    /**
     * Get current uri
     *
     * @return string|null
     */
    public function getCurrentUri() 
    {
        $baseUrl = Mage::getBaseUrl();
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        return str_replace($baseUrl, '', $currentUrl);
    }

    /**
     * Get full action name
     *
     * @return string
     */
    public function getFullActionName() 
    {
        $routeName = Mage::app()->getRequest()->getRouteName();
        $controllerName = Mage::app()->getRequest()->getControllerName();
        $actionName = Mage::app()->getRequest()->getActionName();

        return $routeName.'_'.$controllerName.'_'.$actionName;
    }

    /**
     * Convert price from base currency to quote currency
     *
     * @param $price
     * @param $baseCurrencyCode
     * @param $quoteCurrencyCode
     * @return string
     */
    public function convertPriceFromCurrencyCode($price, $baseCurrencyCode, $quoteCurrencyCode) 
    {

        if ($baseCurrencyCode == $quoteCurrencyCode) {
            return $price;
        }

        return Mage::helper('directory')->currencyConvert($price, $baseCurrencyCode, $quoteCurrencyCode);
    }

    /**
     * Get Product Image url
     *
     * @param $product
     * @param $imageType
     * @return string
     */
    public function getProductImageUrl($product, $imageType) 
    {
        if ($imageType == 'thumbnail') {
            $imagewidth = 80;
            $imageHeight = 80;
        } else {
            $imagewidth = 600;
            $imageHeight = 315;
        }

        $imageUrl = (string)Mage::helper('catalog/image')
            ->init($product, $imageType)
            ->constrainOnly(false)
            ->keepAspectRatio(true)
            ->keepFrame(true)
            ->resize($imagewidth, $imageHeight);
        return $imageUrl;

    }

    /**
     * Get Abandon Cart Data for syc with botgento
     *
     * @param $storesArray
     * @return array
     */
    public function getAbandonedCartData($storesArray) 
    {
        $syncLogModel = Mage::getModel('botgento/synclog')
            ->getCollection()
            ->addFieldToFilter('type', 'abandoned_cart')
            ->addFieldToFilter('status', 'success');

        if ($syncLogModel->getSize()) {
            $syncLogModel = $syncLogModel->getLastItem();
            $lastSnycDateTime = date('Y-m-d H:i:s', strtotime($syncLogModel->getCreatedAt()));
        }

        $quoteCollection = Mage::getModel('sales/quote')
            ->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('store_id', array("in" => $storesArray));

        if (isset($lastSnycDateTime)) {
            $quoteCollection->addFieldToFilter('updated_at', array('from'=>$lastSnycDateTime));
        }

        $data = array();
        $cartItemsArray = array();
        $billingAddressItemsArray = array();
        $shippingAddressItemsArray = array();

        $attributeJson = '{"0":"entity_id","1":"created_at","2":"updated_at","3":"is_virtual","4":"items_count","5":"items_qty","6":"store_currency_code","7":"quote_currency_code","8":"base_currency_code","9":"base_grand_total","10":"customer_email","11":"coupon_code","12":"base_subtotal","13":"base_subtotal_with_discount","cart_items":["product_id","created_at","updated_at","sku","name","short_description","qty","price","final_price","discount_percent","discount_amount","row_total","product_type","thumbnail","image","currency_code","currency_symbol"],"address":{"billing":["street","city","region","postcode","country_id"],"shipping":["street","city","region","postcode","country_id"]}}';

        $attributeArray = Mage::helper('core')->jsonDecode($attributeJson);

        if (isset($attributeArray['cart_items'])) {
            $cartItemsArray = $attributeArray['cart_items'];
        }

        if (isset($attributeArray['address']['billing'])) {
            $billingAddressItemsArray = $attributeArray['address']['billing'];
        }

        if (isset($attributeArray['address']['shipping'])) {
            $shippingAddressItemsArray = $attributeArray['address']['shipping'];
        }

        unset($attributeArray['cart_items']);
        unset($attributeArray['address']);

        $sncAttributeCollection = Mage::getModel('botgento/syncattributes')
            ->getCollection()
            ->addFieldToFilter('type', 'abandoned_cart');
        if ($sncAttributeCollection->getSize()) {
            $syncCartItemsArray = array();
            $syncBillingAddressItemsArray = array();
            $syncShippingAddressItemsArray = array();

            $sncAttributeCollection = $sncAttributeCollection->getLastItem();
            $snycAttributeJson = $sncAttributeCollection->getAttributesJson();

            $syncAttributeArray = Mage::helper('core')->jsonDecode($snycAttributeJson);

            if (isset($syncAttributeArray['cart_items'])) {
                $syncCartItemsArray = $syncAttributeArray['cart_items'];
            }

            if (isset($syncAttributeArray['address']['billing'])) {
                $syncBillingAddressItemsArray = $syncAttributeArray['address']['billing'];
            }

            if (isset($syncAttributeArray['address']['shipping'])) {
                $syncShippingAddressItemsArray = $syncAttributeArray['address']['shipping'];
            }

            unset($syncAttributeArray['cart_items']);
            unset($syncAttributeArray['address']);

            if (!empty($syncAttributeArray) && is_array($syncAttributeArray)) {
                $attributeArray = array_unique(array_merge($attributeArray, $syncAttributeArray));
            }

            if (!empty($syncCartItemsArray) && is_array($syncCartItemsArray)) {
                $cartItemsArray = array_unique(array_merge($cartItemsArray, $syncCartItemsArray));
            }

            if (!empty($syncBillingAddressItemsArray) && is_array($syncBillingAddressItemsArray)) {
                $billingAddressItemsArray = array_unique(
                    array_merge($billingAddressItemsArray, $syncBillingAddressItemsArray)
                );
            }

            if (!empty($syncShippingAddressItemsArray) && is_array($syncShippingAddressItemsArray)) {
                $shippingAddressItemsArray = array_unique(
                    array_merge($shippingAddressItemsArray, $syncShippingAddressItemsArray)
                );
            }
        }

        foreach ($quoteCollection as $quote) {
            $baseCurrencyCode = $quote->getBaseCurrencyCode();

            $subscriberMappingCollection = Mage::getModel('botgento/subscribermapping')
                ->getCollection()
                ->addFieldToFilter("quote_id", $quote->getId())
                ->getLastItem();

            if ($subscriberMappingCollection->hasData() && $subscriberMappingCollection->getIsButtonPress() == 1) {
                foreach ($attributeArray as $value) {
                    $tempData[$value] = $quote->getData($value);
                }

                $tempData['bgc_uuid'] = $subscriberMappingCollection->getUuid();

                $itemCollection = $quote->getItemsCollection();
                $itemCollection->addFieldToFilter('parent_item_id', array('null' => true));

                foreach ($itemCollection as $item) {
                    $product = Mage::getModel("catalog/product")->load($item->getProductId());

                    $productData = array(
                        "product_id" => $item->getProductId(),
                        "created_at" => $item->getCreatedAt(),
                        "updated_at" => $item->getUpdatedAt(),
                        "sku" => $item->getSku(),
                        "name" => $item->getName(),
                        "short_description" => substr(strip_tags($product->getShortDescription()), 0, 255),
                        "qty" => $item->getQty(),
                        "price" => number_format($item->getBasePrice(), 2),
                        "final_price" => number_format($product->getFinalPrice(), 2),
                        "discount_percent" => number_format($item->getDiscountPercent(), 2),
                        "discount_amount" => number_format($item->getBaseDiscountAmount(), 2),
                        "row_total" => number_format($item->getBaseRowTotal(), 2),
                        "product_type" => $item->getProductType(),
                        "thumbnail" => $this->getProductImageUrl($product, 'thumbnail'),
                        "image" => $this->getProductImageUrl($product, 'small_image'),
                        "url_path" => $product->getUrlPath(),
                        "currency_code" => $baseCurrencyCode,
                        "currency_symbol" => Mage::app()->getLocale()
                            ->currency($baseCurrencyCode)->getSymbol(),
                    );

                    $extraProductAttributes = array_diff($cartItemsArray, array_keys($productData));

                    foreach ($extraProductAttributes as $extraAttribute) {
                        if ($item->hasData($extraAttribute) && ($item->getData($extraAttribute)) != null) {
                            $productData[$extraAttribute] = $item->getData($extraAttribute);
                        } else {
                            $productData[$extraAttribute] = $product->getData($extraAttribute);
                        }
                    }

                    $tempData['cart_item'][] = $productData;
                    unset($productData);
                }

                foreach ($billingAddressItemsArray as $value) {
                    $tempData['address']['billing'][$value] = $quote->getBillingAddress()->getData($value);
                }

                foreach ($shippingAddressItemsArray as $value) {
                    $tempData['address']['shipping'][$value] = $quote->getShippingAddress()->getData($value);
                }

                $data[] = $tempData;
                unset($tempData);
            }
        }

        return $data;
    }


    /**
     * Get back in stock alert data
     *
     * @param $website
     * @return array
     */
    public function getInStockAlertData($website) 
    {

        $websiteId = $website->getId();

        $data = array();

        $inStockAlertCollection = Mage::getResourceModel('botgento/instockalert_collection')
            ->addFieldToFilter('website_id', $websiteId)
            ->addFieldToFilter('is_notification_sent', 0)
            ->addFieldToSelect('product_id');

        if ($inStockAlertCollection->getSize()) {
            $inStockAlertCollection->getSelect()
                ->group('product_id');

            $store = $website->getDefaultStore();
            $currencyCode = $store->getCurrentCurrencyCode();
            $currencySym = Mage::app()->getLocale()
                ->currency($store->getCurrentCurrencyCode())->getSymbol();
            $currencyName = Mage::app()->getLocale()
                ->currency($store->getCurrentCurrencyCode())->getName();


            foreach ($inStockAlertCollection as $inStockAlert) {
                $product = Mage::getModel('catalog/product')
                    ->setStoreId($website->getDefaultStore()->getId())
                    ->load($inStockAlert->getProductId());

                if ($product->isSalable()) {
                    $tempData = array();

                    $uuidInStockAlertCollection = Mage::getResourceModel('botgento/instockalert_collection')
                        ->addFieldToFilter('website_id', $websiteId)
                        ->addFieldToFilter('product_id', $inStockAlert->getProductId())
                        ->addFieldToFilter('is_notification_sent', 0)
                        ->addFieldToSelect('uuid')
                        ->addFieldToSelect('id');

                    $uuidArray = array();
                    $instockALertIds = array();
                    foreach ($uuidInStockAlertCollection as $uuidInStockAlertData) {
                        $uuidArray[] = $uuidInStockAlertData->getUuid();
                        $instockALertIds[] = $uuidInStockAlertData->getId();
                    }

                    $tempData['bgc_uuid'] = $uuidArray;
                    $tempData['instock_ids'] = $instockALertIds;
                    unset($uuidArray);
                    unset($instockALertIds);

                    $tempData['product'] = array(
                        "product_id" => $product->getId(),
                        "sku" => $product->getSku(),
                        "product_type" => $product->getTypeID(),
                        "catId" => $product->getCategoryIds(),
                        "name" => $product->getName(),
                        "description" => substr(strip_tags($product->getDescription()), 0, 255),
                        "short_description" => substr(strip_tags($product->getShortDescription()), 0, 255),
                        "status" => $product->getStatus(),
                        "url_key" => $product->getUrlKey(),
                        "thumbnail" => (string)Mage::helper('catalog/image')
                            ->init($product, 'thumbnail')
                            ->constrainOnly(false)
                            ->keepAspectRatio(true)
                            ->keepFrame(true)
                            ->resize(80, 80),
                        "image" => (string)Mage::helper('catalog/image')
                            ->init($product, 'small_image')
                            ->constrainOnly(true)
                            ->keepAspectRatio(true)
                            ->keepFrame(true)
                            ->resize(600, 315),
                        "url_path" => $product->getUrlPath(),
                        "currency_code" => $currencyCode,
                        "currency_symbol" => $currencySym,
                        "currency_name" => $currencyName,
                        "price" => $product->getPrice(),
                        "final_price" => $product->getFinalPrice(),
                        "special_price" => $product->getSpecialPrice(),
                        "special_from_date" => $product->getSpecialFromDate(),
                        "special_to_date" => $product->getSpecialToDate(),
                        "minimal_price" => $product->getMinimalPrice(),
                        "cart_url" => "botgento/cart/add/id/".$product->getId()
                    );

                    $data[] = $tempData;
                    unset($tempData);
                }
            }
        }

        return $data;

    }

    /**
     * Generate bgc value
     *
     * @param $pageTitle
     * @return string
     */
    public function genBGCValue($pageTitle)
    {
        $customerEmail = $this->getCustomerEmail();

        $uuid = $this->getUuid();

        $currentUri = $this->getCurrentUri();

        $curentPageTitle = '';
        $curentPageTitle = $pageTitle;
        if (!empty($curentPageTitle)) {
            $curentPageTitle = str_replace(
                ' ',
                '-',
                str_replace(' - ', ' ', strtolower($curentPageTitle))
            );
        }

        $fullActionName = $this->getFullActionName();
        $data = array(
            'email'=> $customerEmail,
            'bgc_uuid' => $uuid,
            'uri'=> $currentUri,
            'page'=> $curentPageTitle,
            'page_type'=> $fullActionName
        );

        $encryptionKey = $this->getWebsiteApiKey();
        $output = false;
        $encryptMethod = "AES-256-CBC";
        $secretIv = $this->getWebsiteHash();

        $key = hash('sha256', $encryptionKey);
        $iv = substr(hash('sha256', $secretIv), 0, 16);

        return openssl_encrypt(json_encode($data), $encryptMethod, $key, 0, $iv);
    }
}
