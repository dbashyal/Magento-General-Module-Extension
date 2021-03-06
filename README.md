Magento General Module Extension
================================

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=dbashyal&url=https://github.com/dbashyal&title=Github Repos&language=&tags=github&category=software)

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

##Magento product url  - get full category path
```php
Mage::helper('tgeneral')->getProductUrl($_product);
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

##media cdn
on my etc/hosts i have media.example.com, media0.example.com-media10.example.com so i can use different media urls to load faster
this is a quick dirty hack that works for me. this is how i convert urls.
```php
Mage::helper('tgeneral')->mediaCdnUrl($this->helper('catalog/image')->init($_product, 'small_image')->setQuality(100)->resize(300));
```
on system config in media url i have set (http://media.example.com/) then media is replaced with media0-media10)

## Magento 301 redirect disabled products pages to associated category pages
```xml
    <frontend>
        <events>
            <controller_action_predispatch>
                <observers>
                    <technooze_tgeneral_model_redirect>
                        <type>singleton</type>
                        <class>tgeneral/redirect</class>
                        <method>redirectToParentUsingObserver</method>
                    </technooze_tgeneral_model_redirect>
                </observers>
            </controller_action_predispatch>
        </events>
    </frontend>
```

## Add welcome text on top links.
```xml
<reference name="top.links">
    <block type="tgeneral/welcome" name="tgeneral_welcome_link">
        <action method="addWelcomeLink"></action>
    </block>
    <action method="removeLinkByUrl"><url helper="customer/getAccountUrl"/></action>
    <action method="addLink" translate="label title" module="customer"><label>My Account</label><url helper="customer/getAccountUrl"/><title>My Account</title><prepare/><urlParams/><position>20</position></action>
</reference>
```

## Now you can add new custom template tag to call your helper
New CMS directive included in this module will help you to call helper functions within your cms pages and static blocks.
```php
{{tgeneral helper="getAlternateStoreUrl"}}
// or
{{tgeneral helper="yourHelperWithinTgeneralModule/getAlternateStoreUrl"}}
```

##remove account link by name
```xml
    <customer_account>
        <reference name="customer_account_navigation">
            <action method="removeLink"><name>rewardpoints</name></action>
        </reference>
    </customer_account>
```
## remove body class to change position
```xml
    <customer_account_createadmin>
        <update handle="customer_account_create"/>
        <reference name="root">
			<!-- first add original class of customer create -->
            <action method="addBodyClass"><classname>customer-account-create</classname></action>
			<!-- remove createadmin class which is added by default before previous one -->
            <action method="removeBodyClass"><classname>customer-account-createadmin</classname></action>
			<!-- now add it back, so it's added at the end -->
            <action method="addBodyClass"><classname>customer-account-createadmin</classname></action>
        </reference>
    </customer_account_createadmin>
```

###visit: http://dltr.org/ for more magento tips, tricks and codes.

