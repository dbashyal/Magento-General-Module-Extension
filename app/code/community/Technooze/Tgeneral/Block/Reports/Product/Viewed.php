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
class Technooze_Tgeneral_Block_Reports_Product_Viewed extends Mage_Reports_Block_Product_Viewed
{
    /**
     * Prepare to html
     * check has viewed products
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getCount()) {
            // let's show current product as recent product
            // if this is first item viewed
            return $this->_showCurrentProduct();
        }
        $this->setRecentlyViewedProducts($this->getItemsCollection());
        return Mage_Core_Block_Template::_toHtml();
    }

    /**
     * @return string
     */
    private function _showCurrentProduct(){
        if(!Mage::registry('current_product')){
            return '';
        }
        $this->setRecentlyViewedProducts(array(Mage::registry('current_product')));
        return Mage_Core_Block_Template::_toHtml();
    }
}
