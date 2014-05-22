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
 * @author   Damodar Bashyal (github.com/dbashyal/Magento-General-Module-Extension)
 */
class Technooze_Tgeneral_Helper_Contacts extends Mage_Contacts_Helper_Data
{
    private $_tData = array();
    private $_tCustomer = false;

    public function getCustomer(){
        if(!$this->_tCustomer && Mage::getSingleton('customer/session')->isLoggedIn()){
            $this->_tCustomer = Mage::getSingleton('customer/session')->getCustomer();
        }
        return $this->_tCustomer;
    }

    public function flatten(array $array) {
    	$return = array();
    	array_walk_recursive($array, function($a, $b) use (&$return) { $return[$b] = $a; });
    	return $return;
    }

    public function getData($key=false, $default='')
    {
        if(empty($this->_tData)){
            $this->_tData = (array)Mage::app()->getRequest()->getPost();
            if($this->getCustomer()){
                $data = $this->getCustomer()->getData();
                $this->_tData = array_merge($data, $this->flatten($this->_tData));
            }
        }
        if($key){
            if(isset($this->_tData[$key])){
                return trim($this->_tData[$key]);
            }
            return $default;
        }
        return $this->_tData;
    }

    public function getFirstName()
    {
        return ($this->getData('first-name') ? $this->getData('first-name') : $this->getData('firstname'));
    }

    public function getLastName()
    {
        return ($this->getData('last-name') ? $this->getData('last-name') : $this->getData('lastname'));
    }
}