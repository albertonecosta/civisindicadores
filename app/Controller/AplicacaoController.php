<?php
/**
 * 
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
 *
 */
App::uses('AppController', 'Controller');
/**
 * Aplicacao Controller
 *
 * @property Aplicacao $Aplicacao
 * @property SessionComponent $Session
 */
class AplicacaoController extends AppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function beforeRender(){
		parent::beforeRender();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		
		/**
		 *
		 * Consultando as informaçoes de projetos
		 *
		 */
		
		$this->loadModel('Projeto');
		$projeto = $this->Projeto->query("select projeto.id, projeto.titulo, atividade.status,count(atividade.id) as totalatividade from projeto left join atividade on atividade.projeto_id=projeto.Id where (projeto.status <> ".Util::INATIVO." and atividade.status <> ".Util::INATIVO.") group by atividade.status,projeto.id,projeto.titulo,projeto.data_inicio_previsto order by projeto.data_inicio_previsto ASC");
		
		$projetos =  array();
		foreach($projeto as $vetorProjeto){
			$projetos[$vetorProjeto[0]["id"]]["titulo"]=$vetorProjeto[0]["titulo"];
			$projetos[$vetorProjeto[0]["id"]][$vetorProjeto[0]["status"]]=$vetorProjeto[0]["totalatividade"];
			
			
		}
		
		/**
		 *
		 * Consultando as informaçoes de tarefas somente do usuário logado
		 *
		 */
		
		$this->loadModel("Tarefa");
		$tarefa = $this->Tarefa->query("select tarefa.id,tarefa.titulo as Tarefa,pessoa.titulo as Pessoa,data_fim_previsto 
										from Tarefa inner join usuario on usuario.id = tarefa.responsavel_id 
										inner join pessoa on pessoa.id = usuario.pessoa_id
										where (responsavel_id='".$this->usuarioLogado["id"]."' or supervisor_id='".$this->usuarioLogado["id"]."') and tarefa.status <> 5 and tarefa.status <> ".Util::INATIVO." order by data_fim_previsto ASC");
		//$tarefas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status != ' => Util::INATIVO,'Tarefa.responsavel_id' => '25'), 'order' => array('Tarefa.data_fim_previsto', 'Tarefa.data_fim_previsto DESC'),));
		$tarefas = array();
		foreach($tarefa as $vetorTarefa){
			$tarefas[]=$vetorTarefa[0];
		}
		
		$this->loadModel("Post");
		$post = $this->Post->query("select post.id,postpai.mensagem as post,post.mensagem,pessoa.titulo as pessoa,post.created
										from post as postpai inner join usuario on usuario.id = postpai.usuario_id
										inner join pessoa on pessoa.id = usuario.pessoa_id
										inner join post on postpai.id = post.post_id
										 
									
										order by post.created ASC");
		//$tarefas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status != ' => Util::INATIVO,'Tarefa.responsavel_id' => '25'), 'order' => array('Tarefa.data_fim_previsto', 'Tarefa.data_fim_previsto DESC'),));
		$posts = array();
		foreach($post as $vetorPost){
			$posts[]=$vetorPost[0];
		}
		
		/**
		 *
		 * Calculando o andamento das ações estratégicas
		 *
		 */
		
		$this->loadModel("AcaoEstrategica");
		$acaoEstrategica = $this->AcaoEstrategica->query("select * from objetivo where tipo = 2 and status <> 0");
		
		$acoesEstrategicas = array();
		foreach($acaoEstrategica as $vetorAcaoEstrategica){
			$acoesEstrategicas[]= $vetorAcaoEstrategica[0];
		}
		
		@$indicadores["QtdeAcoesEstrategicas"] = count($acoesEstrategicas);		
		
		$somaAndamento = 0;
		$qtdeAcoesInformadas = 0;
		
		foreach ($acoesEstrategicas as $acaoEstrategica){			
			if ($acaoEstrategica['andamento'] <> ""){
				$qtdeAcoesInformadas++;
				$somaAndamento += str_replace("%", "", $acaoEstrategica['andamento']);
			}
		}
		
		@$indicadores["ExecucaoPDTI"] = number_format($somaAndamento/$qtdeAcoesInformadas,2,'.',',');
		
		@$indicadores["AcoesMonitoradas"] = $qtdeAcoesInformadas;
		@$indicadores["PercentualAcoesMonitoradas"] = number_format($qtdeAcoesInformadas*100/count($acoesEstrategicas),2,'.',',');
		
		/**
		 * 
		 * Calculando quantos dias em média as ações estão cadastradas 
		 * 
		 */
		$this->loadModel('Atividade');
		$atividade = $this->Atividade->query("Select status,count(id) as total ,sum(data_fim_previsto-data_inicio_previsto) as calculo from atividade where atividade.status <> ".Util::INATIVO." group by status");
		$totalAcoes=0;
		$totalDatas=0;
		foreach($atividade as $vetorAtividade){
			
			$vetorAtividade[0]["calculo"]/$vetorAtividade[0]["total"];
			$totalAcoes+=$vetorAtividade[0]["total"];
			$totalDatas+=$vetorAtividade[0]["calculo"];
			$indicadores["diasAcoes"]=floor($totalDatas/$totalAcoes);
			$indicadores["Status"][$vetorAtividade[0]["status"]]=$vetorAtividade[0]["total"];
			if ($vetorAtividade[0]["status"]==5)
				$concluidas = $vetorAtividade[0]["total"];
		}
		@$indicadores["acoesConcluidas"]=number_format((($concluidas*100)/$totalAcoes),2,'.',',');
		
		/**
		 *
		 * Calculando por mês quantas tarefas serão concluídas
		 *
		 */
		
		$atividade = $this->Atividade->query("Select count(id) as total,extract(month from data_fim_previsto) as mes from atividade where atividade.status <> ".Util::INATIVO." group by extract(month from data_fim_previsto)");
	
		foreach($atividade as $vetorAtividade){		
			$indicadores["acoesPrevistas"][$vetorAtividade[0]["mes"]] = $vetorAtividade[0]["total"];
		}
	
		for($meses=1;$meses<13;$meses++){		
				if(!isset($indicadores["acoesPrevistas"][$meses]))			
					$indicadores["acoesPrevistas"][$meses]='1';
		}
		
		$this->set('indicadores', $indicadores);
		$this->set('posts', $posts);
		$this->set('projetos', $projetos);
		$this->set('tarefas', $tarefas);
		
		
	}
}

