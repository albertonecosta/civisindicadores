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
		),'Reuniões'=>array(
			'Adicionar'=>array('Reuniao.adicionar.action', 'Reuniao.adicionar.element'),
			'Excluir'=>array('Reuniao.excluir.action', 'Reuniao.excluir.element'),
			'Editar'=>array('Reuniao.editar.action', 'Reuniao.editar.element'),
			'Listar'=>array('Reuniao.index.action', 'Reuniao.listar.element'),
			'Visualizar'=>array('Reuniao.visualizar.action', 'Reuniao.visualizar.element'),
			'Enviar Email'=>array('Reuniao.enviar.action', 'Reuniao.enviar_email.element'),
			'Imprimir'=>array('Reuniao.imprimir.action', 'Reuniao.imprimir.element')
		),'Tarefas'=>array(
			'Adicionar'=>array('Tarefa.adicionar.action', 'Tarefa.adicionar.element'),
			'Excluir'=>array('Tarefa.excluir.action', 'Tarefa.excluir.element'),
			'Editar'=>array('Tarefa.editar.action', 'Tarefa.editar.element'),
			'Listar'=>array('Tarefa.index.action','Tarefa.jobsNaoIniciados.action','Tarefa.jobsEmAndamento.action','Tarefa.jobsConcluidas.action','Tarefa.listar.element'),
			'Visualizar'=>array('Tarefa.visualizar.action', 'Tarefa.visualizar.element'),
			'Imprimir'=>array('Tarefa.imprimirJobsConcluidas.action','Tarefa.imprimirJobsNaoIniciados.action','Tarefa.imprimirJobsEmAndamento.action','Tarefa.imprimir.element'),
			'Listar Forum'=>array('Tarefa.listar_forum.element'),
			'Adicionar Forum'=>array('Tarefa.adicionar_forum.element')
		),'Marcadores'=>array(
			'Adicionar'=>array('Marcador.adicionar.action', 'Marcador.adicionar.element'),
			'Excluir'=>array('Marcador.excluir.action', 'Marcador.excluir.element'),
			'Editar'=>array('Marcador.editar.action', 'Marcador.editar.element'),
			'Listar'=>array('Marcador.index.action', 'Marcador.listar.element'),
			'Visualizar'=>array('Marcador.visualizar.action', 'Marcador.visualizar.element')
		),'Procedimentos'=>array(
			'Adicionar'=>array('Procedimento.adicionar.action', 'Procedimento.adicionar.element'),
			'Excluir'=>array('Procedimento.excluir.action', 'Procedimento.excluir.element'),
			'Editar'=>array('Procedimento.editar.action', 'Procedimento.editar.element'),
			'Listar'=>array('Procedimento.index.action', 'Procedimento.listar.element'),
			'Visualizar'=>array('Procedimento.visualizar.action', 'Procedimento.visualizar.element')
		),'Grupos'=>array(
			'Adicionar'=>array('Grupo.adicionar.action', 'Grupo.adicionar.element'),
			'Excluir'=>array('Grupo.excluir.action', 'Grupo.excluir.element'),
			'Editar'=>array('Grupo.editar.action', 'Grupo.editar.element'),
			'Listar'=>array('Grupo.index.action', 'Grupo.listar.element'),
			'Visualizar'=>array('Grupo.visualizar.action', 'Grupo.visualizar.element')
		),'Setores'=>array(
			'Adicionar'=>array('Setor.adicionar.action', 'Setor.adicionar.element'),
			'Excluir'=>array('Setor.excluir.action', 'Setor.excluir.element'),
			'Editar'=>array('Setor.editar.action', 'Setor.editar.element'),
			'Listar'=>array('Setor.index.action', 'Setor.listar.element'),
			'Visualizar'=>array('Setor.visualizar.action', 'Setor.visualizar.element')
		),'Vínculos'=>array(
			'Adicionar'=>array('Vinculo.adicionar.action', 'Vinculo.adicionar.element'),
			'Excluir'=>array('Vinculo.excluir.action', 'Vinculo.excluir.element'),
			'Editar'=>array('Vinculo.editar.action', 'Vinculo.editar.element'),
			'Listar'=>array('Vinculo.index.action', 'Vinculo.listar.element'),
			'Visualizar'=>array('Vinculo.visualizar.action', 'Vinculo.visualizar.element')
		),'Departamentos'=>array(
			'Adicionar'=>array('Departamento.adicionar.action', 'Departamento.adicionar.element'),
			'Excluir'=>array('Departamento.excluir.action', 'Departamento.excluir.element'),
			'Editar'=>array('Departamento.editar.action', 'Departamento.editar.element'),
			'Listar'=>array('Departamento.index.action', 'Departamento.listar.element'),
			'Visualizar'=>array('Departamento.visualizar.action', 'Departamento.visualizar.element')
		),'Atividades'=>array(
			'Adicionar'=>array('Acao.adicionar.action', 'Acao.adicionar.element'),
			'Excluir'=>array('Acao.excluir.action', 'Acao.excluir.element'),
			'Editar'=>array('Acao.editar.action', 'Acao.editar.element'),
			'Listar'=>array('Acao.index.action', 'Acao.listar.element'),
			'Visualizar'=>array('Acao.visualizar.action', 'Acao.visualizar.element')
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