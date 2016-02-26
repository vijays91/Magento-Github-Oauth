<?php
class Learn_GithubLogin_OauthController extends Mage_Core_Controller_Front_Action
{
    public function accessAction()
	{
        ini_set('allow_url_fopen', 1);
        /*- Getting the last url -*/
        $lastUrl = Mage::getSingleton('core/session')->getLastUrl();
        Mage::getSingleton('core/session')->setPrvPageUrl($lastUrl);

        $helper = Mage::helper('githublogin');
        $active = $helper->github_oauth_enable();
        $client_id = $helper->github_oauth_client_id();
        $redirect_url = $helper->github_oauth_redirect_url();

        if($active && $client_id && $redirect_url) {
            $url = "https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_url&scope=user";
            header("Location: $url");
            exit;
        } else {
            $error_msg = $this->__("Please check the backend Github Oauth login configuration.");
            Mage::getSingleton('core/session')->addError($error_msg);
            $this->customerAccount();
        }
        
	}
    
    public function callBackAction() {
        $helper = Mage::helper('githublogin');
        $active = $helper->github_oauth_enable();
        $client_id = $helper->github_oauth_client_id();
        $redirect_url = $helper->github_oauth_redirect_url();
        $client_secret = $helper->github_oauth_secret_id();

        if($active && $client_id && $redirect_url && $client_secret)
        {
        
            if(isset($_GET['code']))
            {
                $code = $_GET['code'];
                
                $post = http_build_query(array(
                    'client_id' => $client_id,
                    'redirect_url' => $redirect_url,
                    'client_secret' => $client_secret,
                    'code' => $code,
                ));
                
                $context = stream_context_create(
                    array(
                        "http" => array(
                            "method" => "POST",
                            'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                                        "Content-Length: ". strlen($post) . "\r\n".
                                        "Accept: application/json" ,  
                            "content" => $post,
                        )
                    )
                );
                
                $json_data = file_get_contents("https://github.com/login/oauth/access_token", false, $context);
                $r = json_decode($json_data , true);
                $access_token = $r['access_token'];
                $scope = $r['scope']; 
                
                $url = "https://api.github.com/user?access_token=".$access_token."";
                $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
                $context  = stream_context_create($options);
                $data = file_get_contents($url, false, $context); 
                $user_data  = json_decode($data, true);
                $url = "https://api.github.com/user/emails?access_token=".$access_token."";
                $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
                $context  = stream_context_create($options);
                $emails =  file_get_contents($url, false, $context);
                $email_data = json_decode($emails, true);
                $email_id = $email_data[0]['email'];
                $github_data=array();
                $github_data['email']    = $email_id;
                $github_data['fullname'] = $user_data['name'];
                $github_data['company']  = $user_data['company'];
                $github_data['blog']     = $user_data['blog'];
                $github_data['location'] = $user_data['location'];
                $github_data['github_username'] = $user_data['login'];
                $github_data['github_id']       = $user_data['id'];
                $github_data['profile_image']   = $user_data['avatar_url'];
                $github_data['github_url']      = $user_data['url'];
                $github_data['html_url']        = $user_data['html_url'];
                if(($github_data['fullname'] || $github_data['github_username']) && $github_data['email']) {
                    $customer_id = $this->saveCustomerInfo($github_data);
                    $github_data['mage_customer_id'] = $customer_id;                    
                    $this->saveGithubLogin($github_data);
                    $this->customerAccount(1);
                    exit;
                    
                } else  {
                    $error_msg = $this->__("Github access token has expired.");
                    Mage::getSingleton('core/session')->addError($error_msg);
                    $this->customerAccount();
                    exit;
                }
            } else  {
                    $error_msg = $this->__("Check the given Oauth infromations.");
                    Mage::getSingleton('core/session')->addError($error_msg);
                    $this->customerAccount();
                    exit;
            }
        } else {
            $error_msg = $this->__("Please check the Github Oauth login configuration.");
            Mage::getSingleton('core/session')->addError($error_msg);
            $this->customerAccount();
            exit;
        }
            
    }
    
    public function customerAccount($success = 0) {
        $redirect_url = Mage::getUrl('customer/account/login');
        if($success) {
            $redirect_url = Mage::getSingleton('core/session')->getPrvPageUrl();        
        }
        Mage::app()->getFrontController()->getResponse()->setRedirect($redirect_url);
        Mage::app()->getResponse()->sendResponse();
        exit;
    }
    
    public function saveGithubLogin($data) {
        $data['store_id'] = Mage::app()->getStore();
        $data['update_at'] = date('Y-m-d H:i:s');        
        $githubData = Mage::getModel('githublogin/githublogin');
        $githubData->load($data['email'], 'email');

        /*- Update - */
        if($githubData->getId())  {
            $githubData->addData($data);
            try {
                $githubData->set('email', $data['email'])->save();
            } catch (Exception $e){
                echo $e->getMessage();
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $githubData = Mage::getModel('githublogin/githublogin')->setData($data); 
            try {
                $githubData->save();
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
        return $githubData->getId();
    }
    
    public function saveCustomerInfo($data) {
        $succ_msg  = '';
        $customer_name  = (trim($data['fullname'])) ? $data['fullname'] : $data['github_username'];
        $customer_email = trim($data['email']);
        $websiteId = Mage::app()->getWebsite()->getId();
        $store = Mage::app()->getStore();
        $store_id = Mage::app()->getStore()->getStoreId(); //add them
        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($customer_email);
        
        
        if(!$customer->getId()) {
            $succ_msg = $this->__('Thank you for registering with Main Website Store.');
            Mage::getSingleton('core/session')->addSuccess($succ_msg);
            
            $customer = Mage::getModel('customer/customer'); 
            $customer->setFirstname($customer_name)
                 ->setLastname($customer_name)
                 ->setStoreId($store_id)
                 ->setWebsiteId($websiteId)
                 ->setIsActive(1)
                 ->setConfirmation(null)
                 ->setEmail($customer_email);                 
                try{
                    $customer->save();
                    /* $customer->setConfirmation(null);$customer->save(); */            
                }
                catch (Exception $e) {
                    Zend_Debug::dump($e->getMessage());
                    die('Could able to save the customer');
                }
        }
        
        /*     
        $session = Mage::getSingleton('customer/session');
        if($succ_msg) {
            $session->setCustomerAsLoggedIn($customer);
        } else {
            $session->loginById($customer->getId());
        }
        */
        
        $sess = Mage::getSingleton('customer/session');
        $sess->setWebsiteId($websiteId);
        $sess->loginById($customer->getId());
        $sess->renewSession()->setCustomerAsLoggedIn($customer);
        
        return $customer->getId();
    }
}
