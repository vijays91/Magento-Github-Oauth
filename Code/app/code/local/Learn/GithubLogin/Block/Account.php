<?php
class Learn_GithubLogin_Block_Account extends Mage_Customer_Block_Account_Dashboard
{
    protected $userInfo = null;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('githublogin/githublogin.phtml');
        $this->userInfo = Mage::registry('github_user_data');
    }
    protected function _hasUserInfo()
    {
        return (bool) $this->userInfo;
    }
    
    protected function user_info()
    {
        return $this->userInfo;
    }
}