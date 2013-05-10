<?php
/**
 * Technooze_Tgeneral extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Tgeneral
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 * @category Technooze
 * @package  Technooze_Tgeneral
 * @module   Tgeneral
 * @author   Damodar Bashyal (enjoygame @ hotmail.com)
 */
class Technooze_Tgeneral_Helper_Catalog extends Mage_Core_Helper_Abstract
{
    /**
     * @var array
     */
    private $_data = array();
    /**
     * @var bool
     */
    private $_fromCurrentCategory = false;
    /**
     * @var int
     */
    private $_limit = 5;
    /**
     * @var int
     */
    private $_category = 0;
    /**
     * @var int
     */
    private $_interval = 0;
    /**
     * @var int
     */
    private $_storeId = 0;
    /**
     * @var string
     */
    private $_from = '';
    /**
     * @var string
     */
    private $_to = '';
    /**
     * @var array
     */
    private $_attributesToFilter = array();

    /**
     *
     */
    public function __construct(){
        $this->_storeId = Mage::app()->getStore()->getId();
    }

    /**
     * @param array $attributesToFilter
     */
    public function addAttributeToFilter($key='', $value='')
    {
        $this->_attributesToFilter[$key] = $value;
    }

    /**
     * @return array
     */
    public function getAttributesToFilter()
    {
        return $this->_attributesToFilter;
    }

    /**
     * @param $from
     */
    public function setFrom($from)
    {
        $this->_from = $from;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->_from;
    }

    /**
     * @param $to
     */
    public function setTo($to)
    {
        $this->_to = $to;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->_to;
    }

    /**
     * @param $fromCurrentCategory
     */
    public function setFromCurrentCategory($fromCurrentCategory)
    {
        $this->_fromCurrentCategory = $fromCurrentCategory;
    }

    /**
     * @return bool
     */
    public function getFromCurrentCategory()
    {
        return $this->_fromCurrentCategory;
    }

    /**
     * @param $limit
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * @param int $interval
     */
    public function setInterval($interval)
    {
        $this->_interval = $interval;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->_interval;
    }

    /**
     * @param int $storeId
     */
    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->_storeId;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        // check if category is defined
        if(!empty($this->_category)){
            // check if it's an integer
            if(is_int($this->_category)){
                $this->_category = Mage::getModel('catalog/category')->load($this->_category);
            }
            // more conditions if required
        } /*else {
            // if category is not defined, then set it as current category
            $this->_category = $this->getCurrentCategory();
        }*/
        return $this->_category;
    }

    /**
     * @return Mage_Core_Model_Abstract|mixed|object
     */
    public function getCurrentCategory()
    {
        $current_category = Mage::registry('current_category');
        if(!is_object($current_category))
        {
            $current_product = Mage::registry('current_product');
            if(is_object($current_product))
            {
                $categories = $current_product->load($current_product->getId())->getCategoryIds();
                if (is_array($categories) and count($categories))
                {
                    $current_category = Mage::getModel('catalog/category')->load($categories[0]);
                }
            }
        }
        return $current_category;
    }

    /**
     * @param string $type (view or order.qty or order.count)
     * @return mixed
     */
    public function getPopularProducts($type='view'){
         // Get most viewed product collection
        $products = Mage::getResourceModel('reports/product_collection')
            ->addAttributeToSelect('*')
            ->setStoreId($this->getStoreId())
            ->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getLimit());

        if($type == 'order.count'){
            // get from only time duration if defined
            if($this->getFrom() && $this->getTo()){
                $products->addOrdersCount($this->getFrom(), $this->getTo());
            } else {
                $products->addOrdersCount();
            }
        } elseif($type == 'order.qty'){
            // get from only time duration if defined
            if($this->getFrom() && $this->getTo()){
                $products->addOrderedQty($this->getFrom(), $this->getTo());
            } else {
                $products->addOrderedQty();
            }
        } else {
            // get from only time duration if defined
            if($this->getFrom() && $this->getTo()){
                $products->addViewsCount($this->getFrom(), $this->getTo());
            } else {
                $products->addViewsCount();
            }
        }

        // get from current category if set to true and is defined
        if($this->getFromCurrentCategory() && $this->getCurrentCategory()){
            $products->addCategoryFilter($this->getCurrentCategory());
        }
        // if particular category is defined then get products from that category only
        else if($this->getCategory()){
            $products->addCategoryFilter($this->getCategory());
        }

        // if you want to filter products by attribute
        $attributes = $this->getAttributesToFilter();
        if(!empty($attributes)){
            foreach($attributes as $k => $v){
                $products->addAttributeToFilter($k, $v);
            }
        }

        Mage::getSingleton('catalog/product_status')
                ->addVisibleFilterToCollection($products);

        Mage::getSingleton('catalog/product_visibility')
                ->addVisibleInCatalogFilterToCollection($products);

        return $products;
    }

    public function getProductUrl(Mage_Catalog_Model_Product $_product = null){
        if(!$_product) return '';

        // force display deepest child category as request path
        $categories = $_product->getCategoryCollection();
        $deepCatId = 0;
        $path = '';
        $product_path = false;
        foreach ($categories as $category) {
            $id = $category->getId();
            if(in_array($id, array('15','146'))){
                // skip home(15) and special(146) categories
                continue;
            }
            // look for the deepest path and save
            if(substr_count($category->getData('path'), '/') > substr_count($path, '/')){
                $path = $category->getData('path');
                $deepCatId = $id;
            }
        }
        // load category
        $category = Mage::getModel('catalog/category')->load($deepCatId);

        // remove .html from category url_path
        $category_path = str_replace('.html', '',  $category->getData('url_path'));

        // get product url path if set
        $product_url_path = $_product->getData('url_path');

        // get product request path if set
        $product_request_path = $_product->getData('request_path');

        // now grab only the product path including suffix (if any)
        if($product_url_path){
            $path = explode('/', $product_url_path);
            $product_path = array_pop($path);
        } elseif($product_request_path){
            $path = explode('/', $product_request_path);
            $product_path = array_pop($path);
        }

        // now set product request path to be our full product url including deepest category url path
        if($product_path){
            $_product->setData('request_path', $category_path . '/' . $product_path);
        }
        // END: force display deepest child category as request path

        return $_product->getProductUrl();
    }
}