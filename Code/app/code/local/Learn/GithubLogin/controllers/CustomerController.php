<?php
//Include the Magento Admin Html core files for Overriding.
include_once("Mage/Adminhtml/controllers/CustomerController.php");
class Learn_GithubLogin_CustomerController extends Mage_Adminhtml_CustomerController
{    
    public function massDeleteAction()
    {	
		$customersIds = $this->getRequest()->getParam('customer');
		
        if(!is_array($customersIds)) 
		{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select customer(s).'));
        } 
		else
		{
            try 
			{
                $customer = Mage::getModel('customer/customer');
                foreach ($customersIds as $customerId) 
				{
                    $customer->reset()->load($customerId)->delete();

					$getGithubCollection = Mage::getModel('githublogin/githublogin')->getCollection();
					$getGithubCollection->addFieldToFilter('mage_customer_id', $customerId);
					$getGithubData = $getGithubCollection->getData(); 
					if(isset($getGithubData))
					{	
                        Mage::getModel('githublogin/githublogin')->load($getGithubData[0]['id'])->delete();
					}
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($customersIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
	
}
