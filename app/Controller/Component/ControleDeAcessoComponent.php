<?php
App::import('Lib', 'ControleDeAcesso');
class ControleDeAcessoComponent extends Component{ 
	
	private $ControleDeAcesso;

	public function initialize(Controller $controller){
		$this->ControleDeAcesso = new ControleDeAcesso($controller->action, $controller->name);
	}

	public function validaAcessoAcao($acao='', $controller=''){
		return $this->_getControleDeAcesso()->validaAcessoAcao($acao, $controller);
	}

	private function _getControleDeAcesso(){
		if(!$this->ControleDeAcesso instanceof ControleDeAcesso)
			$this->ControleDeAcesso = new ControleDeAcesso(null, null);
		return $this->ControleDeAcesso;
	}	

	public function getRestricoes(){
		return $this->_getControleDeAcesso()->getRestricoes();
	}	
	
	public function getRestricoesPorChave($chave){
		return $this->_getControleDeAcesso()->getRestricoesPorChave($chave);
	}
}