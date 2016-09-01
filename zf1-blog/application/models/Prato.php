<?php

class Application_Model_Prato {

    public function apagar($idprato) {

    	$tabela = new Application_Model_DbTable_Prato();
        $tabela ->delete("idprato = $idprato");   

        return true;
        
    }

    public function atualizar(Application_Model_Vo_Prato $prato) {

        $tabela = new Application_Model_DbTable_Prato();  
        $tabela ->update(array('idprato' => $prato ->getIdprato(),
            'idcategoria' => $prato ->getIdcategoria(),
            'idadmin' => $prato ->getIdadmin(),
            'nomeprato' => $prato ->getNomeprato(),
            'preco' => $prato ->getPreco(),
        ), 'idprato = ' . $prato ->getIdprato());
        
    }
    public function atualizarValor(Application_Model_Vo_Prato $prato) {

        $tabela = new Application_Model_DbTable_Prato();  
        $tabela ->update(array('idprato' => $prato ->getIdprato(),
            'preco' => $prato ->getPreco(),
        ), 'idprato = ' . $prato ->getIdprato());
        
    }

    public function salvar(Application_Model_Vo_Prato $prato) {

    	$tabela = new Application_Model_DbTable_Prato();
    	$tabela ->insert(array(  
    		  'idcategoria' => $prato ->getIdcategoria(),
    		  'idadmin' => $prato ->getIdadmin(),
    		  'nomeprato' => $prato ->getNomeprato(),
    		  'preco' => $prato ->getPreco()

    		));

    	$id = $tabela ->getAdapter() ->lastInsertId();  
    	$prato ->setIdprato($id);   

    	return true;
        
    }

}
