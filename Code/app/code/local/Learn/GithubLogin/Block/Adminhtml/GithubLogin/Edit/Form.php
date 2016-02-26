<?php
class Learn_GithubLogin_Block_Adminhtml_GithubLogin_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
    {
		$viewForm = new Varien_Data_Form(array(
            'id' => 'view_form',
        ));
		$viewForm->setUseContainer(true);
		
        $this->setForm($viewForm);
		
		$fieldset = $viewForm->addFieldset('githubloginview_form', array(
            'legend'      => Mage::helper('githublogin')->__('Github Login Record'),
            'class'        => 'fieldset-wide',
            )
        );
		
		$value =   Mage::registry('githublogin_data')->getData();
		
        $fieldset->addField('Id', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Id'),
            'text'      => $value['id'],
        ));

        $fieldset->addField('Github Id', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Github Id'),
            'text'      => $value['github_id'],
        ));
        
        $fieldset->addField('Customer Id', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Customer Id'),
            'text'      => "<a href='".Mage::helper("adminhtml")->getUrl("adminhtml/customer/edit/", array("id"=>$value['mage_customer_id']))."'>". $value['mage_customer_id'] ."</a>",
        ));
        
        $fieldset->addField('fullname', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Fullname'),
            'text'      => $value['fullname'],
        ));
        
        $fieldset->addField('Email Id', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Email Id'),
            'text'      => $value['email'],
        ));
        
        $fieldset->addField('Company', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Company'),
            'text'      => $value['company'],
        ));

        $fieldset->addField('Blog', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Blog'),
            'text'      => $value['blog'],
        ));
        
        $fieldset->addField('Location', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Location'),
            'text'      => $value['location'],
        ));

        $fieldset->addField('Github Username', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Github Username'),
            'text'      => $value['github_username'],
        ));
        
        $fieldset->addField('Profile Image', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Profile Image'),
            'text'      => "<img src='". $value['profile_image'] ."' alt='@$github_username' height='50px' width='50px'/>",
        ));
        
        $fieldset->addField('Github URL', 'note', array(
            'label'     => Mage::helper('githublogin')->__('Github URL'),
            'text'      => $value['github_url'],
        ));
        


		$fieldset->addField('Created At', 'note', array(
			'label'     => Mage::helper('githublogin')->__('Created At'),
			'text'      => date("d-m-Y H:i:s", strtotime($value['created_at'])),
		));
        
		if ( Mage::getSingleton('adminhtml/session')->getgithubloginData() ) {        
            $viewForm -> setValues(Mage::getSingleton('adminhtml/session')->getgithubloginData());
            Mage::getSingleton('adminhtml/session')->getgithubloginData(null);
		} elseif ( Mage::registry('githublogin_data') ) {
            $viewForm-> setValues(Mage::registry('githublogin_data')->getData());
		}
		return parent::_prepareForm();
	}
	
}