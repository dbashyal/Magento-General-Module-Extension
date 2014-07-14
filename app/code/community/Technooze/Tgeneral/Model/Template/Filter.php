<?php
class Technooze_Tgeneral_Model_Template_Filter extends Mage_Widget_Model_Template_Filter
{
    /**
     * Generate tgeneral
     *
     * @param array $construction
     * @return string
     */
    public function tgeneralDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);

        $allowedParams = array('helper');

        /*
         * check if param is not empty
         * or atleast one allowed param exists
         */
        if(empty($params) || !count(array_intersect($allowedParams, array_keys($params)))){
            return $construction[0];
        }

        if(isset($params['helper']) && !empty($params['helper'])){
            $helper_method = explode('/', $params['helper']);
            if(count($helper_method) == 1){
                $helper = '';
                $method = $helper_method[0];
            } else {
                $method = array_pop($helper_method);
                $helper = '/' . implode('/', $helper_method);
            }
            try{
                $helper = Mage::helper('tgeneral' . $helper);
                if(is_callable(array($helper, $method), true, $callable_name)){
                    return call_user_func(array($helper, $method));
                }
            } catch (Exception $e){
                return $construction[0];
            }
        }
        // if it still reaches here, send original text
        return $construction[0];
    }
}
