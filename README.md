Magento General Module Extension
================================

This magento module (General) is going to have general helpers etc required when building a site. You can suggest some everyday functions used, so it's easy to find and use.

##Sample use of general helper
```xml
<reference name="header">
	<block type="page/template_links" name="top.links.custom" as="topLinksCustom">
		<action method="addLink" translate="label title" module="tgeneral">
			<label>Free shipping</label>
			<url helper="tgeneral/getFreeShippingUrl" />
			<title>Free shipping</title>
			<prepare/>
			<urlParams/>
			<position>10</position>
			<li/>
			<a>class="top-free-shipping"</a>
			<before_text/>
			<after_text/>
		</action>
		<action method="addLink" translate="label title" module="tgeneral">
			<label helper="tgeneral/getStorePhoneNumber"/>
			<url helper="tgeneral/getContactUsUrl"/>
			<title helper="tgeneral/getStorePhoneNumber"/>
			<prepare/>
			<urlParams/>
			<position>20</position>
			<li/>
			<a>class="top-contact-number"</a>
			<before_text/>
			<after_text/>
		</action>
		<action method="addLink" translate="label title" module="tgeneral">
			<label>Free Returns</label>
			<url helper="tgeneral/getFreeReturnsUrl" />
			<title>Free Returns</title>
			<prepare/>
			<urlParams/>
			<position>30</position>
			<li/>
			<a>class="top-free-returns"</a>
			<before_text/>
			<after_text/>
		</action>
	</block>
</reference>
```

## Magento add multiple css and js at one go
**instead of action "addItem", use "addMultipleItems" action and separate names with comma(,).
```xml
<reference name="head">
	<action method="addMultipleItems"><type>skin_js</type><name>js/banner-1.js,js/banner-2.js</name><params/><if/></action>
	<action method="addMultipleItems"><type>skin_css</type><name>css/banner-1.css,css/banner-2.css</name><params/><if/></action>
</reference>
```

##Magento get current category
using below command you can get current category from category or product mage
```php
$currentCat = Mage::helper('tgeneral')->getCurrentCategory();
```
Then you can get current category's info like category url, category name, category id etc. from the category object returned.
```php
$currentCat->getUrl();
$currentCat->getName();
$currentCat->getId();
```


###visit: http://learntipsandtricks.com/ for more magento tips, tricks and codes.