<?php

class Application_Model_Vo_Prato {

    private $idprato;
    private $idcategoria;
    private $idadmin;
    private $nomeprato;
    private $preco;

    function getIdprato() {
        return $this->idprato;
    }

    function getIdcategoria() {
        return $this->idcategoria;
    }

    function getIdadmin() {
        return $this->idadmin;
    }

    function getNomeprato() {
        return $this->nomeprato;
    }

    function getPreco() {
        return $this->preco;
    }

    function setIdprato($idprato) {
        $this->idprato = $idprato;
    }

    function setIdcategoria($idcategoria) {
        $this->idcategoria = $idcategoria;
    }

    function setIdadmin($idadmin) {
        $this->idadmin = $idadmin;
    }

    function setNomeprato($nomeprato) {
        $this->nomeprato = $nomeprato;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }

}
