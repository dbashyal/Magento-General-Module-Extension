<?php
class Technooze_Tgeneral_Helper_Customer extends Mage_Customer_Helper_Data
{
    /**
     * Retrieve admin customer register form url
     *
     * @return string
     */
    public function getAdminRegisterUrl()
    {
        return $this->_getUrl('customer/account/createadmin');
    }

    /**
     * Retrieve admin customer register form post url
     *
     * @return string
     */
    public function getAdminRegisterPostUrl()
    {
        return $this->_getUrl('customer/account/createadminpost');
    }
}