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

header("Content-type: text/html; charset=UTF-8");

class CronController extends AppController{
	
	public function index(){die;}
	
	public function lembrete_acao_tarefa(){
	
		//if(!defined('CRON_DISPATCHER')){ $this->redirect('/'); exit(); }
		
		$this->loadModel('Tarefa');
		$this->loadModel('Acao');
		$this->loadModel('Pessoa');
		
		$ArrayModelTarefa = $this->Tarefa->find('all', array('fields'=>array('Tarefa.id','Tarefa.responsavel_id','Tarefa.titulo', 'Tarefa.data_inicio_previsto', 'Tarefa.data_fim_previsto','Tarefa.status'),
															'conditions'=>array('Tarefa.lembrete'=>date('Y-m-d'),
																	'OR' => array('Tarefa.status = 2 OR Tarefa.status = 3 OR Tarefa.status = 4')
																	)
															)
													);
		
	
		
		$ArrayModelAcao = $this->Acao->find('all', array('fields'=>array('Acao.id','Acao.responsavel_id','Acao.titulo', 'Acao.data_inicio_previsto', 'Acao.data_fim_previsto','Acao.status'),
														'conditions'=>array('Acao.lembrete'=>date('Y-m-d'),
																'OR' => array('Acao.status = 2 OR Acao.status = 3 OR Acao.status = 4')
																)
														)
												);

		App::uses('CakeEmail', 'Network/Email');
	 	$Email = new CakeEmail('smtp');
		$Email->from(array('contato@civis.com.br' => 'Civis Indicadores'));
	 	$Email->emailFormat('html');
	 	
 		/* -- Tarefas -- */
 		$responsaveis = array();
 		foreach ($ArrayModelTarefa as $tarefa){
 			$responsaveis[$tarefa['Tarefa']['responsavel_id']]['Tarefa'][] = $tarefa['Tarefa'];
 		}
 		
 		/* -- Ações -- */
 		$responsaveisAcao = array();
 		foreach ($ArrayModelAcao as $acao){
 			$responsaveis[$acao['Acao']['responsavel_id']]['Acao'][] = $acao['Acao'];
 		}
 		
 		$mensagem = "";
 		
 		foreach($responsaveis as $idResponsavel=>$registrosResponsavel){
 			
 			$mensagem .= "Lembretes de Hoje:<br><br>";
 				
 			foreach ($registrosResponsavel as $chave=>$registros){
 				
 				if($chave == 'Tarefa'){
 					$mensagem .= "<strong>---- TAREFAS ----</strong> <br>";
 					foreach($registros as $dados){
 						
 						$status_tarefa = "";
 						switch ($dados['status']){
 							case (Util::INATIVO):
 								$status_tarefa = "Inativo";
 								break;
							case (Util::NAO_INICIADO):
 								$status_tarefa = "Não Iniciada";
 								break;
 							case (Util::EM_ANDAMENTO):
 								$status_tarefa = "Em Andamento";
 								break;
 							case (Util::AGUARDANDO_OUTRA_PESSOA):
 								$status_tarefa = "Aguardando outra pessoa";
 								break;
 							case (Util::CONCLUIDO):
 								$status_tarefa = "Concluída";
 								break;
 							case (Util::CANCELADO):
 								$status_tarefa = "Cancelada";
 								break;
 							default:
 								break;
 						}
 						
 						$mensagem .= "<strong>Titulo Tarefa:</strong> " . $dados['titulo'] ."<br>";
 						$mensagem .= "<strong>Data de inicio:</strong> " . $dados["data_inicio_previsto"] ."<br>";
 						$mensagem .= "<strong>Data de fim:</strong> " . $dados["data_fim_previsto"] ."<br>";
 						$mensagem .= "<strong>Status:</strong> " . $status_tarefa ."<br><br>";
 					}
 					
 				}else if($chave == 'Acao'){
 					$mensagem .= "<strong>---- AÇÕES ----</strong><br>";
 					foreach($registros as $dados){
 						
 						switch ($dados['status']){
 							case (Util::ATIVO):
 								$status_tarefa = "Ativo";
 								break;
 							case (Util::INATIVO):
 								$status_tarefa = "Inativo";
 								break;
 							case (Util::EM_ANDAMENTO):
 								$status_tarefa = "Em Andamento";
 								break;
 							case (Util::AGUARDANDO_OUTRA_PESSOA):
 								$status_tarefa = "Aguardando outra pessoa";
 								break;
 							case (Util::CONCLUIDO):
 								$status_tarefa = "Concluída";
 								break;
 							case (Util::CANCELADO):
 								$status_tarefa = "Cancelada";
 								break;
 							default:
 								break;
 						}
 						
	 					$mensagem .= "<strong>Titulo Acao:</strong> " . $dados['titulo'] ."<br>";
	 					$mensagem .= "<strong>Data de inicio:</strong> " . $dados["data_inicio_previsto"] ."<br>";
	 					$mensagem .= "<strong>Data de fim:</strong> " . $dados["data_fim_previsto"] ."<br>";
	 					$mensagem .= "<strong>Status:</strong> " . $status_tarefa ."<br><br>";
 					}
 				}
 			}
 			
 			$Email->subject("[#{$idResponsavel}][Civis Estratégia] Lembretes");
 			
 			/* Email para o responsável*/ 
 			$ArrayModelPessoaResponsavel = $this->Pessoa->find('list', array(
 					'joins'=>array(
 							array(
 									'table'=>'usuario',
 									'alias'=>'Usuario',
 									'type'=>'inner',
 									'conditions'=>array(
 											'Pessoa.id = Usuario.pessoa_id'
 									)
 							)
 					),
 					'conditions'=>array('Usuario.id'=>$idResponsavel),
 					'fields'=>array('titulo','email')
 			));
 				
 			$enviou = false;
 			foreach($ArrayModelPessoaResponsavel as $nome=>$email){
 			
 				if(trim($nome) && trim($email)){
 					$Email->to($email, $nome);
 					if($Email->send($mensagem)){
 						$enviou = true;
 					}
 				}
 			}
 		}
		
		exit; // não tirar este exit, pois este método não possui view
	}
}