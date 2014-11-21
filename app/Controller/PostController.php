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
App::uses('CakeEmail', 'Network/Email');
/**
 * Post Controller
 *
 * @property Post $Post
 * @property SessionComponent $Session
 */
class PostController extends AppController {

	/**
	 * Método que exibe os dados de um determinado post, que tem seu id passado por parâmetro
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {
		try{
			
			$this->Post->id = $id;
			if (empty($id) || !is_numeric($id) || !$this->Post->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			
			$this->Post->recursive = 2;
			$filhos = $this->Post->find('all', array('conditions' => array('Post.post_id' => $id)));
			
			$this->set('post', $this->Post->read(null, $id));
			$this->set('filhos', $filhos);
		
		}catch(Exception $e){
			$this->Session->setFlash($e->getMessage(), 'alert');
			$this->redirect(array("controller"=>"aplicacao", "action"=>"index"));
		}
	}

	/**
	 * Método que adiciona um post vindo da aba de ações
	 *
	 * @return void
	 */
	public function adicionarNaAtividade() {
		if ($this->request->is('post')) {
			$this->request->data['Post']['usuario_id'] = $this->Auth->user('id');
			$this->Post->begin();
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				// Enviando email para todos os participantes da conversa que pediram para serem avisados sobre novas postagens
				$this->enviarEmails(@$this->Post->id, $this->request->data['Post']['mensagem'],"atividade");
				$this->Audit->salvar($this->request->data, "Post", array(), "adicionar", true, $this->Post->id, $this->Auth->user("id"));
				$this->Post->commit();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
			} else {
				$this->Post->rollback();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
			$this->redirect(array('controller' => 'Atividade', 'action' => 'visualizar', $this->request->data['Post']['atividade_id']));
		}
		exit;
	}
	
	/**
	 * Método que adiciona um post vindo da aba de tarefas
	 *
	 * @return void
	 */
	public function adicionarNaTarefa() {
		
		if ($this->request->is('post')) {
			$this->request->data['Post']['usuario_id'] = $this->Auth->user('id');
			$this->Post->begin();
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				
				// Enviando email para todos os participantes da conversa que pediram para serem avisados sobre novas postagens
				$this->enviarEmails(@$this->Post->id, $this->request->data['Post']['mensagem'],"tarefa");
				$this->enviarEmailsPost(@$this->request->data['Post']['post_id'], $this->request->data['Post']['mensagem']);
				$this->Audit->salvar($this->request->data, "Post", array(), "adicionar", true, $this->Post->id, $this->Auth->user("id"));
				$this->Post->commit();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
			} else {
				$this->Post->rollback();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
			$this->redirect(array('controller' => 'Tarefa', 'action' => 'visualizar', $this->request->data['Post']['tarefa_id']));
		}
		exit;
	}
	
