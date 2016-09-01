<?php

class LoginController extends Prato_Controller_Action {

    public function indexAction() {
        $form = new Application_Form_Login();
        
        if ($this->getRequest()->isPost()) {
            $values = $this->getAllParams();
            if ($form->isValid($values)) {
             
                $adap = new Zend_Auth_Adapter_DbTable();
                $adap ->setTableName('admin');  
                $adap ->setIdentityColumn('email');  
                $adap ->setCredentialColumn('senha');  

                $adap ->setIdentity($form ->getValue('email'));  
                $adap ->setCredential($form ->getValue('senha')); 

                $auth = Zend_Auth::getInstance();
                $resultado = $auth ->authenticate($adap);  

                if ($resultado ->isValid()) 
                {
                    $dados = $adap ->getResultRowObject(null, array('senha')); 
                    $auth ->getStorage() ->write($dados); 
                    
                    $this ->_helper ->redirector ->gotoSimpleAndExit('index', 'index');  
                }
                else
                {
                    $form ->getElement('email') ->addError('login ou senha incorreta'); 
                }
            }
        }
        
        $this->view->form = $form;
    }

    public function logoutAction() {

        Zend_Auth::getInstance() ->clearIdentity();  

        $this ->_helper ->redirector ->gotoSimpleAndExit('index');  
        
    }

}
