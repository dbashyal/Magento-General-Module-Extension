<?php
class Technooze_Tgeneral_Model_Data
{
    public function toOptionArray()
    {
        return array(
            array('value'=>1, 'label'=>Mage::helper('tgeneral')->__('1')),
            array('value'=>2, 'label'=>Mage::helper('tgeneral')->__('2')),
            array('value'=>3, 'label'=>Mage::helper('tgeneral')->__('3')),
            array('value'=>4, 'label'=>Mage::helper('tgeneral')->__('4')),
        );
    }
}