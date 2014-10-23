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
			'Visualizar'=>array('Procedimento.visualizar.action', 'Procedimento.visualizar.element'),
			'Imprimir'=>array('Procedimento.imprimir.action','Procedimento.imprimir.element')
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
			'Visualizar'=>array('Acao.visualizar.action', 'Acao.visualizar.element'),
			'Imprimir'=>array('Acao.imprimirIndex.action', 'Acao.imprimirTodosResponsavel.action', 'Acao.imprimirTodosSupervisor.action' ,'Acao.imprimir.element'),
			'Listar Forum'=>array('Acao.listar_forum.element'),
			'Adicionar Forum'=>array('Acao.adicionar_forum.element')
		),'Dimensões'=>array(
			'Adicionar'=>array('Dimensao.adicionar.action', 'Dimensao.adicionar.element'),
			'Excluir'=>array('Dimensao.excluir.action', 'Dimensao.excluir.element'),
			'Editar'=>array('Dimensao.editar.action', 'Dimensao.editar.element'),
			'Listar'=>array('Dimensao.index.action', 'Dimensao.listar.element'),
			'Visualizar'=>array('Dimensao.visualizar.action', 'Dimensao.visualizar.element')
		),'Objetivos'=>array(
			'Adicionar'=>array('Objetivo.adicionar.action', 'Objetivo.adicionar.element'),
			'Excluir'=>array('Objetivo.excluir.action', 'Objetivo.excluir.element'),
			'Editar'=>array('Objetivo.editar.action', 'Objetivo.editar.element'),
			'Listar'=>array('Objetivo.index.action', 'Objetivo.listar.element'),
			'Visualizar'=>array('Objetivo.visualizar.action', 'Objetivo.visualizar.element')
		),'Indicadores'=>array(
			'Adicionar'=>array('Indicador.adicionar.action', 'Indicador.adicionar.element'),
			'Excluir'=>array('Indicador.excluir.action', 'Indicador.excluir.element'),
			'Editar'=>array('Indicador.editar.action', 'Indicador.editar.element'),
			'Listar'=>array('Indicador.index.action', 'Indicador.listar.element'),
			'Visualizar'=>array('Indicador.visualizar.action', 'Indicador.visualizar.element')
		),'Indicadores'=>array(
			'Adicionar'=>array('Indicador.adicionar.action', 'Indicador.adicionar.element'),
			'Excluir'=>array('Indicador.excluir.action', 'Indicador.excluir.element'),
			'Editar'=>array('Indicador.editar.action', 'Indicador.editar.element'),
			'Listar'=>array('Indicador.index.action', 'Indicador.listar.element'),
			'Visualizar'=>array('Indicador.visualizar.action', 'Indicador.visualizar.element')
		),'Ações'=>array(
			'Adicionar'=>array('Medida.adicionar.action', 'Medida.adicionar.element'),
			'Excluir'=>array('Medida.excluir.action', 'Medida.excluir.element'),
			'Editar'=>array('Medida.editar.action', 'Medida.editar.element'),
			'Listar Ações Estratégicas'=>array('Medida.index.action', 'Medida.listar.element'),
			'Listar Revisão das Ações'=>array('Medida.indice_revisao.action', 'Medida.listar_revisao.element'),
			'Listar Painel Geral de Ações'=>array('Medida.painel_acoes.action', 'Medida.listar_painel.element'),
			'Visualizar'=>array('Medida.visualizar.action', 'Medida.visualizar.element'),
			'Exibir Gráfico'=>array('Medida.grafico.element')
		),'Faixas'=>array(
			'Adicionar'=>array('Faixa.adicionar.action', 'Faixa.adicionar.element'),
			'Excluir'=>array('Faixa.excluir.action', 'Faixa.excluir.element'),
			'Editar'=>array('Faixa.editar.action', 'Faixa.editar.element'),
			'Listar'=>array('Faixa.index.action', 'Faixa.listar.element'),
			'Visualizar'=>array('Faixa.visualizar.action', 'Faixa.visualizar.element')
		),'Anomalias'=>array(
			'Adicionar'=>array('Anomalia.adicionar.action', 'Anomalia.adicionar.element'),
			'Excluir'=>array('Anomalia.excluir.action', 'Anomalia.excluir.element'),
			'Editar'=>array('Anomalia.editar.action', 'Anomalia.editar.element'),
			'Listar'=>array('Anomalia.index.action', 'Anomalia.listar.element'),
			'Visualizar'=>array('Anomalia.visualizar.action', 'Anomalia.visualizar.element'),
			'Painel'=>array('Anomalia.painel.element')
		),'Projetos'=>array(
			'Adicionar'=>array('Projeto.adicionar.action', 'Projeto.adicionar.element'),
			'Excluir'=>array('Projeto.excluir.action', 'Projeto.excluir.element'),
			'Editar'=>array('Projeto.editar.action', 'Projeto.editar.element'),
			'Listar'=>array('Projeto.index.action', 'Projeto.listar.element'),
			'Visualizar'=>array('Projeto.visualizar.action', 'Projeto.visualizar.element'),
			'Imprimir'=>array('Projeto.imprimir.action', 'Projeto.imprimir.element'),
			'Cronograma'=>array('Projeto.cronograma.element')
		),'Programas'=>array(
			'Adicionar'=>array('Programa.adicionar.action', 'Programa.adicionar.element'),
			'Excluir'=>array('Programa.excluir.action', 'Programa.excluir.element'),
			'Editar'=>array('Programa.editar.action', 'Programa.editar.element'),
			'Listar'=>array('Programa.index.action', 'Programa.listar.element'),
			'Visualizar'=>array('Programa.visualizar.action', 'Programa.visualizar.element'),
			'Imprimir'=>array('Programa.imprimir.action', 'Programa.imprimir.element')
		),'Mapa Estratégico'=>array(
			'Listar'=>array('MapaEstrategico.index.action', 'MapaEstrategico.listar.element')
		),'Organograma'=>array(
			'Listar'=>array('Organograma.index.action', 'Organograma.listar.element')
		)
	);

	public function __construct($nameAction, $nameController){
		$this->Usuario = new Usuario();
		$this->Grupo = new Grupo();
		$this->Permissao = new Permissao();
		$this->nomeAcao = $nameAction;
		$this->nomeControlador = $nameController;
		if(isset($_SESSION["Auth"]["Indicadores"]))
			$this->user = $_SESSION["Auth"]["Indicadores"];
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