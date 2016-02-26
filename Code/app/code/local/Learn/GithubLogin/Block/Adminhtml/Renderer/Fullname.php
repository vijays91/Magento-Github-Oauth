<?php
class Learn_GithubLogin_Block_Adminhtml_Renderer_Fullname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		/* $github_fullname = $row->getData('fullname'); */
        return ($github_fullname = $row->getData('fullname')) ? $github_fullname : '-';
	}
}