<?php

class UserController extends Zend_Controller_Action
{

    private $config;
    
    
    public function init()
    {
         $config_file="../application/configs/application.ini";
         $this->config=new Zend_Config_Ini($config_file, APPLICATION_ENV);
        $this->_helper->layout()->setLayout("backend");
    }

    public function indexAction()
    {
        $user = new Application_Model_UserMapper();
        $this->view->entries = $user->fetchAll();
    }

    function addAction()
    {
    	$form = new Application_Form_User();
    
    	$form->submit->setLabel('Add');
    	$this->view->form = $form;
    	
    	if ($this->getRequest()->isPost()) {
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData)) {
    			
    			$userdata = new Application_Model_User();
    			$userdata->setEmail($form->getValue('email'));
    			$userdata->setPassword($form->getValue('password'));
    			$userdata->setDisplay_name($form->getValue('display_name'));
    			$userdata->setState($form->getValue('state'));
    			$userdata->setIdusertype($form->getValue('idusertype'));
                        $token=md5($form->getValue('email').$this->config->verify->signature);
                        $userdata->setToken($token);
    			
    			$user = new Application_Model_UserMapper();
    			$user->save($userdata);
                        /*
                         * enviar email y probar ke existe y que es de el
                         */
                        $this->sendEmail($userdata);
                        
                        
    			$this->_helper->redirector('index');
    		} else {
    			$form->populate($formData);
    		}
    	}
    	
    }   
    function editAction()
    {
    	$form = new Application_Form_User();
    
    	$form->submit->setLabel('Add');
    	$this->view->form = $form;
    	 
    	if ($this->getRequest()->isPost()) 
    	{
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData))
    		 {
    			 
    			$userdata = new Application_Model_User();
    			$userdata->setIduser($form->getValue('iduser'));
    			$userdata->setEmail($form->getValue('email'));
    			$userdata->setPassword($form->getValue('password'));
    			$userdata->setDisplay_name($form->getValue('display_name'));
    			//$userdata->setState($form->getValue('state'));
    			$userdata->setIdusertype($form->getValue('idusertype'));
    			 
    			$user = new Application_Model_UserMapper();
    			$user->save($userdata);
    			$this->_helper->redirector('index');
    		} 
    		else
    		{
    			$form->populate($formData);
    		}
    	}
    	else
    	 {
    	 	
    		$id = $this->_getParam('iduser', 0);
    		if ($id > 0) 
    		{
    			$user = new Application_Model_UserMapper();
    			$userdata = new Application_Model_User();
    			
    			$form->populate($user->find($id, $userdata));
                        
    		}
    	 }
    	 
    }
    
    public function deleteAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$del = $this->getRequest()->getPost('del');
    		if ($del == 'Yes') {
    			$id = $this->getRequest()->getPost('id');
    			$user = new Application_Model_UserMapper();
    			$user->delete($id);
    		}
    		$this->_helper->redirector('index');
    	} else {
    		$id = $this->_getParam('iduser', 0);
    		$user = new Application_Model_UserMapper();
    		$userdata = new Application_Model_User();
    		$this->view->user =$user->find($id, $userdata);
    	}
    }

    	private function sendEmail($user){
          //  $config_file="../application/configs/application.ini";
          //  $config=new Zend_Config_Ini($config_file, APPLICATION_ENV);
           
		$configs['server']=$this->config->email->server;
		$configs['ssl']=$this->config->email->ssl;
		$configs['port']=$this->config->email->port;
		$configs['auth']=$this->config->email->auth;
		$configs['username']=$this->config->email->username;
		$configs['password']=$this->config->email->password;
		$configs['urlActivates']= 'http://feedfilms.local/user/index/'.$user->getEmail().'/'.$user->getToken();
		$transport = new Zend_Mail_Transport_Smtp($configs['server'], $configs);
		
		
                
		$mail = new Zend_Mail();
		$mail->addTo($user->getEmail(), 'Test');
		
		$mail->setSubject('Activate your account');
		$mail->setBodyText("Activate your account ".$configs['urlActivates']);
                Zend_Debug::dump($transport, "trasport:", true);
                Zend_Debug::dump($configs, "config:", true);
                  Zend_Debug::dump($user, "user:", true);
               // die;
		$mail->send($transport);
	}

}



