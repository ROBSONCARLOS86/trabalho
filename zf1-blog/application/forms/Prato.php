<?php

class Application_Form_Prato extends Zend_Form {

    const CADASTRO_OR_UPDATE = 1;
    const UPDATE_VALOR = 2;

    public function __construct($form) {
       parent::__construct();
        switch ($form) {
            case 1:
                $this->updateCadastrar();
                break;
            case 2:
                $this->updateValor();
                break;
            default :
                break;
        }
    }

    public function updateCadastrar() {
        $this->setMethod('post');

        $nomeprato = new Zend_Form_Element_Text('nomeprato', array(
            'label' => 'Nome do Prato: ',
            'required' => true
            ));  

        $this->addElement($nomeprato);

        $categoria = new Zend_Form_Element_Select('idcategoria', array(
            'label' => 'Categoria',
            'required' => true
        ));

        $this->addElement($categoria);

        $categoria->setMultiOptions($this->pegarCategorias()); 
  
        $f = new Zend_Filter_Null();  
        $categoria->addFilter($f);   

        $botao = new Zend_Form_Element_Submit('botao', array(
            'label' => 'Salvar'
        ));

        $this->addElement($botao);
    }

    public function pegarCategorias() {

        $tab = new Application_Model_DbTable_Categoria();  

        $categorias = $tab->fetchAll()->toArray();   

        $options = array();
        $options[0] = 'Selecione uma Categoria';
        foreach ($categorias as $item) {   
            $idcategoria = $item['idcategoria'];  
            $nomeCategoria = $item['categoria'];  

            $options[$idcategoria] = $nomeCategoria;
        }

        return $options;
    }

    public function pegarLogin() {

        $tabela = new Application_Model_DbTable_Admin();

        $loginAdmin = $tabela->fetchAll()->toArray();

        $options = array();
        $options[0] = 'Selecione';
        foreach ($loginAdmin as $item) {
            $idadmin = $item['idadmin'];
            $nome = $item['nome'];

            $options[$idadmin] = $nome;
        }

        return $options;
    }

    public function updateValor() {
        $this->setMethod('post');
        $preco = new Zend_Form_Element_Text('preco', array(
            'label' => 'Preço do Prato R$ :',
            'required' => true
        ));

        $this->addElement($preco);   
        
        $botao = new Zend_Form_Element_Submit('botao', array(
            'label' => 'Salvar'
        ));

        $this->addElement($botao);
    }

}
