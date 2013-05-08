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
    protected $_mediaCount = 0;
    private $_tcdn = 0;

    public function __construct(){
        $this->_tcdn = Mage::getStoreConfig('general/tgeneral/tcdn');
    }

    public function mediaCdnUrl($src = false)
    {
        if(!$src || !$this->_tcdn) return $src;

        $src = preg_replace('/:\/\/media/', '://media' . $this->_mediaCount++, $src);

        if($this->_mediaCount > 10) {
            $this->_mediaCount = 0;
        }

        return $src;
   	}

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

    public static function log($message, $file = '', $mode='a')
    {
        if (empty($file)) {
            $file = 'updatedProducts-'.date('Ymd', time()).'.log';
        }
        $logDir  = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . $file;

        try {
            if (!is_dir($logDir)) {
                mkdir($logDir);
                chmod($logDir, 0777);
            }

            if (!file_exists($logFile)) {
                file_put_contents($logFile, '');
                chmod($logFile, 0777);
            }

            if (is_array($message) || is_object($message)) {
                $message = print_r($message, true);
            }

            $fp = fopen($logFile, $mode);
            if (false === @fwrite($fp, $message . PHP_EOL)){
                throw new Zend_Log_Exception("Unable to write to stream");
            }
            fclose($fp);
        }
        catch (Exception $e) {
        }
    }
}