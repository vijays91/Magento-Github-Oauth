<?php
class Learn_GithubLogin_Adminhtml_GithubloginController extends Mage_Adminhtml_Controller_Action 
{
    protected function _initAction()
    {
		$this->loadLayout()->_setActiveMenu('githublogin/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Github Login'), Mage::helper('adminhtml')->__('Github Login'));
		return $this;
    }  

    public function indexAction() 
	{
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('githublogin/adminhtml_githublogin'));
        $this->renderLayout();
    }

	public function viewAction()
	{
		$githubloginId     = $this->getRequest()->getParam('id');
		$githubloginModel  = Mage::getModel('githublogin/githublogin')->load($githubloginId);
        
        if ($githubloginModel->getId() || $githubloginId == 0)  {
             Mage::register('githublogin_data', $githubloginModel); 
            $this->loadLayout();
            $this->_setActiveMenu('githublogin/items');           
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Contact Record Manager'), Mage::helper('adminhtml')->__('Record Manager')
            );
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Record Details'), Mage::helper('adminhtml')->__('Record Details')
            );
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);           
            $this->_addContent($this->getLayout()->createBlock('githublogin/adminhtml_githublogin_edit'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
				Mage::helper('githublogin')->__('Record does not exist')
			);
            $this->_redirect('*/*/');
        }
	}

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('githublogin/adminhtml_githublogin_grid')->toHtml()
        );
    }
    
	//** Export in CSV
	public function exportCsvAction()
    {
		$fileName   = 'github_login_report-'. date('His').'.csv';
		$content    = $this->getLayout()->createBlock('githublogin/adminhtml_githublogin_grid')->getCsv(); 
		$this->_prepareDownloadResponse($fileName, $content);
    }
	
	//** Export in XML
    public function exportXmlAction()
    {
        $fileName   = 'github_login_report-'. date('His').'.xml';
        $content    = $this->getLayout()->createBlock('githublogin/adminhtml_githublogin_grid')->getXml(); 
        $this->_prepareDownloadResponse($fileName, $content);
    }
}