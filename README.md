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
				<a>class="free-shipping"</a>
				<before_text/>
				<after_text/>
			</action>
			<action method="addLink" translate="label title" module="tgeneral">
				<label helper="tgeneral/getStorePhoneNumber"/>
				<url helper="tgeneral/getFreeShippingUrl" />
				<title helper="tgeneral/getStorePhoneNumber"/>
				<prepare/>
				<urlParams/>
				<position>20</position>
				<li/>
				<a>class="contact-number"</a>
				<before_text/>
				<after_text/>
			</action>
			<action method="addLink" translate="label title" module="tgeneral">
				<label>Free shipping</label>
				<url helper="tgeneral/getFreeReturnsUrl" />
				<title>Free shipping</title>
				<prepare/>
				<urlParams/>
				<position>10</position>
				<li/>
				<a>class="free-shipping"</a>
				<before_text/>
				<after_text/>
			</action>
		</block>
	</reference>
