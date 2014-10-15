<?php
App::uses('AppController', 'Controller');
/**
 * Aplicacao Controller
 *
 * @property Aplicacao $Aplicacao
 * @property SessionComponent $Session
 */
class AplicacaoController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('Projeto');
		$projeto = $this->Projeto->query("select projeto.id, projeto.titulo, acao.status,count(acao.id) as totalacao from projeto left join acao on acao.projeto_id=projeto.Id where (projeto.status <> ".Util::INATIVO." and acao.status <> ".Util::INATIVO.") group by acao.status,projeto.id,projeto.titulo,projeto.data_inicio_previsto order by projeto.data_inicio_previsto ASC");
		
		$projetos =  array();
		foreach($projeto as $vetorProjeto){
			$projetos[$vetorProjeto[0]["id"]]["titulo"]=$vetorProjeto[0]["titulo"];
			$projetos[$vetorProjeto[0]["id"]][$vetorProjeto[0]["status"]]=$vetorProjeto[0]["totalacao"];
			
			
		}
		
		
		$this->loadModel("Tarefa");
		$tarefa = $this->Tarefa->query("select tarefa.id,tarefa.titulo as Tarefa,pessoa.titulo as Pessoa,data_fim_previsto 
										from Tarefa inner join usuario on usuario.id = tarefa.responsavel_id 
										inner join pessoa on pessoa.id = usuario.pessoa_id
										where (responsavel_id='".$_SESSION["Auth"]["User"]["id"]."' or supervisor_id='".$_SESSION["Auth"]["User"]["id"]."') and tarefa.status <> 5 and tarefa.status <> ".Util::INATIVO." order by data_fim_previsto ASC");
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
		
		
		$this->loadModel("Medida");
		$medida = $this->Medida->query("select * from objetivo where tipo = 2 and status <> 0");
		
		$medidas = array();
		foreach($medida as $vetorMedida){
			$medidas[]= $vetorMedida[0];
		}
		
		@$indicadores["QtdeAcoesEstrategicas"] = count($medidas);		
		
		$somaAndamento = 0;
		$qtdeAcoesInformadas = 0;
		
		foreach ($medidas as $medida){			
			if ($medida['andamento'] <> ""){
				$qtdeAcoesInformadas++;
				$somaAndamento += str_replace("%", "", $medida['andamento']);
			}
		}
		
		@$indicadores["ExecucaoPDTI"] = number_format($somaAndamento/$qtdeAcoesInformadas,2,'.',',');
		
		@$indicadores["AcoesMonitoradas"] = $qtdeAcoesInformadas;
		@$indicadores["PercentualAcoesMonitoradas"] = number_format($qtdeAcoesInformadas*100/count($medidas),2,'.',',');
		
		/**
		 * 
		 * Calculando quantos dias em média as ações estão cadastradas 
		 * 
		 */
		$this->loadModel('Acao');
		$acao = $this->Acao->query("Select status,count(id) as total ,sum(data_fim_previsto-data_inicio_previsto) as calculo from acao where acao.status <> ".Util::INATIVO." group by status");
		$totalAcoes=0;
		$totalDatas=0;
		foreach($acao as $vetorAcao){
			
			$vetorAcao[0]["calculo"]/$vetorAcao[0]["total"];
			$totalAcoes+=$vetorAcao[0]["total"];
			$totalDatas+=$vetorAcao[0]["calculo"];
			$indicadores["diasAcoes"]=floor($totalDatas/$totalAcoes);
			$indicadores["Status"][$vetorAcao[0]["status"]]=$vetorAcao[0]["total"];
			if ($vetorAcao[0]["status"]==5)
				$concluidas = $vetorAcao[0]["total"];
		}
		@$indicadores["acoesConcluidas"]=number_format((($concluidas*100)/$totalAcoes),2,'.',',');
		
		/**
		 *
		 * Calculando por mês quantas tarefas serão concluídas
		 *
		 */
		
		$acao = $this->Acao->query("Select count(id) as total,extract(month from data_fim_previsto) as mes from acao where acao.status <> ".Util::INATIVO." group by extract(month from data_fim_previsto)");
			
		foreach($acao as $vetorAcao){
			$indicadores["acoesPrevistas"][$vetorAcao[0]["mes"]] = $vetorAcao[0]["total"];
		}

		$this->set('indicadores', $indicadores);
		$this->set('posts', $posts);
		$this->set('projetos', $projetos);
		$this->set('tarefas', $tarefas);
		
		
	}
}

