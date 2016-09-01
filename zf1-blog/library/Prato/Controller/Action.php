<?php

class Prato_Controller_Action extends Zend_Controller_Action {

    public function init() {
        $session = Zend_Registry::get('session');
        //verifica ACL
        if (Zend_Registry::isRegistered('acl')) {
            $request = $this->getRequest();
        
            $controller = $request->getControllerName();
            $action = $request->getActionName();

            $resource = $controller;
            $privilege = $action;

            $role = $this->getAuthRole();

            $acl = Zend_Registry::get('acl');
            if (!$acl->isAllowed($role, $resource, $privilege)) {
                die("Você não tem permissão para executar a tarefa ({$role})");
            
            }

            Zend_Layout::getMvcInstance()
                    ->getView()
                    ->navigation()
                    ->setAcl($acl)
                    ->setRole($role);
        }
    }

    /**
     *
     * @return Zend_Acl
     */
    protected function getAcl() {
        return Zend_Registry::get('acl');
    }

    protected function getAuthRole() {
        $auth = Zend_Auth::getInstance();
       
        if ($auth->hasIdentity()) {
            $role = ($auth->getIdentity()->papel == '2') ? 'admin' : 'gerente';
        } else {
            $role = 'visitante';
        }
        return $role;
    }

    protected function aclIsAllowed($resource, $privilege) {
        return $this->getAcl()->isAllowed($this->getAuthRole(), $resource, $privilege);
    }

}
