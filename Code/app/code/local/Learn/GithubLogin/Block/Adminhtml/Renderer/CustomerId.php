<?php
class Learn_GithubLogin_Block_Adminhtml_Renderer_CustomerId extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$customer_id = $row->getData('mage_customer_id');
        $custom_customer_id = "<a href='". Mage::helper("adminhtml")->getUrl("adminhtml/customer/edit/", array("id"=>$customer_id))."'>". $customer_id ."</a>";
        return $custom_customer_id;
	}
}