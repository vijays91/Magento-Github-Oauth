<?php
class Learn_GithubLogin_Block_Button extends Mage_Core_Block_Template
{
    public function getUserAltTitle($customer_id) {
        $collection = Mage::getModel('githublogin/githublogin')->getCollection();
        $collection->addFieldtoFilter('mage_customer_id', $customer_id);
        $data = $collection->getData();
        return $data[0]['fullname'];
    }
    
    public function getUserIcon($customer_id) {
        $collection = Mage::getModel('githublogin/githublogin')->getCollection();
        $collection->addFieldtoFilter('mage_customer_id', $customer_id);
        $data = $collection->getData();
        return $data[0]['profile_image'];
    }
}