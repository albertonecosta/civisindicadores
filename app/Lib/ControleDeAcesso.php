<?php
App::import("Model", "Usuario");
App::import("Model", "Grupo");
App::import("Model", "Permissao");

class ControleDeAcesso{

	private $Usuario;	
	private $Grupo;
	private $Permissao;
	private $user;
	private $nomeAcao;
	private $nomeControlador;
	private $acesso;
	/*Controller.action_OR_element.type
	* Exp action:  Principal.addVeiculo.action
	* Exp element: Principal.addVeiculo.element
	*/ 
	private $restricoes = array(
		'Usuários'=>array(
			'Adicionar'=>array('Usuario.adicionar.action', 'Usuario.adicionar.element'),
			'Excluir'=>array('Usuario.excluir.action', 'Usuario.excluir.element'),
			'Editar'=>array('Usuario.editar.action', 'Usuario.editar.element'),
			'Listar'=>array('Usuario.index.action', 'Usuario.listar.element'),
			'Visualizar'=>array('Usuario.visualizar.action', 'Usuario.visualizar.element')
		),'Empresas'=>array(
			'Adicionar'=>array('Empresa.adicionar.action', 'Empresa.adicionar.element'),
			'Excluir'=>array('Empresa.excluir.action', 'Empresa.excluir.element'),
			'Editar'=>array('Empresa.editar.action', 'Empresa.editar.element'),
			'Listar'=>array('Empresa.index.action', 'Empresa.listar.element'),
			'Visualizar'=>array('Empresa.visualizar.action', 'Empresa.visualizar.element')
		),'Cargos'=>array(
			'Adicionar'=>array('Cargo.adicionar.action', 'Cargo.adicionar.element'),
			'Excluir'=>array('Cargo.excluir.action', 'Cargo.excluir.element'),
			'Editar'=>array('Cargo.editar.action', 'Cargo.editar.element'),
			'Listar'=>array('Cargo.index.action', 'Cargo.listar.element'),
			'Visualizar'=>array('Cargo.visualizar.action', 'Cargo.visualizar.element')
		)
	);

	public function __construct($nameAction, $nameController){
		$this->Usuario = new Usuario();
		$this->Grupo = new Grupo();
		$this->Permissao = new Permissao();
		$this->nomeAcao = $nameAction;
		$this->nomeControlador = $nameController;
		if(isset($_SESSION['Auth']['User']))
			$this->user = $_SESSION['Auth']['User'];
	}

	public function validaAcessoAcao($acao='', $controller=''){	
		// Se a ação atual for restrita, será solicitado a permissão ao usuário
		if($this->_acessoRestrito('action', $acao, $controller)){
			return $this->_existePermissao($this->acesso);
		}
	 	return true;
	}
	
	public function validaAcessoElemento($element, $controller=''){
		// Se a ação atual for restrita, será solicitado a permissão ao usuário
		if($this->_acessoRestrito('element', $element, $controller)){
			return $this->_existePermissao($this->acesso);
		}
	 	return true;
	}	
	
	private function _acessoRestrito($tipo, $acao='', $controller=''){
		$this->_montaAcesso($tipo, $acao, $controller);
		foreach($this->restricoes as $restricoes){ 
			foreach($restricoes as $restricao){
				if(in_array($this->acesso, $restricao)){
					return true;	
				}
			}
		}
		return false;
	}
	
	private function _montaAcesso($tipo, $acao='', $controller=''){
		if(!empty($acao)){
			$this->nomeAcao = $acao;
		}
		if(!empty($controller)){
			$this->nomeControlador = $controller;
		}		
		return $this->acesso = $this->nomeControlador.'.'.$this->nomeAcao.'.'.$tipo; 		
	}
	 
	private function _existePermissao($descricao){
		$resp = $this->Usuario->find("all",array(
				'conditions'=> array(
										'Usuario.id'=>$this->user['id'],
										'I.descricao'=>$descricao
									),
                "joins" => array(
                    array(
                        "table" => "permissoes",
                        "alias" => "Permissao",
                        "type" => "INNER",
                        "conditions" => array('Usuario.grupo_id = Permissao.grupo_id')
                    ),
                    array(
                        "table" => "regras",
                        "alias" => "I",
                        "type" => "INNER",
                        "conditions" => array('Permissao.id = I.permissao_id')
                    )
                )
            )
		); 	
		return ($resp)?true:false;
	}
	
	public function setUser($user){
		$this->user = $user;
	}
	
	public function getRestricoes(){
		return $this->restricoes;
	}
	
	public function getRestricoesPorChave($chave){
		$dados = explode('.',$chave);
		if(count($dados)!=2)
			return array();
		$sessao = $dados[0];
		$chave = $dados[1];
		if(isset($this->restricoes[$sessao][$chave]))
			return $this->restricoes[$sessao][$chave];
		return array();
	}
}