	/**
	 * Método que envia emails de notificação do novas mensagens para os responsáveis pelas ações/tarefas ou projetos
	 * @param Integer $id
	 * @param String $mensagem
	 */
	private function enviarEmails($id, $mensagem,$modulo){
		/*
		// Busca pelo tipo de comentário, se foi inserido numa tarefa ou numa ação.
		if ($modulo=="atividade"){
		
				$responsaveis = $this->Post->query("Select 
				presponsavel.titulo as responsavelt,
				presponsavel.email as emailrt,
				psupervisor.titulo as supervisort,
				psupervisor.email as emailst,
				pgerente.titulo as gerente,
				pgerente.email as emailg, 
				projeto.titulo as projeto,
				atividade.titulo as titulo
				from post
				left join atividade on atividade.id=post.atividade_id
				left join projeto on projeto.id=atividade.projeto_id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				left join usuario as responsavel on responsavel.id=atividade.responsavel_id 
				left join usuario as supervisor on supervisor.id=atividade.supervisor_id				
				left join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				left join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				left join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				where post.id='$id'");
		}else{
			$responsaveis = $this->Post->query("Select 
				presponsavel.titulo as responsavel,
				presponsavel.email as emailr,
				psupervisor.titulo as supervisor,
				psupervisor.email as emails,
				presponsavelt.titulo as responsavelt,
				presponsavelt.email as emailrt,
				psupervisort.titulo as supervisort,
				psupervisort.email as emailst,
				pgerente.titulo as gerente,
				pgerente.email as emailg, 
				projeto.titulo as projeto,
				tarefa.titulo as titulo
				from post
				left join tarefa on tarefa.id=post.tarefa_id
				left join atividade on atividade.id=tarefa.atividade_id
				left join projeto on projeto.id=atividade.projeto_id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				left join usuario as responsavelt on responsavelt.id=tarefa.responsavel_id 
				left join usuario as supervisort on supervisort.id=tarefa.supervisor_id				
				left join pessoa as presponsavelt on responsavelt.pessoa_id=presponsavelt.id
				left join pessoa as psupervisort on supervisort.pessoa_id=psupervisort.id
				left join usuario as responsavel on responsavel.id=atividade.responsavel_id 
				left join usuario as supervisor on supervisor.id=atividade.supervisor_id				
				left join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				left join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				left join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				where post.id='$id'");
		}
		// Envio de email para o responsavel e supervisor da tarefa na hora da primeira inserção				
		$userLogado = $this->Auth->user();
		$nomeUserLogado = $userLogado['Pessoa']['titulo'];
		$assunto = "O usuário $nomeUserLogado efetuou um comentário";
		$emails = $responsaveis[0][0];
 
	
		// Envio de email para o responsável da ação
		$conteudo="";
		$Email = new CakeEmail('smtp');
		$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
		$Email->to($emails["emailrt"], $emails["responsavelt"]);
		$Email->emailFormat('html');
		$Email->template('post');
		
		$conteudo .= "Prezado(a) ".$emails["responsavelt"].", uma $modulo de sua reponsabilidade acaba de receber um comentário";
		$conteudo .= " de $nomeUserLogado.";
		$Email->viewVars(array('titulo' => $emails["titulo"],
		'post' => $mensagem,
		'modulo' => $modulo,
		'conteudo' => $conteudo));
		$Email->subject($assunto);
		$Email->send();

		// Envio de email para o supervisor da ação
		$conteudo="";
		$Email = new CakeEmail('smtp');
		$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
		$Email->to($emails["emailst"], $emails["supervisort"]);
		$Email->emailFormat('html');
		$Email->template('post');
		
		$conteudo .= "Prezado(a) ".$emails["supervisort"].", uma $modulo de sua supervisão acaba de receber um comentário";
		$conteudo .= " de $nomeUserLogado.";
		$Email->viewVars(array('titulo' => $emails["titulo"],
				'post' => $mensagem,
				'modulo' => $modulo,
				'conteudo' => $conteudo));
		$Email->subject($assunto);
		$Email->send();
		*/
	}
	
