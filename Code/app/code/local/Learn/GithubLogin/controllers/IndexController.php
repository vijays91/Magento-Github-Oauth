<?php
class Learn_GithubLogin_IndexController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }
    
    public function indexAction()
	{
		$data = Mage::getModel('githublogin/githublogin')->getCollection()->getData();
		echo "<pre>";        
		print_r($data);	
		echo "</pre>";
	}
    
    public function accountAction()
    {        
        $customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $userInfo = Mage::getModel('githublogin/githublogin')->load($customer_id, "mage_customer_id")->getData();
        Mage::register('github_user_data', $userInfo);
        $this->loadLayout();
        $this->renderLayout();
        /*
            $this->loadLayout();
            $update = $this->getLayout()->getUpdate();
            $update->addHandle('default');
            $this->addActionLayoutHandles();
            $update->addHandle('customer_account');
            $this->loadLayoutUpdates();
            $this->generateLayoutXml();
            $this->generateLayoutBlocks();
            $this->_isLayoutLoaded = true;
            $this->_initLayoutMessages('customer/session');
            $this->_initLayoutMessages('catalog/session');
            $this->getLayout()->getBlock('content')->append(
                $this->getLayout()->createBlock('githublogin/account')
            );            
            $this->getLayout()->getBlock('head')->setTitle($this->__('Github Connect'));
            $this->renderLayout();
        */
    }
}
