<?php
class Learn_GithubLogin_Block_Adminhtml_Renderer_Profileimage extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$profile_image = $row->getData('profile_image');
		$github_username = $row->getData('github_username');
		$img = "<img src='$profile_image' alt='@$github_username' height='40px' width='40px'/>";
		return $img;
	}
}