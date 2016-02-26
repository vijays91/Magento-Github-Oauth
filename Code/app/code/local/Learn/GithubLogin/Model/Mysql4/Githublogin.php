<?php
class Learn_GithubLogin_Model_Mysql4_Githublogin extends Mage_Core_Model_Mysql4_Abstract 
{
    protected function _construct()
    {
		$this->_init('githublogin/githublogin', 'id');
	}
}