	/**
	 * Método que envia emails de notificação do novas mensagens para os participantes do forum que marcaram de desejam saber sobre atualizações no post
	 * @param Integer $idPostPai
	 * @param String $mensagem
	 */
	private function enviarEmailsPost($idPostPai, $mensagem){
		/*
		if(empty($idPostPai)) return;
		// Busca pelo tipo de comentário, se foi inserido numa tarefa ou numa ação.
		
			$responsaveis = $this->Post->query("Select 
				presponsavel.titulo as responsavel,
				presponsavel.email as emailr,
				psupervisor.titulo as supervisor,
				psupervisor.email as emails,
				presponsavelt.titulo as responsavelt,
				presponsavelt.email as emailrt,
				psupervisort.titulo as supervisort,
				psupervisort.email as emailst,
				pgerente.titulo as gerente,
				pgerente.email as emailg, 
				projeto.titulo as projeto,
				tarefa.titulo as titulo,
				presponsavelc.titulo as comentador,
				presponsavelc.email as emailc, 
				postpai.receber_email,
				postpai.mensagem
				from post
				inner join post as postpai on postpai.id=post.post_id
				left join tarefa on tarefa.id=postpai.tarefa_id
				left join atividade on atividade.id=tarefa.atividade_id
				left join projeto on projeto.id=atividade.projeto_id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				left join usuario as responsavelt on responsavelt.id=tarefa.responsavel_id 
				left join usuario as supervisort on supervisort.id=tarefa.supervisor_id				
				left join usuario as responsavel on responsavel.id=atividade.responsavel_id 
				left join usuario as supervisor on supervisor.id=atividade.supervisor_id				
				left join pessoa as presponsavelt on responsavelt.pessoa_id=presponsavelt.id
				left join pessoa as psupervisort on supervisort.pessoa_id=psupervisort.id
				left join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				left join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				left join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				left join usuario as comentador on comentador.id=postpai.usuario_id				
				left join pessoa as presponsavelc on comentador.pessoa_id=presponsavelc.id
				where post.post_id='$idPostPai'");
		
			// Envio de email para quem pediu para ser avisado após um comentário.
			// caso o post não tenha pai, o post não se trata de uma resposta, portanto não faz nada
	
			$userLogado = $this->Auth->user();
			$nomeUserLogado = $userLogado['Pessoa']['titulo'];
			$assunto = "O usuário $nomeUserLogado efetuou um comentário";
			$emails = $responsaveis[0][0];
			
			// caso o post pai tenha marcado para não receber emails a cada resposta, não faz mais nada
			if(!$emails["receber_email"]) return;
			
			$conteudo="";
			$Email = new CakeEmail('smtp');
			$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
			$Email->to($emails["emailc"], $emails["comentador"]);
			$Email->emailFormat('html');
			$Email->template('post');
	
			$conteudo .= "Prezado(a) ".$emails["comentador"].", seu comentário acaba de ser respondido";
			$conteudo .= " por $nomeUserLogado.";
			$Email->viewVars(array('titulo' => $emails["titulo"],
					'post' => $mensagem,
					'modulo' => "Tarefa",
					'conteudo' => $conteudo));
			$Email->subject($assunto);
			$Email->send();
	
			// Envio de email ao responsável da tarefa
			$conteudo="";
			$Email = new CakeEmail('smtp');
			$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
			$Email->to($emails["emailrt"], $emails["responsavelt"]);
			$Email->emailFormat('html');
			$Email->template('post');
			
			$conteudo .= "Prezado(a) ".$emails["responsavelt"].", o comentário abaixo acaba de ser respondido por $nomeUserLogado ";
			$conteudo .= "em uma tarefa de sua responsabilidade ";
			$conteudo .= "<br><br><b>Comentário Anterior:</b> ".$emails["mensagem"];
			$Email->viewVars(array('titulo' => $emails["titulo"],
					'post' => $mensagem,
					'modulo' => "Tarefa",
					'conteudo' => $conteudo));
			$Email->subject($assunto);
			$Email->send();
			
			// Envio de email ao supervisor da tarefa
			//$emails["emailst"]="oto@civis.com.br";
			$conteudo="";
			$Email = new CakeEmail('smtp');
			$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
			$Email->to($emails["emailst"], $emails["supervisort"]);
			$Email->emailFormat('html');
			$Email->template('post');
				
			$conteudo .= "Prezado(a) ".$emails["supervisort"].", o comentário abaixo acaba de ser respondido por $nomeUserLogado ";
			$conteudo .= "em uma tarefa de sua supervisão.";
			$conteudo .= "<br><br><b>Comentário Anterior:</b> ".$emails["mensagem"];
			$Email->viewVars(array('titulo' => $emails["titulo"],
					'post' => $mensagem,
					'modulo' => "Tarefa",
					'conteudo' => $conteudo));
			$Email->subject($assunto);
			$Email->send();
	*/		
	}
	
}
