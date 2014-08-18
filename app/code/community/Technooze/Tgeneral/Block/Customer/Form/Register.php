<?php
class Technooze_Tgeneral_Block_Customer_Form_Register extends Mage_Customer_Block_Form_Register
{
    /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getAdminPostActionUrl()
    {
        return $this->helper('tgeneral/customer')->getAdminRegisterPostUrl();
    }
}