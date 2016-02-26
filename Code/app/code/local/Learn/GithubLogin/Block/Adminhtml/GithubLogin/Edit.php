<?php
class Learn_GithubLogin_Block_Adminhtml_GithubLogin_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'githublogin';
        $this->_controller = 'adminhtml_githublogin';
		$this->_removeButton('save');
		$this->_removeButton('delete');
		$this->_removeButton('reset');
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('githublogin_data') && Mage::registry('githublogin_data')->getId() ) 
		{
            return Mage::helper('githublogin/data')->__("View Github Login Record Id &nbsp;'%s'  ", $this->htmlEscape(Mage::registry('githublogin_data')->getId()));
        }
    }
}