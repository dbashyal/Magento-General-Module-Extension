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
/*
 * Usage:
 * <reference name="top.links">
     <block type="tgeneral/welcome" name="tgeneral_welcome_link">
         <action method="addWelcomeLink"></action>
     </block>
     <action method="removeLinkByUrl"><url helper="customer/getAccountUrl"/></action>
     <action method="addLink" translate="label title" module="customer"><label>My Account</label><url helper="customer/getAccountUrl"/><title>My Account</title><prepare/><urlParams/><position>20</position></action>
 </reference>
 */
class Technooze_Tgeneral_Block_Welcome extends Mage_Core_Block_Template
{
    public function addWelcomeLink()
    {
        $parentBlock = $this->getParentBlock();
        if ($parentBlock && Mage::getSingleton('customer/session')->isLoggedIn()) {
            $text = $this->__('Welcome, %s', Mage::getSingleton('customer/session')->getCustomer()->getName());
            //public function addLink($label, $url='', $title='', $prepare=false, $urlParams=array(), $position=null, $liParams=null, $aParams=null, $beforeText='', $afterText='')
            // note urls need to be unique, so added index at the end.
            $parentBlock->addLink($text, 'customer/account/index', $text, true, array(), 10, null, 'class="welcome_text"');
        }
        return $this;
    }
}