Magento General Module Extension
================================

This magento module (General) is going to have general helpers etc required when building a site. You can suggest some everyday functions used, so it's easy to find and use.

##Sample use of general helper

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

## Magento add multiple css and js at one go
**instead of action "addItem", use "addMultipleItems" action and separate names with comma(,).
	<reference name="head">
		<action method="addMultipleItems"><type>skin_js</type><name>js/banner-1.js,js/banner-2.js</name><params/><if/></action>
		<action method="addMultipleItems"><type>skin_css</type><name>css/banner-1.css,css/banner-2.css</name><params/><if/></action>
	</reference>
