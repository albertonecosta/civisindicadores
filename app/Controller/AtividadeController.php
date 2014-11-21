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
 * Atividade Controller
 *
 * @property Atividade $Atividade
 * @property SessionComponent $Session
 */
class AtividadeController extends AppController {
	
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
	                'Atividade.titulo' => array(
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
		$this->Atividade->recursive = 2;
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$atividades = $this->Atividade->find('all', array('conditions' => array('Atividade.status != ' => Util::INATIVO, 'Atividade.responsavel_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('atividades', $atividades);
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$atividades2 = $this->Atividade->find('all', array('conditions' => array('Atividade.status != ' => Util::INATIVO, 'Atividade.supervisor_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('atividades2', $atividades2);
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
	                'Atividade.titulo' => array(
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
		
		$this->Atividade->recursive = 2;
		
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$atividades = $this->Atividade->find('all', array('conditions' => array('Atividade.status != ' => Util::INATIVO, 'Atividade.responsavel_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('atividades', $atividades);
		
		//Usamos o metodo find como alternativa para poder exibir dois blocos de dados, pois o cake não dá suporte para dupla paginação
		$atividades2 = $this->Atividade->find('all', array('conditions' => array('Atividade.status != ' => Util::INATIVO, 'Atividade.supervisor_id = ' => $this->Auth->user("id"), isset($filtro[0]) ? $filtro[0]: ""), 'limit' => $limit));
		$this->set('atividades2', $atividades2);
		
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
	                'Atividade.titulo' => array(
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
		
		$this->Atividade->recursive = 2;
		$this->paginate['conditions'][] = array('Atividade.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Atividade.responsavel_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Atividade.titulo' => 'asc');
		$this->set('atividade', $this->paginate());
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
	                'Atividade.titulo' => array(
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
		
		$this->Atividade->recursive = 2;
		
		$this->paginate['conditions'][] = array('Atividade.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Atividade.responsavel_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Atividade.titulo' => 'asc');
		$this->set('atividade', $this->paginate());
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
	                'Atividade.titulo' => array(
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
		
		$this->Atividade->recursive = 2;
		
		$this->paginate['conditions'][] = array('Atividade.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Atividade.supervisor_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Atividade.titulo' => 'asc');
		$this->set('atividade', $this->paginate());
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
	                'Atividade.titulo' => array(
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
		
		$this->Atividade->recursive = 2;
		
		$this->paginate['conditions'][] = array('Atividade.status != ' => Util::ATIVO);
		$this->paginate['conditions'][] = array('Atividade.supervisor_id = ' => $this->Auth->user("id"));
		$this->paginate['order'] = array('Atividade.titulo' => 'asc');
		$this->set('atividade', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function visualizar($id = null) {
		
		$this->Atividade->id = $id;
		if (!$this->Atividade->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Atividade->recursive = 2;
		
		$this->loadModel("Post");
		$this->Post->recursive = 2;
		$posts = $this->Post->find('all', array('conditions' => array('Post.status' => Util::ATIVO, 'Post.post_id' => null, 'Post.atividade_id' => $id)));
		/* carregando os dados da pessoa dentro do array do post dos filhos, pois o ORM não conseguiu chegar até esse nível */
		
		$this->loadModel('Usuario');
		foreach($posts as $keyPost=>$post){
			foreach($post['Filhos'] as $keyFilho=>$filho){
				$usuario = $this->Usuario->find('first', array('conditions'=>array('Usuario.id'=>$filho['usuario_id'])));
				$posts[$keyPost]["Filhos"][$keyFilho]["Usuario"]["Pessoa"] = $usuario["Pessoa"];
			}
		}
		$this->set('atividade', $this->Atividade->read(null, $id));
		$this->set('posts', $posts);
		
			
		$this->loadModel("Tarefa");
		$this->Tarefa->recursive = 2;
		$tarefas = $this->Tarefa->find('all', array('conditions' => array('Tarefa.atividade_id' => $id)));
		$this->set('atividade', $this->Atividade->read(null, $id));
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
		$this->set('atividade_id', $id);
		
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
	
		if ($this->request->is('post')) {
			$this->Atividade->create();
			if ($this->Atividade->save($this->request->data)) {
				$this->enviarEmails(@$this->Atividade->id,$this->request->data,"novo");
				$this->Audit->salvar($this->request->data, "Atividade", array(), "adicionar", true, $this->Atividade->id, $this->Auth->user("id"));				
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
		
		$atividades = $this->Atividade->find('list', array('conditions' => array('Atividade.status !=' =>Util::INATIVO), 'fields' => array('Atividade.id', 'Atividade.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('usuarios', $usuarios);
		$this->set('atividades', $atividades);
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
			$this->Atividade->create();
			if ($this->Atividade->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Atividade", array(), "adicionar", true, $this->Atividade->id, $this->Auth->user("id"));
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
		
		$atividades = $this->Atividade->find('list', array('conditions' => array('Atividade.status !=' =>Util::INATIVO, 'Atividade.anomalia_id' => $idAnomalia), 'fields' => array('Atividade.id', 'Atividade.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('anomalia', $idAnomalia);
		$this->set('usuarios', $usuarios);
		$this->set('atividades', $atividades);
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
			$this->Atividade->create();
			if ($this->Atividade->save($this->request->data)) {
				$this->enviarEmails(@$this->Atividade->id,$this->request->data,"novo");
				$this->Audit->salvar($this->request->data, "Atividade", array(), "adicionar", true, $this->Atividade->id, $this->Auth->user("id"));
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
		$atividades = $this->Atividade->find('list', array('conditions' => array('Atividade.status !=' =>Util::INATIVO, 'Atividade.projeto_id' => $_GET['id_projeto']), 'fields' => array('Atividade.id', 'Atividade.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('projeto_id', $_GET['id_projeto']);
		$this->set('usuarios', $usuarios);
		$this->set('atividades', $atividades);
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
			$this->Atividade->create();
			if ($this->Atividade->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Atividade", array(), "adicionar", true, $this->Atividade->id, $this->Auth->user("id"));
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
		
		$atividades = $this->Atividade->find('list', array('conditions' => array('Atividade.status !=' =>Util::INATIVO, 'Atividade.objetivo_id' => $_GET['id_objetivo']), 'fields' => array('Atividade.id', 'Atividade.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->set('objetivo_id', $_GET['id_objetivo']);
		$this->set('usuarios', $usuarios);
		$this->set('atividades', $atividades);
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
		
		$this->Atividade->id = $id;
		
		if (!$this->Atividade->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Atividade->save($this->request->data)) {
				$this->enviarEmails(@$this->Atividade->id,$this->request->data,"edição");
				$this->Audit->salvar($this->request->data, "Atividade", array(), "editar", false, $id, $this->Auth->user("id"));				
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
		
		
		$atividades = $this->Atividade->find('list', array('conditions' => array('Atividade.status !=' => Util::INATIVO, 'Atividade.id !=' => $id), 'fields' => array('Atividade.id', 'Atividade.titulo')));
		
		$status = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Aguardando outra pessoa', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '10%' => '10%', '25%' => '25%', '50%' => '50%', '75%' => '75%', '100%' => '100%');;
		
		$this->request->data = $this->Atividade->read(null, $id);
		$this->Audit->setDadosAntes($this->request->data);
		
		$this->set('usuarios', $usuarios);
		$this->set('projetos', $projetos);
		$this->set('atividades', $atividades);
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
		$this->Atividade->id = $id;
		if (!$this->Atividade->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Atividade->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Atividade", array(), "excluir", false, $id, $this->Auth->user("id"));
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
		
		
		$responsaveis = $this->Atividade->query("Select presponsavel.titulo,
													presponsavel.email as emailr,
													psupervisor.titulo as supervisor,
													psupervisor.email as emails,
													pgerente.titulo as gerente,
													pgerente.email as emailg, 
													projeto.titulo as projeto,
													projeto.email_atividade as email_atividade
				from atividade
				left join projeto on projeto.id=atividade.projeto_id
				left join usuario as gerente on projeto.usuario_id=gerente.id
				inner join usuario as responsavel on responsavel.id=atividade.responsavel_id 
				inner join usuario as supervisor on supervisor.id=atividade.supervisor_id				
				inner join pessoa as presponsavel on responsavel.pessoa_id=presponsavel.id
				inner join pessoa as psupervisor on supervisor.pessoa_id=psupervisor.id
				inner join pessoa as pgerente on gerente.pessoa_id=pgerente.id
				where atividade.id='$id'");
		
		switch ($mensagem["Atividade"]["status"]){
			case (Util::ATIVO):
				$mensagem["Atividade"]["status"]="Ativo";
				break;
			case (Util::INATIVO):
				$mensagem["Atividade"]["status"]= "Inativo";
				break;
			case (Util::EM_ANDAMENTO):
				$mensagem["Atividade"]["status"]= "Em Andamento";
				break;
			case (Util::AGUARDANDO_OUTRA_PESSOA):
				$mensagem["Atividade"]["status"]= "Aguardando outra pessoa";
				break;
			case (Util::CONCLUIDO):
				$mensagem["Atividade"]["status"]= "Concluída";
				break;
			case (Util::NAO_INICIADO):
				$mensagem["Atividade"]["status"]= "Não Iniciada";
				break;
			case (Util::CANCELADO):
				$mensagem["Atividade"]["status"]= "Cancelada";
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
		$Email->template('atividade');
		$Email->subject($assunto);
		
		//montando a mensagem para envio ao responsável
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["titulo"].", uma nova ação foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como responsável. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["titulo"].", você é o responsável da ação <b>".$mensagem["Atividade"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}
		$Email->viewVars(array('titulo' => $mensagem["Atividade"]["titulo"],
		'inicio' => $mensagem["Atividade"]["data_inicio_previsto"],
		'fim' => $mensagem["Atividade"]["data_fim_previsto"],
		'status' => $mensagem["Atividade"]["status"],
		'andamento' => $mensagem["Atividade"]["andamento"],
		'responsavel' => $emails["titulo"],
		'supervisor' => $emails["supervisor"],
		'conclusao' => $mensagem["Atividade"]["data_conclusao"],
		'comentario' => $mensagem["Atividade"]["observacao"],
		'conteudo' => $conteudo));
		$Email->send($conteudo);
		
		// Carregando cabeçalho do email do supervisor da ação
		
		
		$conteudo="";
		$Email = new CakeEmail('smtp');
		$Email->from(array('contato@civis.com.br' => 'Civis Indicadores'));
		$Email->to($emails["emails"],$emails["supervisor"]);
		$Email->emailFormat('html');
		$Email->template('atividade');
		$Email->subject($assunto);
		
		if ($tipo=="novo"){
			$conteudo .= "Prezado ".$emails["supervisor"].", uma nova ação foi cadastrada";
			$conteudo .= " por $nomeUserLogado e você foi definido como supervisor. <br>Seguem abaixo os dados:";
		}else{
			$conteudo .= "Prezado ".$emails["supervisor"].", você é o supervisor da ação <b>".$mensagem["Atividade"]["titulo"]."</b>";
			$conteudo .= " e ela foi alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo os novos dados:</b><Br>";
		}	

		//montando a mensagem para envio ao responsável

		$Email->viewVars(array('titulo' => $mensagem["Atividade"]["titulo"],
		'inicio' => $mensagem["Atividade"]["data_inicio_previsto"],
		'fim' => $mensagem["Atividade"]["data_fim_previsto"],
		'status' => $mensagem["Atividade"]["status"],
		'andamento' => $mensagem["Atividade"]["andamento"],
		'responsavel' => $emails["titulo"],
		'supervisor' => $emails["supervisor"],
		'conclusao' => $mensagem["Atividade"]["data_conclusao"],
		'comentario' => $mensagem["Atividade"]["observacao"],
		'conteudo' => $conteudo));

		$Email->template('atividade');
		$Email->subject($assunto);
		$Email->send();
		
		
		if (isset($emails["projeto"])){
			if($emails['email_atividade'] == 1){
				// Carregando cabeçalho do email do gerente do projeto
				$conteudo="";
				$Email = new CakeEmail('smtp');
				$Email->from(array('contato@civis.com.br' => 'Civis Indicadores'));
				$Email->to($emails["emailg"],$emails["gerente"]);
				$Email->emailFormat('html');
				$Email->template('atividade');
				$Email->subject($assunto);
				
				//montando a mensagem para envio ao responsável
				if ($tipo=="novo"){
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b>";
					$conteudo .= " e uma nova ação foi cadastrada no projeto por $nomeUserLogado. <Br><br><b>Seguem abaixo os dados:</b><Br>";
	
				}else{
					$conteudo .= "Prezado ".$emails["gerente"].", você é o gerente do projeto <b>".$emails["projeto"]."</b> que contém a ação: '".$mensagem["Atividade"]["titulo"]."'";
					$conteudo .= " e ela acaba de ser alterada por $nomeUserLogado. <Br><br><b>Seguem abaixo novos dados:</b><Br>";
	
					}
				//montando a mensagem para envio ao gerente
				$Email->viewVars(array('titulo' => $mensagem["Atividade"]["titulo"],
				'inicio' => $mensagem["Atividade"]["data_inicio_previsto"],
				'fim' => $mensagem["Atividade"]["data_fim_previsto"],
				'status' => $mensagem["Atividade"]["status"],
				'andamento' => $mensagem["Atividade"]["andamento"],
				'responsavel' => $emails["titulo"],
				'supervisor' => $emails["supervisor"],
				'conclusao' => $mensagem["Atividade"]["data_conclusao"],
				'comentario' => $mensagem["Atividade"]["observacao"],
				'conteudo' => $conteudo));
				
				$Email->send();
			}
		}
		
		*/
	}
}
