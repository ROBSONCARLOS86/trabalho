<?php

class IndexController extends Prato_Controller_Action {

    public function indexAction() {

        $idcategoria = (int) $this->getParam('idcategoria', 0);        

    	$select = $this ->select(); 

        if($idcategoria > 0)
        {
            $select ->where('c.idcategoria  = ?', $idcategoria);
        }
    	

    	$consulta = $select ->query() ->fetchAll();

    	$this ->view ->pratos = $consulta; 


        
    }

    public function categoriasAction() {

    	$dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
    	$select = $dbAdapter ->select();
    	$select ->from(array(
    		'c' => 'categoria'
    	),
    	array('categoria', 'idcategoria'
    	));

    	$consulta = $select ->query() ->fetchAll();

    	$this ->view ->categorias = $consulta; 
        
    }

    public function pratoAction() {

    	$idprato = (int)  $this ->getParam('idprato', 0); 

    	$select = $this ->select();  
    	$select ->where('p.idprato = ?', $idprato);  

    	$prato = $select ->query() ->fetch();  

    	$this ->view ->prato = $prato;   


    }

    private function select() {

    	$dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
    	$select = $dbAdapter ->select();
    	$select ->from(array(
    		'p' => 'prato' 
    	),
    	array('nomeprato', 'preco', 'idprato'  
    	));

    	$select ->joinInner(array(  
    		'c' => 'categoria'
    	), 'p.idcategoria = c.idcategoria',
    	array('categoria'    
    	));

        $select->where("preco > 0"); 

    	return $select;   

    }

}
