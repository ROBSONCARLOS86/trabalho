<?php

class PratoController extends Prato_Controller_Action {

    public function indexAction() {

        $tab = new Application_Model_DbTable_Prato();
        $sql = $tab->getAdapter()->select();
        $sql->from(array(
            "p" => "prato"
                ), array(
            "idprato", "nomeprato", "preco"
        ));
        $sql->joinInner(array(
            "c" => "categoria"
                ), "c.idcategoria = p.idcategoria", array(
            "categoria"
        ));
        $sql->where("p.idcategoria > ?", "0", Zend_Db::INT_TYPE);
        $consultaBd = $sql->query()->fetchAll();
        $this->view->pratos = $consultaBd;
        $this->view->podeApagar = $this->aclIsAllowed('prato', 'delete');
        $this->view->podeAtualizarValor = $this->aclIsAllowed('prato', 'update-valor');
    }

    public function createAction() {
        $auth = Zend_Auth::getInstance();
        $dados = $auth->getStorage()->read();
        $frm = new Application_Form_Prato(Application_Form_Prato::CADASTRO_OR_UPDATE);  

        if ($this->getRequest()->isPost()) {
            $params = $this->getAllParams();

            if ($frm->isValid($params)) {
                $params = $frm->getValues();

                $prato = new Application_Model_Vo_Prato();
                $prato->setIdcategoria($params['idcategoria']);
                $prato->setIdadmin($dados->idadmin);
                $prato->setNomeprato($params['nomeprato']);
                $prato->setPreco(null);

                $model = new Application_Model_Prato();
                $model->salvar($prato);

                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage("prato cadastrado com sucesso");

                $this->_helper->Redirector->gotoSimpleAndExit('index');
            }
        }

        $this->view->frm = $frm;   
    }

    public function deleteAction() {

        $idprato = (int) $this->getParam('idprato', 0);

        $model = new Application_Model_Prato();
        $model->apagar($idprato);

        $flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->addMessage("prato excluido com sucesso");

        $this->_helper->Redirector->gotoSimpleAndExit('index');
    }

    public function updateAction() {
        $auth = Zend_Auth::getInstance();
        $dados = $auth->getStorage()->read();
        $idprato = (int) $this->getParam('idprato', 0);

        $tabela = new Application_Model_DbTable_Prato();
        $linha = $tabela->fetchRow('idprato = ' . $idprato);
        if ($linha === null) {
            echo 'Prato nao existe';
            exit;
        }

        $frm = new Application_Form_Prato(Application_Form_Prato::CADASTRO_OR_UPDATE);

        if ($this->getRequest()->isPost()) {
            $params = $this->getAllParams();  

            if ($frm->isValid($params)) { 
                $params = $frm->getValues();  

                $prato = new Application_Model_Vo_Prato();
                $prato->setIdcategoria($params['idcategoria']);
                $prato->setIdadmin($dados->idadmin);
                $prato->setNomeprato($params['nomeprato']);
                $prato->setPreco(null);
                $prato->setIdprato($idprato);



                $model = new Application_Model_Prato();
                $model->atualizar($prato);


                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage("prato atualizado com sucesso.");

                $this->_helper->Redirector->gotoSimpleAndExit('index');
            }
        } else {   
            $frm->populate(array(

                'idcategoria' => $linha->idcategoria,
                'idadmin' => $linha->idadmin,
                'nomeprato' => $linha->nomeprato,
                'preco' => $linha->preco
            ));
        }

        $this->view->frm = $frm;
    }

    public function updateValorAction() {
        $auth = Zend_Auth::getInstance();
        $dados = $auth->getStorage()->read();
        $idprato = (int) $this->getParam('idprato', 0);

        $tabela = new Application_Model_DbTable_Prato();
        $linha = $tabela->fetchRow('idprato = ' . $idprato);
        if ($linha === null) {
            echo 'Prato nao existe';
            exit;
        }

        $frm = new Application_Form_Prato(Application_Form_Prato::UPDATE_VALOR);

        if ($this->getRequest()->isPost()) {
            $params = $this->getAllParams();  

            if ($frm->isValid($params)) {  
                $params = $frm->getValues();  

                $prato = new Application_Model_Vo_Prato();
                $prato->setPreco($params['preco']);
                $prato->setIdprato($idprato);



                $model = new Application_Model_Prato();
                $model->atualizarValor($prato);


                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage("O prato atualizado com sucesso.");

                $this->_helper->Redirector->gotoSimpleAndExit('index');
            }
            $this->view->prato = $linha;
        } else {  
            $frm->populate(array(

                'idcategoria' => $linha->idcategoria,
                'idadmin' => $linha->idadmin,
                'nomeprato' => $linha->nomeprato,
                'preco' => $linha->preco
            ));
        }

        $this->view->frm = $frm;
        $this->view->prato = $linha;
    }

}
