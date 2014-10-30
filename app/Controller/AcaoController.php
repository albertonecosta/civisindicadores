<?php
/**
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
 * 
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Acao Controller
 *
 * @property Acao $Acao
 * @property SessionComponent $Session
 */
class AcaoController extends AppController {
	
	/**
	 * (non-PHPdoc)
	 * @see AppController::beforeFilter()
	 */
	public function beforeFilter(){
		parent::beforeFilter();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$limit = 10;
		if(count($_POST) > 0){
			$limit = $_POST['limit'];
		}		
		
	    // Define conditions
    	$filtro = $this->FilterResults->getConditions();
		$this->Acao->recursive = 2;
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$acoes = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.responsavel_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('acoes', $acoes);
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$acoes2 = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.supervisor_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('acoes2', $acoes2);
		$this->set("limit", $limit);
	}

	/**
	 * ImprimirIndex method
	 *
	 * @param int $limit
	 * @return void
	 */
	public function imprimirIndex($limit = null) {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$this->Acao->recursive = 2;
		
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$acoes = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.responsavel_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('acoes', $acoes);
		
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$acoes2 = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.supervisor_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('acoes2', $acoes2);
		
		$this->set("limit", $limit);
	}

	/**
	 * visualizarTodosResponsavel method
	 *
	 * @return void
	 */
	public function visualizarTodosResponsavel() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$this->Acao->recursive = 2;
		$this->paginate['conditions'][] = array('Acao.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Acao.responsavel_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Acao.titulo' => 'asc');
		$this->set('acao', $this->paginate());
	}

	/**
	 * imprimirTodosResponsavel method
	 *
	 * @return void
	 */
	public function imprimirTodosResponsavel() {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$this->Acao->recursive = 2;
		
		$this->paginate['conditions'][] = array('Acao.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Acao.responsavel_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Acao.titulo' => 'asc');
		$this->set('acao', $this->paginate());
	}
	
	/**
	 * visualizarTodosSupervisor method
	 *
	 * @return void
	 */
	public function visualizarTodosSupervisor() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$this->Acao->recursive = 2;
		
		$this->paginate['conditions'][] = array('Acao.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Acao.supervisor_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Acao.titulo' => 'asc');
		$this->set('acao', $this->paginate());
	}
	
	/**
	 * imprimirTodosSupervisor method
	 *
	 * @return void
	 */
	public function imprimirTodosSupervisor() {
		
		$this->layout = "ajax";
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Acao.titulo' => array(
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
		
		$this->Acao->recursive = 2;
		
		$this->paginate['conditions'][] = array('Acao.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Acao.supervisor_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Acao.titulo' => 'asc');
		$this->set('acao', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function visualizar($id = null) {
		
		$this->Acao->id = $id;
		if (!$this->Acao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Acao->recursive = 2;
		
		$this->loadModel("Post");
		$this->Post->recursive = 2;
		$posts = $this->Post->find('all', array('conditions' => array('Post.status' => Util::ATIVO, 'Post.post_id' => null, 'Post.acao_id' => $id)));
		/* carregando os dados da pessoa dentro do array do post dos filhos, pois o ORM não conseguiu chegar até esse nível */
		$this->loadModel('Usuario');
		foreach($posts as $keyPost=>$post){
			foreach($post['Filhos'] as $keyFilho=>$filho){
				$usuario = $this->Usuario->find('first', array('conditions'=>array('Usuario.id'=>$filho['usuario_id'])));
				$posts[$keyPost]["Filhos"][$keyFilho]["Usuario"]["Pessoa"] = $usuario["Pessoa"];
			}
		}
		$this->set('acao', $this->Acao->read(null, $id));
		$this->set('posts', $posts);
		
			
		$this->loadModel("Tarefa");
		$this->Tarefa->recursive = 2;
		$tarefas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.acao_id' => $id)));
		$this->set('acao', $this->Acao->read(null, $id));
		$this->set('tarefas', $tarefas);
		
		
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->set('usuarios',$usuarios);
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('acao_id', $id);
		
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
	
		if ($this->request->is('post')) {
			$this->Acao->create();
			if ($this->Acao->save($this->request->data)) {
				$this->enviarEmails(@$this->Acao->id,$this->request->data,"novo");
				$this->Audit->salvar($this->request->data, "Acao", array(), "adicionar", true, $this->Acao->id, $this->Auth->user("id"));				
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('usuarios', $usuarios);
		$this->set('acoes', $acoes);
		$this->set('objetivos', $objetivos);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function ajaxAdicionar($idAnomalia) {
		$this->layout = "ajax";
		if ($this->request->is('post')) {
			$this->Acao->create();
			if ($this->Acao->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Acao", array(), "adicionar", true, $this->Acao->id, $this->Auth->user("id"));
				echo Util::REGISTRO_ADICIONADO_SUCESSO;
				die;
			} else {
				echo Util::REGISTRO_ADICIONADO_FALHA;
				die;
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO, 'Acao.anomalia_id' => $idAnomalia), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('anomalia', $idAnomalia);
		$this->set('usuarios', $usuarios);
		$this->set('acoes', $acoes);
		$this->set('objetivos', $objetivos);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function ajaxAdicionarComProjeto() {
		$this->layout = "ajax";
		if ($this->request->is('post')) {
			$this->Acao->create();
			if ($this->Acao->save($this->request->data)) {
				$this->enviarEmails(@$this->Acao->id,$this->request->data,"novo");
				$this->Audit->salvar($this->request->data, "Acao", array(), "adicionar", true, $this->Acao->id, $this->Auth->user("id"));
				echo Util::REGISTRO_ADICIONADO_SUCESSO;
				die;
			} else {
				echo Util::REGISTRO_ADICIONADO_FALHA;
				die;
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO, 'Acao.projeto_id' => $_GET['id_projeto']), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('projeto_id', $_GET['id_projeto']);
		$this->set('usuarios', $usuarios);
		$this->set('acoes', $acoes);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function ajaxAdicionarComObjetivo() {
		$this->layout = "ajax";
		if ($this->request->is('post')) {
			$this->Acao->create();
			if ($this->Acao->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Acao", array(), "adicionar", true, $this->Acao->id, $this->Auth->user("id"));
				echo Util::REGISTRO_ADICIONADO_SUCESSO;
				die;
			} else {
				echo Util::REGISTRO_ADICIONADO_FALHA;
				die;
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO, 'Acao.objetivo_id' => $_GET['id_objetivo']), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('objetivo_id', $_GET['id_objetivo']);
		$this->set('usuarios', $usuarios);
		$this->set('acoes', $acoes);
		$this->set('objetivos', $objetivos);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		
		$this->Acao->id = $id;
		
		if (!$this->Acao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Acao->save($this->request->data)) {
				$this->enviarEmails(@$this->Acao->id,$this->request->data,"edição");
				$this->Audit->salvar($this->request->data, "Acao", array(), "editar", false, $id, $this->Auth->user("id"));				
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}		
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$this->loadModel('Projeto');
		$projetos = $this->Projeto->find('list', array('conditions' => array('Projeto.status' => Util::ATIVO), 'fields' => array('Projeto.id', 'Projeto.titulo')));
		
		
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' => Util::INATIVO, 'Acao.id !=' => $id), 'fields' => array('Acao.id', 'Acao.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->request->data = $this->Acao->read(null, $id);
		$this->Audit->setDadosAntes($this->request->data);
		
		$this->set('usuarios', $usuarios);
		$this->set('projetos', $projetos);
		$this->set('acoes', $acoes);
		$this->set('objetivos', $objetivos);
		$this->set('status', $status);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		
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
		$this->Acao->id = $id;
		if (!$this->Acao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Acao->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Acao", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
	

	/**
	 * Método que envia emails de notificação das ações para o responsavel, supervisor da ação e responsavel do projeto
	 * @param Integer $id
	 * @param String $mensagem
	 */
	private function enviarEmails($id, $mensagem,$tipo='novo'){
		/*
		// caso o post não tenha pai, o post não se trata de uma resposta, portanto não faz nada
		$conteudo="";
		$userLogado = $this->Auth->user();
		$nomeUserLogado = $userLogado['Pessoa']['titulo'];
		if ($tipo=="novo")
		$assunto = "O usuário $nomeUserLogado adicionou uma nova ação";
		else
		$assunto = "O usuário $nomeUserLogado editou uma ação";
		// pelo o id, busca o post pai que deseja receber email a cada resposta adicionada
		
		
		$responsaveis = $this->Acao->query("Select presponsavel.titulo,
													presponsavel.email as emailr,
													psupervisor.titulo as supervisor,
													psupervisor.email as emails,
													pgerente.titulo as gerente,
													pgerente.email as emailg, 
													projeto.titulo as projeto,
													projeto.email_acao as email_acao
				from acao
				left join projeto on projeto.id=acao.projeto_id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				inner join usuario as responsavel on responsavel.id=acao.responsavel_id 
				inner join usuario as supervisor on supervisor.id=acao.supervisor_id				
				inner join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				inner join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				inner join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				where acao.id='$id'");
		
		switch ($mensagem["Acao"]["status"]){
			case (Util::ATIVO):
				$mensagem["Acao"]["status"]="Ativo";
				break;
			case (Util::INATIVO):
				$mensagem["Acao"]["status"]= "Inativo";
				break;
			case (Util::EM_ANDAMENTO):
				$mensagem["Acao"]["status"]= "Em Andamento";
				break;
			case (Util::AGUARDANDO_OUTRA_PESSOA):
				$mensagem["Acao"]["status"]= "Aguardando outra pessoa";
				break;
			case (Util::CONCLUIDO):
				$mensagem["Acao"]["status"]= "Concluída";
				break;
			case (Util::NAO_INICIADO):
				$mensagem["Acao"]["status"]= "Não Iniciada";
				break;
			case (Util::CANCELADO):
				$mensagem["Acao"]["status"]= "Cancelada";
				break;
			default:
				break;
		}

		// Carregando cabeçalho do email do responsável da ação 
		
		$emails = $responsaveis[0][0];
		
		$Email = new CakeEmail('smtp');

		$Email->from(array('cgtec@planejamento.gov.br' => 'Civis Indicadores'));
		$Email->to($emails["emailr"],$emails["titulo"]);
		$Email->emailFormat('html');
		$Email->template('acao');
		$Email->subject($assunto);
		
		//montando a mensagem para envio ao responsável
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["titulo"].", uma nova ação foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como responsável. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["titulo"].", você é o responsável da ação <b>".$mensagem["Acao"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}
		$Email->viewVars(array('titulo' => $mensagem["Acao"]["titulo"],
		'inicio' => $mensagem["Acao"]["data_inicio_previsto"],
		'fim' => $mensagem["Acao"]["data_fim_previsto"],
		'status' => $mensagem["Acao"]["status"],
		'andamento' => $mensagem["Acao"]["andamento"],
		'responsavel' => $emails["titulo"],
		'supervisor' => $emails["supervisor"],
		'conclusao' => $mensagem["Acao"]["data_conclusao"],
		'comentario' => $mensagem["Acao"]["observacao"],
		'conteudo' => $conteudo));
		$Email->send($conteudo);
		
		// Carregando cabeçalho do email do supervisor da ação
		
		
		$conteudo="";
		$Email = new CakeEmail('smtp');
		$Email->from(array('contato@civis.com.br' => 'Civis Indicadores'));
		$Email->to($emails["emails"],$emails["supervisor"]);
		$Email->emailFormat('html');
		$Email->template('acao');
		$Email->subject($assunto);
		
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["supervisor"].", uma nova ação foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como supervisor. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["supervisor"].", você é o supervisor da ação <b>".$mensagem["Acao"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}	

		//montando a mensagem para envio ao responsável

		$Email->viewVars(array('titulo' => $mensagem["Acao"]["titulo"],
		'inicio' => $mensagem["Acao"]["data_inicio_previsto"],
		'fim' => $mensagem["Acao"]["data_fim_previsto"],
		'status' => $mensagem["Acao"]["status"],
		'andamento' => $mensagem["Acao"]["andamento"],
		'responsavel' => $emails["titulo"],
		'supervisor' => $emails["supervisor"],
		'conclusao' => $mensagem["Acao"]["data_conclusao"],
		'comentario' => $mensagem["Acao"]["observacao"],
		'conteudo' => $conteudo));

		$Email->template('acao');
		$Email->subject($assunto);
		$Email->send();
		
		
		if (isset($emails["projeto"])){
			if($emails['email_acao'] == 1){
				// Carregando cabeçalho do email do gerente do projeto
				$conteudo="";
				$Email = new CakeEmail('smtp');
				$Email->from(array('contato@civis.com.br' => 'Civis Indicadores'));
				$Email->to($emails["emailg"],$emails["gerente"]);
				$Email->emailFormat('html');
				$Email->template('acao');
				$Email->subject($assunto);
				
				//montando a mensagem para envio ao responsável
				if ($tipo=="novo"){
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b>";
					$conteudo .= " e uma nova ação foi cadastrada no projeto por $nomeUserLogado. <Br><br><b>Seguem abaixo os dados:</b><Br>";
	
				}else{
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b> que contém a ação: '".$mensagem["Acao"]["titulo"]."'";
					$conteudo .= " e ela acaba de ser alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo novos dados:</b><Br>";
	
					}
				//montando a mensagem para envio ao gerente
				$Email->viewVars(array('titulo' => $mensagem["Acao"]["titulo"],
				'inicio' => $mensagem["Acao"]["data_inicio_previsto"],
				'fim' => $mensagem["Acao"]["data_fim_previsto"],
				'status' => $mensagem["Acao"]["status"],
				'andamento' => $mensagem["Acao"]["andamento"],
				'responsavel' => $emails["titulo"],
				'supervisor' => $emails["supervisor"],
				'conclusao' => $mensagem["Acao"]["data_conclusao"],
				'comentario' => $mensagem["Acao"]["observacao"],
				'conteudo' => $conteudo));
				
				$Email->send();
			}
		}
		
		*/
	}
}
