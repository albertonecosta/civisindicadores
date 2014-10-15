<?php

App::uses('AppHelper', 'View/Helper');
App::import('Lib', 'ControleDeAcesso');

class ControleDeAcessoHelper extends AppHelper {

	private $ControleDeAcesso;
	
	public function validaAcessoElemento($elemnt, $controller=''){
		return $this->_getControleDeAcesso()->validaAcessoElemento($elemnt, $this->_getController($controller));
	}
	
	public function _getController($controller=''){
		if(empty($controller)){
				$controller = strtoupper(substr($this->request->params['controller'], 0,1)).substr($this->request->params['controller'], 1);
		}
		return $controller;
	}
	
	private function _getControleDeAcesso(){
		if(!$this->ControleDeAcesso instanceof ControleDeAcesso)
			$this->ControleDeAcesso = new ControleDeAcesso(null, null);
		return $this->ControleDeAcesso;
	}
}



