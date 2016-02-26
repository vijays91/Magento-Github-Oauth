<?php
class Learn_GithubLogin_Block_Adminhtml_GithubLogin extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_githublogin';
        $this->_blockGroup = 'githublogin';
        $this->_headerText = Mage::helper('githublogin')->__('Github Login Report');
        parent::__construct();
		$this->_removeButton('add');
    }
}