<?php
class Technooze_Tgeneral_Block_Page_Html extends Mage_Page_Block_Html
{
    /**
     * remove CSS class from page body tag
     *
     * @param string $className
     * @return Technooze_Tgeneral_Block_Page_Html
     */
    public function removeBodyClass($className)
    {
        // requested class that need to be removed
        $className  = preg_replace('#[^a-z0-9]+#', '-', strtolower($className));
        // existing class names
        $classNames = explode(' ', trim($this->getBodyClass()));
        // remove matching className(s)
        $result     = array_diff($classNames, (array)$className);
        // set body class with remaining className(s)
        $this->setBodyClass(implode(' ', $result));

        return $this;
    }
}
