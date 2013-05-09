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
    private $_priceLabel = 'Price';
    private $_mediaGalleryBackendModel;
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

    /*
     * @deprecated use helper/Catalog.php
     */
    public function getProductUrl(Mage_Catalog_Model_Product $_product = null){
        return Mage::helper('tgeneral/catalog')->getProductUrl($_product);
    }

    public function getPriceLabel(){
        $label = Mage::getStoreConfig('tgeneral/general/price_label');
        if(empty($label)){
            return $this->_priceLabel;
        }
        return $label;
    }

    /**
     *
     */
    public function addImagesToProduct($_productId = 0, $images = array())
    {
        if(!$_productId) return $this;
        $product = Mage::getModel('catalog/product')->load($_productId);

        $importData = array();
        $images = array_filter($images);
        if(empty($images)) return $product;

        $img = array_shift($images);
        $img = DS . trim(str_replace(array('/', '\\'), DS, trim($img)), DS);
        $importData['image'] = $importData['small_image'] = $importData['thumbnail'] = $img;

         /*
          Code for image upload in version 1.5.x.x and above
         */
         if(!$this->_mediaGalleryBackendModel){
             $this->_mediaGalleryBackendModel = Mage::getModel('catalog/product')->getResource()->getAttribute('media_gallery')->getBackend();
         }
         $mediaGalleryBackendModel = $this->_mediaGalleryBackendModel;

        $arrayToMassAdd = array();

        foreach ($product->getMediaAttributes() as $mediaAttributeCode => $mediaAttribute) {
            if (isset($importData[$mediaAttributeCode])) {
                $file = $importData[$mediaAttributeCode];
                if (is_file(Mage::getBaseDir('media') . DS . 'import' . $file) && !$mediaGalleryBackendModel->getImage($product, $file)) {
                    $arrayToMassAdd[] = array('file' => trim($file), 'mediaAttribute' => $mediaAttributeCode);
                }
            }
        }

        //Mage::log($arrayToMassAdd);

        $addedFilesCorrespondence =
            $mediaGalleryBackendModel->addImagesWithDifferentMediaAttributes($product, $arrayToMassAdd, Mage::getBaseDir('media') . DS . 'import', false, false);
        //Mage::log('pass');

        foreach ($product->getMediaAttributes() as $mediaAttributeCode => $mediaAttribute) {
            $addedFile = '';
            if (isset($importData[$mediaAttributeCode . '_label'])) {
                $fileLabel = trim($importData[$mediaAttributeCode . '_label']);
                if (isset($importData[$mediaAttributeCode])) {
                    $keyInAddedFile = array_search($importData[$mediaAttributeCode],
                        $addedFilesCorrespondence['alreadyAddedFiles']);
                    if ($keyInAddedFile !== false) {
                        $addedFile = $addedFilesCorrespondence['alreadyAddedFilesNames'][$keyInAddedFile];
                    }
                }

                if (!$addedFile) {
                    $addedFile = $product->getData($mediaAttributeCode);
                }
                if ($fileLabel && $addedFile) {
                    $mediaGalleryBackendModel->updateImage($product, $addedFile, array('label' => $fileLabel));
                }
            }
        }

        foreach($images as $img){
            $img = DS . trim(str_replace(array('/', '\\'), DS, $img), DS);
            $image_path = realpath(Mage::getBaseDir('media') . DS . 'import' . $img);
            if(file_exists($image_path) && is_file($image_path)){
                $product->addImageToMediaGallery(Mage::getBaseDir('media') . DS . 'import' . $img, null, false, false);
            }
        }

        try {
            $product->save();
        } catch (Exception $e){
            Mage::logException($e);
        }

        return $product;
    }

    /**
     *
     */
    public function removeImagesFromProduct($_productId = 0)
    {
        if(!$_productId) return $this;
        $product = Mage::getModel('catalog/product')->load($_productId);

        //check if gallery attribute exists then remove all images if it exists
        //Get products gallery attribute
        $attributes = $product->getTypeInstance()->getSetAttributes();
        if (isset($attributes['media_gallery'])) {
            $gallery = $attributes['media_gallery'];
            //Get the images
            $galleryData = $product->getMediaGallery();
            if(isset($galleryData['images'])) {
                foreach ($galleryData['images'] as $image) {
                    //If image exists
                    if ($gallery->getBackend()->getImage($product, $image['file'])) {
                        $gallery->getBackend()->removeImage($product, $image['file']);

                        $oldImage = str_replace(array('/', '\\'), DS, (Mage::getBaseDir('media') . DS . 'catalog' . DS . 'product' . $image['file']));

                        if(file_exists($oldImage))
                        {
                            unlink($oldImage);
                        }
                    }
                }
                //$gallery->getBackend()->clearMediaAttribute($product, array_keys($product->getMediaAttributes()));
            }
        }

        try {
            $product->save();
        } catch (Exception $e){
            Mage::logException($e);
        }

        //end
        return $product;
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