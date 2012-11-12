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
class Technooze_Tgeneral_Block_Html_Head extends Mage_Page_Block_Html_Head
{
    public function __construct()
    {
        parent::_construct();
    }

    /**
     * Add HEAD Item
     *
     * Allowed types:
     *  - js
     *  - js_css
     *  - skin_js
     *  - skin_css
     *  - rss
     *
     * @param string $type
     * @param string $name
     * @param string $params
     * @param string $if
     * @param string $cond
     * @return Mage_Page_Block_Html_Head
     */
    public function addMultipleItems($type, $name, $params=null, $if=null, $cond=null)
    {
        if ($type==='skin_css' && empty($params)) {
            $params = 'media="all"';
        }

        $files = explode(',', $name);

        foreach($files as $name){
            $name = trim($name);

            if(empty($name)) continue;

            $this->_data['items'][$type.'/'.$name] = array(
                'type'   => $type,
                'name'   => $name,
                'params' => $params,
                'if'     => $if,
                'cond'   => $cond,
           );
        }
        return $this;
    }
}
