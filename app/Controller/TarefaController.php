<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Tarefa Controller
 *
 * @property Tarefa $Tarefa
 * @property SessionComponent $Session
 */
class TarefaController extends AppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		
		//Verificamos se o Array de dados de busca vem com dados para adicionarmos na sessão		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['Tarefa'])){
				$count = count($_SESSION['Search']['Tarefa']);
				$_SESSION['Search']['Tarefa'][$count]['busca'] = $this->request->data['Tarefa']['busca']; 
           		$_SESSION['Search']['Tarefa'][$count]['buscar_em'] = $this->request->data['Tarefa']['buscar_em']; 
			}else{
				$_SESSION['Search']['Tarefa'][0]['busca'] = $this->request->data['Tarefa']['busca']; 
            	$_SESSION['Search']['Tarefa'][0]['buscar_em'] = $this->request->data['Tarefa']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Tarefa'])){
			foreach($_SESSION['Search']['Tarefa'] as $termo_busca){
				if($termo_busca['buscar_em'] == "data_inicio_previsto" || $termo_busca['buscar_em'] == "data_fim_previsto"){
					$buscar_em = 'TO_CHAR(Reuniao.'.$termo_busca['buscar_em'].",'DD/MM/YYYY') ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
					$this->paginate['conditions'][] = array($buscar_em => $busca);
				}else{
					$buscar_em = 'Reuniao.'.$termo_busca['buscar_em']." ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
					$this->paginate['conditions'][] = array($buscar_em => $busca);
				}
			}
		}
	       
		$limit = 10;
		
		$this->Tarefa->recursive = 2;
		
		$naoIniciadas = $this->Tarefa->find('all', array('conditions' => array('OR' => array('Tarefa.status' => array(Util::NAO_INICIADO, Util::AGUARDANDO_OUTRA_PESSOA)), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		
		$this->set('naoIniciadas', $naoIniciadas);
		
		$iniciadas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status' => Util::EM_ANDAMENTO, isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('iniciadas', $iniciadas);
		
		$concluidas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status' => Util::CONCLUIDO, isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('concluidas', $concluidas);
		
		$this->set("limit", $limit);
		
	}

	/**
	 * excluirFiltro method
	 *
	 * @throws NotFoundException
	 * @param int $filtro
	 * @return void
	 */
	public function excluirFiltro($filtro){
		$this->autoRender = false;
		
		unset($_SESSION['Search']['Tarefa'][$filtro]);
		$this->redirect(array('action' => 'index'));	
	}
	
	
	/**
	 * ImprimirIndex method
	 *
	 * @param int $limit
	 * @return void
	 */
	public function ImprimirIndex($limit = null) {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
	    // Define conditions
    	$filtro = $this->FilterResults->getConditions();
		
		$this->Tarefa->recursive = 2;
		
		$naoIniciadas = $this->Tarefa->find('all', array('conditions' => array('OR' => array('Tarefa.status' => array(Util::NAO_INICIADO, Util::AGUARDANDO_OUTRA_PESSOA)), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		
		$this->set('naoIniciadas', $naoIniciadas);
		
		$iniciadas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status' => Util::EM_ANDAMENTO, isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('iniciadas', $iniciadas);
		
		$concluidas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.status' => Util::CONCLUIDO, isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('concluidas', $concluidas);
		
		$this->set("limit", $limit);
	}

	/**
	 * jobsNaoIniciados method
	 *
	 * @return void
	 */
	public function jobsNaoIniciados() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('OR' => array('Tarefa.status' => Util::NAO_INICIADO, 'Tarefa.status' => Util::AGUARDANDO_OUTRA_PESSOA));
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}
	
	/**
	 * jobsNaoIniciados method
	 *
	 * @return void
	 */
	public function imprimirJobsNaoIniciados() {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('OR' => array('Tarefa.status' => Util::NAO_INICIADO, 'Tarefa.status' => Util::AGUARDANDO_OUTRA_PESSOA));
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}
	
	/**
	 * jobsEmAndamento method
	 *
	 * @return void
	 */
	public function jobsEmAndamento() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('Tarefa.status' => Util::EM_ANDAMENTO);
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}
	
	/**
	 * jobsEmAndamento method
	 *
	 * @return void
	 */
	public function imprimirJobsEmAndamento() {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('Tarefa.status' => Util::EM_ANDAMENTO);
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}
	
	/**
	 * jobsConcluidas method
	 *
	 * @return void
	 */
	public function jobsConcluidas() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('Tarefa.status' => Util::CONCLUIDO);
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}

	/**
	 * imprimirJobsConcluidas method
	 *
	 * @return void
	 */
	public function imprimirJobsConcluidas() {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Tarefa.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
		// Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Tarefa->recursive = 2;
		
		$this->paginate['conditions'][] = array('Tarefa.status' => Util::CONCLUIDO);
		$this->paginate['order'] = array('Tarefa.titulo' => 'asc');
		$this->set('tarefa', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {
		$this->Tarefa->id = $id;
		if (!$this->Tarefa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Tarefa->recursive = 2;
		$this->set('tarefa', $this->Tarefa->read(null, $id));
		
		$this->loadModel("Post");
		$this->Post->recursive = 2;
		$posts = $this->Post->find('all', array('conditions' => array('Post.status' => Util::ATIVO, 'Post.post_id' => null, 'Post.tarefa_id' => $id)));
		
		/* carregando os dados da pessoa dentro do array do post dos filhos, pois o ORM não conseguiu chegar até esse nível */
		$this->loadModel('Usuario');
		foreach($posts as $keyPost=>$post){
			foreach($post['Filhos'] as $keyFilho=>$filho){
				$usuario = $this->Usuario->find('first', array('conditions'=>array('Usuario.id'=>$filho['usuario_id'])));
				$posts[$keyPost]["Filhos"][$keyFilho]["Usuario"]["Pessoa"] = $usuario["Pessoa"];
			}
		}
		
		$this->set('posts', $posts);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Tarefa->create();
			if ($this->Tarefa->save($this->request->data)) {
				$this->enviarEmails($this->Tarefa->id,$this->request->data,"novo");
				$this->Audit->salvar($this->request->data, "Tarefa", array(), "adicionar", true, $this->Tarefa->id, $this->Auth->user("id"));				
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$this->loadModel('Acao');
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		
		$this->set('usuarios', $usuarios);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('acoes', $acoes);
	}
	
	/**
	 * Método que adiciona uma tarefa dentro da página de visualização de uma ação.
	 * @param Integer $acao_id
	 */
	public function adicionarNaAcao($acao_id){
		if ($this->request->is('post')) {
			try{
				$this->Tarefa->create();
				if ($this->Tarefa->save($this->request->data)) {
					$this->Audit->salvar($this->request->data, "Tarefa", array(), "adicionar", true, $this->Tarefa->id, $this->Auth->user("id"));
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				} else {
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
				}
			}catch(Exception $e){
				$this->Session->setFlash(__($e->getMessage()), 'alert');
			}
			$this->redirect(array("controller"=>"acao", "action"=>"visualizar", $acao_id));
		}
		exit;
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function ajaxAdicionar($reuniao_id) {
		$this->layout = "ajax";
		if ($this->request->is('post')) {
			$this->Tarefa->create();
			if ($this->Tarefa->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Tarefa", array(), "adicionar", true, $this->Tarefa->id, $this->Auth->user("id"));				
				echo Util::REGISTRO_ADICIONADO_SUCESSO;
				die;
			} else {
				echo Util::REGISTRO_ADICIONADO_FALHA;
				die;
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$this->loadModel('Acao');
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
		$this->set('acoes', $acoes);
		
		$this->set('reuniao', $reuniao_id);
		$this->set('usuarios', $usuarios);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Tarefa->id = $id;
		
		if (!$this->Tarefa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tarefa->save($this->request->data)) {
				$this->enviarEmails($id,$this->request->data,"edição");
				$this->Audit->salvar($this->request->data, "Tarefa", array(), "editar", false, $id, $this->Auth->user("id"));				
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		
		$this->request->data = $this->Tarefa->read(null, $id);
		$this->loadModel('Acao');
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
		$this->set('acoes', $acoes);
		
		$this->loadModel("Reuniao");
		$reunioes = $this->Reuniao->find('list', array('conditions' => array('Reuniao.status != ' => Util::INATIVO), 'fields' => array('Reuniao.id', 'Reuniao.titulo')));
		$this->set('reunioes', $reunioes);
		
		$this->set('usuarios', $usuarios);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function excluir($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Tarefa->id = $id;
		if (!$this->Tarefa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Tarefa->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Tarefa", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Enviar Emails de inserção, alteração de tarefas
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	private function enviarEmails($id, $mensagem,$tipo='novo'){
		/*
		// caso o post não tenha pai, o post não se trata de uma resposta, portanto não faz nada
		$conteudo="";
		$userLogado = $this->Auth->user();
		$nomeUserLogado = $userLogado['Pessoa']['titulo'];
		if ($tipo=="novo")
		$assunto = "O usuário $nomeUserLogado adicionou uma nova tarefa";
		else
		$assunto = "O usuário $nomeUserLogado editou uma tarefa";
		// pelo o id, busca o post pai que deseja receber email a cada resposta adicionada
		
		
		$responsaveis = $this->Tarefa->query("Select 
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
				projeto.email_tarefa as email_tarefa,
				acao.titulo as acao
				from tarefa
				left join acao on acao.id=tarefa.acao_id
				left join projeto on projeto.id=acao.projeto_id
				inner join usuario as responsavelt on responsavelt.id=tarefa.responsavel_id 
				inner join usuario as supervisort on supervisort.id=tarefa.supervisor_id				
				inner join pessoa as presponsavelt on responsavelt.pessoa_id=presponsavelt.id
				inner join pessoa as psupervisort on supervisort.pessoa_id=psupervisort.id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				left join usuario as responsavel on responsavel.id=acao.responsavel_id 
				left join usuario as supervisor on supervisor.id=acao.supervisor_id				
				left join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				left join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				left join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				where tarefa.id='$id'");
		
		switch ($mensagem["Tarefa"]["status"]){
			case (Util::ATIVO):
				$mensagem["Tarefa"]["status"]="Ativo";
				break;
			case (Util::INATIVO):
				$mensagem["Tarefa"]["status"]= "Inativo";
				break;
			case (Util::EM_ANDAMENTO):
				$mensagem["Tarefa"]["status"]= "Em Andamento";
				break;
			case (Util::AGUARDANDO_OUTRA_PESSOA):
				$mensagem["Tarefa"]["status"]= "Aguardando outra pessoa";
				break;
			case (Util::CONCLUIDO):
				$mensagem["Tarefa"]["status"]= "Concluída";
				break;
			case (Util::NAO_INICIADO):
				$mensagem["Tarefa"]["status"]= "Não Iniciada";
				break;
			case (Util::CANCELADO):
				$mensagem["Tarefa"]["status"]= "Cancelada";
				break;
			default:
				break;
		}

		// Carregando cabeçalho do email do responsável da ação 
		
		$emails = $responsaveis[0][0];
		
		$Email = new CakeEmail('smtp');
		$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
		$Email->to($emails["emailrt"],$emails["responsavelt"]);
		$Email->emailFormat('html');
		$Email->template('tarefa');
		$Email->subject($assunto);
		//montando a mensagem para envio ao responsável
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["responsavelt"].", uma nova tarefa foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como responsável. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["responsavelt"].", você é o responsável da tarefa <b>".$mensagem["Tarefa"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}
		$Email->viewVars(array('titulo' => $mensagem["Tarefa"]["titulo"],
		'inicio' => $mensagem["Tarefa"]["data_inicio_previsto"],
		'fim' => $mensagem["Tarefa"]["data_fim_previsto"],
		'status' => $mensagem["Tarefa"]["status"],
		'responsavel' => $emails["responsavelt"],
		'supervisor' => $emails["supervisort"],
		'comentario' => $mensagem["Tarefa"]["comentario"],
		'conclusao' => $mensagem["Tarefa"]["data_conclusao"],
		'conteudo' => $conteudo));
		$Email->send($conteudo);
		
		// Carregando cabeçalho do email do supervisor da ação
		
		
		$conteudo="";
		$Email = new CakeEmail('smtp');
		$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
		$Email->to($emails["emailst"],$emails["supervisort"]);
		$Email->emailFormat('html');
		$Email->template('tarefa');
		$Email->subject($assunto);
		
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["supervisort"].", uma nova tarefa foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como supervisor. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["supervisort"].", você é o supervisor da tarefa <b>".$mensagem["Tarefa"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}	

		//montando a mensagem para envio ao responsável
		$Email->viewVars(array('titulo' => $mensagem["Tarefa"]["titulo"],
		'inicio' => $mensagem["Tarefa"]["data_inicio_previsto"],
		'fim' => $mensagem["Tarefa"]["data_fim_previsto"],
		'status' => $mensagem["Tarefa"]["status"],
		'responsavel' => $emails["responsavelt"],
		'supervisor' => $emails["supervisort"],
		'comentario' => $mensagem["Tarefa"]["comentario"],
		'conclusao' => $mensagem["Tarefa"]["data_conclusao"],
		'conteudo' => $conteudo));

		$Email->send();
		
		
		if (isset($emails["acao"])){
			// Carregando cabeçalho do email do gerente do projeto
			$conteudo="";
			$Email = new CakeEmail('smtp');
			$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
			$Email->to($emails["emailr"],$emails["responsavel"]);
			$Email->emailFormat('html');
			$Email->template('tarefa');
			$Email->subject($assunto);
			
			//montando a mensagem para envio ao responsável
			if ($tipo=="novo"){
				$conteudo .= "Prezado(a) ".$emails["responsavel"].", você é o responsável da ação <b>".$emails["acao"]."</b>";
				$conteudo .= " e uma nova tarefa foi cadastrada a essa ação por $nomeUserLogado. <Br><br><b>Seguem abaixo os dados:</b><Br>";

			}else{
				$conteudo .= "Prezado ".$emails["responsavel"].", você é o responsável da ação <b>".$emails["acao"]."</b>";
				$conteudo .= " e uma tarefa acaba de ser alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo novos dados:</b><Br>";
			}
			//montando a mensagem para envio ao gerente
			$Email->viewVars(array('titulo' => $mensagem["Tarefa"]["titulo"],
			'inicio' => $mensagem["Tarefa"]["data_inicio_previsto"],
			'fim' => $mensagem["Tarefa"]["data_fim_previsto"],
			'status' => $mensagem["Tarefa"]["status"],
			'responsavel' => $emails["responsavelt"],
			'supervisor' => $emails["supervisort"],
			'comentario' => $mensagem["Tarefa"]["comentario"],
			'conclusao' => $mensagem["Tarefa"]["data_conclusao"],
			'conteudo' => $conteudo));
			
			$Email->send();
			
			$conteudo="";
			$Email = new CakeEmail('smtp');
			$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
			$Email->to($emails["emailg"],$emails["gerente"]);
			$Email->emailFormat('html');
			$Email->template('tarefa');
			$Email->subject($assunto);
			
			//montando a mensagem para envio ao responsável
			if ($tipo=="novo"){
				$conteudo .= "Prezado ".$emails["supervisor"].", você é o supervidor da ação <b>".$emails["acao"]."</b>";
				$conteudo .= " e uma nova tarefa foi cadastrada a essa ação por $nomeUserLogado. <Br><br><b>Seguem abaixo os dados:</b><Br>";

			}else{
				$conteudo .= "Prezado ".$emails["supervisor"].", você é o supervisor da ação <b>".$emails["acao"]."</b>";
				$conteudo .= " e uma tarefa acaba de ser alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo novos dados:</b><Br>";

				}
			//montando a mensagem para envio ao gerente
			$Email->viewVars(array('titulo' => $mensagem["Tarefa"]["titulo"],
			'inicio' => $mensagem["Tarefa"]["data_inicio_previsto"],
			'fim' => $mensagem["Tarefa"]["data_fim_previsto"],
			'status' => $mensagem["Tarefa"]["status"],
			'responsavel' => $emails["responsavelt"],
			'supervisor' => $emails["supervisort"],
			'comentario' => $mensagem["Tarefa"]["comentario"],
			'conclusao' => $mensagem["Tarefa"]["data_conclusao"],
			'conteudo' => $conteudo));
			
			$Email->send();

		}
		
		if (isset($emails["projeto"])){
			if($emails['email_tarefa'] == 1){
				// Carregando cabeçalho do email do gerente do projeto
				$conteudo="";
				$Email = new CakeEmail('smtp');
				$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
				$Email->to($emails["emailg"],$emails["gerente"]);
				$Email->emailFormat('html');
				$Email->template('tarefa');
				$Email->subject($assunto);
				
				//montando a mensagem para envio ao responsável
				if ($tipo=="novo"){
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b>";
					$conteudo .= " e uma nova tarefa foi cadastrada no na ação ".$emails["acao"]." por $nomeUserLogado. <Br><br><b>Seguem abaixo os dados:</b><Br>";
	
				}else{
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b> que contém a tarefa: '".$mensagem["Tarefa"]["titulo"]."'";
					$conteudo .= " e ela acaba de ser alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo novos dados:</b><Br>";
	
					}
				//montando a mensagem para envio ao gerente
				$Email->viewVars(array('titulo' => $mensagem["Tarefa"]["titulo"],
				'inicio' => $mensagem["Tarefa"]["data_inicio_previsto"],
				'fim' => $mensagem["Tarefa"]["data_fim_previsto"],
				'status' => $mensagem["Tarefa"]["status"],
				'responsavel' => $emails["responsavelt"],
				'supervisor' => $emails["supervisort"],
				'conclusao' => $mensagem["Tarefa"]["data_conclusao"],
				'conteudo' => $conteudo));
				
				$Email->send();
			}
		}
		
		*/
	}
}
?>