<?php
class Learn_GithubLogin_Helper_Data extends Mage_Core_Helper_Abstract 
{
    const XML_PATH_GITHUB_ENABLE    = 'githublogin_tab/githublogin_setting/github_enable';
    const XML_PATH_GITHUB_CLIENT_ID = 'githublogin_tab/githublogin_setting/github_client_id';
    const XML_PATH_GITHUB_CLIENT_SECRET_ID = 'githublogin_tab/githublogin_setting/github_client_secret';
    const XML_PATH_GITHUB_REDIRECT_URL = 'githublogin_tab/githublogin_setting/github_redirect_url';
    const XML_PATH_GITHUB_APP_NAME = 'githublogin_tab/githublogin_setting/github_app_name';
    
    public function conf($code, $store = null) {
        return Mage::getStoreConfig($code, $store);
    }

	public function github_oauth_enable($store) {
        return $this->conf(self::XML_PATH_GITHUB_ENABLE, $store);
    }
    
	public function github_oauth_client_id($store) {
        return $this->conf(self::XML_PATH_GITHUB_CLIENT_ID, $store);
    }
    
	public function github_oauth_secret_id($store) {
        return $this->conf(self::XML_PATH_GITHUB_CLIENT_SECRET_ID, $store);
    }
    
	public function github_oauth_redirect_url($store) {
        return $this->conf(self::XML_PATH_GITHUB_REDIRECT_URL, $store);
    }
    
	public function github_oauth_appname($store) {
        return $this->conf(self::XML_PATH_GITHUB_APP_NAME, $store);
    }
    
    
}