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
class Technooze_Tgeneral_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getContactUsUrl()
   	{
   		return $this->_getUrl('contacts');
   	}

    public function getFreeReturnsUrl()
   	{
   		return $this->_getUrl('free-returns');
   	}

    public function getFreeShippingUrl()
   	{
   		return $this->_getUrl('free-shipping');
   	}

    public function getStorePhoneNumber()
   	{
   		return Mage::getStoreConfig('general/store_information/phone');
   	}

    public function getStoreAddress()
   	{
        return Mage::getStoreConfig('general/store_information/address');
   	}

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
}