<?php
/**
* @category   Technooze/Modules/magento-how-tos
* @package    Technooze_Tgeneral
* @author     Damodar Bashyal (http://dltr.org/)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Technooze_Tgeneral_Model_Redirect extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('tgeneral/redirect');
    }

    public function redirectToParentUsingObserver(Varien_Event_Observer $observer){
        $request = $observer->getEvent()->getControllerAction()->getRequest();
        $moduleName = $request->getModuleName(); // catalog
        $controllerName = $request->getControllerName(); // product
        $actionName = $request->getActionName(); // noRoute
        $id = $request->getParam('id'); // product ID

        if($id && $moduleName == 'catalog' && $controllerName == 'product' && $actionName == 'noRoute')
        {
            // load product to find assigned categories
            $_product = Mage::getModel('catalog/product')->load($id);
            $_categoryIds = $_product->getCategoryIds();
            $_categoryId = array_pop($_categoryIds);

            // load category
            if($_categoryId){
                $_category = Mage::getModel('catalog/category')->load($_categoryId);
                $_categoryUrl = $_category->getUrl();
                $_productName = $_product->getName();
                $_productSku = $_product->getSKU();
                $msg = Mage::helper('core')->__('Product "%s" (SKU: %s) is no longer in stock. Please check other items from same category.', $_productName, $_productSku);
                Mage::getSingleton('core/session')->addNotice($msg);

                // try redirecting with magento redirect function
                Mage::app()->getFrontController()->getResponse()->setRedirect($_categoryUrl, 301);

                // if not redirected, then use php's own redirect
                header('Location: ' . $_categoryUrl, true, 301);
                exit;
            }
        }
        return false;
    }
}
