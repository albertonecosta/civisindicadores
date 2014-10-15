<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Reuniao Controller
 *
 * @property Reuniao $Reuniao
 * @property SessionComponent $Session
 */
class ReuniaoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Reuniao'])){
				$count = count($_SESSION['Search']['Reuniao']);
				$_SESSION['Search']['Reuniao'][$count]['busca'] = $this->request->data['Reuniao']['busca'];
				$_SESSION['Search']['Reuniao'][$count]['buscar_em'] = $this->request->data['Reuniao']['buscar_em'];
			}else{
				$_SESSION['Search']['Reuniao'][0]['busca'] = $this->request->data['Reuniao']['busca'];
				$_SESSION['Search']['Reuniao'][0]['buscar_em'] = $this->request->data['Reuniao']['buscar_em'];
			}
		}
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Reuniao'])){
			foreach($_SESSION['Search']['Reuniao'] as $termo_busca){
				if($termo_busca['buscar_em'] == "data"){
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
		
		
		$this->Reuniao->recursive = 3;
		$this->paginate['conditions'][] = array('Reuniao.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Reuniao.titulo' => 'asc');
		
		/*
		 * Algoritimo para pegar os dados dos participantes
		*/
		$reuniao = $this->paginate();
		$this->loadModel('Usuario');
		foreach ($reuniao as $key => $value) {
			$pessoas = array();
			foreach ($value['ReuniaoParticipante'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['usuario_id'])));
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
			}
			$reuniao[$key]['Participantes'] = $pessoas;
		}
		
		$this->set('reuniao', $reuniao);
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
		
		unset($_SESSION['Search']['Reuniao'][$filtro]);
		$this->redirect(array('action' => 'index'));	
	}
	

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {
		$this->Reuniao->id = $id;
		if (!$this->Reuniao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$reuniao = $this->Reuniao->read(null, $id);
		
		/*
		 * Algoritimo para pegar os dados dos participantes
		 */
		$reuniao = array($reuniao);		$this->loadModel('Usuario');
		foreach ($reuniao as $key => $value) {
			$pessoas = array();
			foreach ($value['ReuniaoParticipante'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['usuario_id'])));
				$pessoas[$key2]['id'] = $usuario['Usuario']['id'];
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
			}
			$reuniao[$key]['Participantes'] = $pessoas;
		}
		
		$this->set('reuniao', $reuniao);
	}
	
	/**
	 * print method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function imprimir($id = null) {
		
		$this->layout = 'ajax';
		$this->Reuniao->id = $id;
		if (!$this->Reuniao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$reuniao = $this->Reuniao->read(null, $id);
		
		/*
		 * Algoritimo para pegar os dados dos participantes
		 */
		$reuniao = array($reuniao);
		
		$this->loadModel('Usuario');
		foreach ($reuniao as $key => $value) {
			$pessoas = array();
			foreach ($value['ReuniaoParticipante'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['usuario_id'])));
				$pessoas[$key2]['id'] = $usuario['Usuario']['id'];
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
			}
			$reuniao[$key]['Participantes'] = $pessoas;
			$pessoas = array();
			foreach ($value['ReuniaoConhecedor'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['usuario_id'])));
				$pessoas[$key2]['id'] = $usuario['Usuario']['id'];
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
			}
			$reuniao[$key]['Conhecedores'] = $pessoas;
			$pessoas = array();
			foreach ($value['Tarefa'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['responsavel_id'])));
				$pessoas[$key2]['id'] = $usuario['Usuario']['id'];
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
				$reuniao[$key]['Tarefa'][$key2]['Responsavel'] = $pessoas;
			}
			
		}
			
		$this->set('reuniao', $reuniao);
	}
	
	public function enviar($id = null){
		
		$this->layout = "ajax";
		$this->autoRender = false;
		$this->Reuniao->id = $id;
		$this->Reuniao->recursive = 2;
		if (!$this->Reuniao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		
		if($this->request->is('post')){
			$reuniao = $this->Reuniao->read(null, $id);
			$emails = array();
			$this->loadModel('Usuario');
			
			foreach ($reuniao['ReuniaoParticipante'] as $key => $value) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value['usuario_id'])));
				$emails[] = $usuario['Pessoa']['email'];
				$emailsTitulo[] = $usuario['Pessoa']['titulo'];
			}
			
			foreach ($reuniao['ReuniaoConhecedor'] as $key => $value) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value['usuario_id'])));
				$emails[] = $usuario['Pessoa']['email'];
				$emailsTitulo[] = $usuario['Pessoa']['titulo'];
			}
			
			
			if (count($reuniao['ReuniaoEmailExterno'])>0){
				foreach ($reuniao['ReuniaoEmailExterno'] as $key => $value) {
					if ($value['email']!=""){
						$emails[] = $value['email'];
					}
				}	
			}
			
		}
		$usuarioLogado = $this->Auth->user();
		
		$Email = new CakeEmail('smtp');
		$Email->from(array('cgtec@planejamento.gov.br' => 'SIGESPU'));
		$Email->to($emails);
		$Email->cc($usuarioLogado['Pessoa']['email']);
		$Email->emailFormat('html');
		$Email->viewVars(array('assunto' => $reuniao['Reuniao']['titulo'],
		'pauta' => ($reuniao['Reuniao']['pauta']),
		'observacao' => ($reuniao['Reuniao']['observacao']),
		
		'participantes' => implode(",",$emailsTitulo),
		'local' => $reuniao['Reuniao']['local'], 
		'data' => $reuniao['Reuniao']['data'],
		'ata' => $reuniao['Reuniao']['ata'],
		'horario' => $reuniao['Reuniao']['hora_inicio']));
		
		$Email->template('reuniao');
		$Email->subject($reuniao['Reuniao']['titulo']);
		$Email->send();
		
		echo "Emails enviados com sucesso";
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		
		if ($this->request->is('post')) {
			$this->Reuniao->create();
			if ($this->Reuniao->save($this->request->data)) {
				
				$this->loadModel('ReuniaoParticipante');
				foreach ($this->request->data['ReuniaoParticipante']['participantes'] as $value) {
					$this->request->data['ReuniaoParticipante']['usuario_id'] = $value;
					$this->request->data['ReuniaoParticipante']['reuniao_id'] = $this->Reuniao->id;
					$this->ReuniaoParticipante->save($this->request->data);
					$this->ReuniaoParticipante->id = null;
				}
				
				$this->loadModel('ReuniaoConhecedor');
				foreach ($this->request->data['ReuniaoConhecedor']['conhecedores'] as $value) {
					$this->request->data['ReuniaoConhecedor']['usuario_id'] = $value;
					$this->request->data['ReuniaoConhecedor']['reuniao_id'] = $this->Reuniao->id;
					$this->ReuniaoConhecedor->save($this->request->data);
					$this->ReuniaoConhecedor->id = null;
				}

				$emailsExternos = explode(",", $this->request->data['ReuniaoEmailExterno']['emails']);
				$this->loadModel('ReuniaoEmailExterno');
				foreach ($emailsExternos as $value) {
					$this->request->data['ReuniaoEmailExterno']['email'] = trim($value);
					$this->request->data['ReuniaoEmailExterno']['reuniao_id'] = $this->Reuniao->id;
					$this->ReuniaoEmailExterno->save($this->request->data);
					$this->ReuniaoEmailExterno->id = null;
				}
				$this->Audit->salvar($this->request->data, "Reuniao", array(), "adicionar", true, $this->Reuniao->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		$this->loadModel('Projeto');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'), 'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$projetos = $this->Projeto->find('list', array('conditions' => array('Projeto.status' => Util::ATIVO), 'fields' => array('Projeto.id', 'Projeto.titulo'), 'order' => array('Projeto.titulo')));
		$this->set('usuarios', $usuarios);
		$this->set('projetos', $projetos);
		
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		
		$this->Reuniao->id = $id;
		if (!$this->Reuniao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Reuniao->save($this->request->data)) {
				
				$this->Reuniao->query("DELETE FROM reuniao_participante WHERE reuniao_id = $id");
				$this->loadModel('ReuniaoParticipante');
				if($this->request->data['ReuniaoParticipante']['participantes'] != ""){
					foreach ($this->request->data['ReuniaoParticipante']['participantes'] as $value) {
						$this->request->data['ReuniaoParticipante']['usuario_id'] = $value;
						$this->request->data['ReuniaoParticipante']['reuniao_id'] = $this->Reuniao->id;
						$this->ReuniaoParticipante->save($this->request->data);
						$this->ReuniaoParticipante->id = null;
					}
				}
				
				
				$this->Reuniao->query("DELETE FROM reuniao_conhecedor WHERE reuniao_id = $id");
				$this->loadModel('ReuniaoConhecedor');
				foreach ($this->request->data['ReuniaoConhecedor']['conhecedores'] as $value) {
					$this->request->data['ReuniaoConhecedor']['usuario_id'] = $value;
					$this->request->data['ReuniaoConhecedor']['reuniao_id'] = $this->Reuniao->id;
					$this->ReuniaoConhecedor->save($this->request->data);
					$this->ReuniaoConhecedor->id = null;
				}
				
				$this->Reuniao->query("DELETE FROM reuniao_email_externo WHERE reuniao_id = $id");
				$emailsExternos = explode(",", $this->request->data['ReuniaoEmailExterno']['emails']);
				$this->loadModel('ReuniaoEmailExterno');
				foreach ($emailsExternos as $value) {
					$this->request->data['ReuniaoEmailExterno']['email'] = trim($value);
					$this->request->data['ReuniaoEmailExterno']['reuniao_id'] = $this->Reuniao->id;
					$this->ReuniaoEmailExterno->save($this->request->data);
					$this->ReuniaoEmailExterno->id = null;
				}
				
				$this->Audit->salvar($this->request->data, "Reuniao", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		$reuniao = $this->Reuniao->read(null, $id);
		
		$this->loadModel('Usuario');
		$this->loadModel('Projeto');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$projetos = $this->Projeto->find('list', array('conditions' => array('Projeto.status' => Util::ATIVO), 'fields' => array('Projeto.id', 'Projeto.titulo'), 'order' => array('Projeto.titulo')));
		
		$this->loadModel("ReuniaoEmailExterno");
		$emails = $this->ReuniaoEmailExterno->find('list', array('conditions' => array('ReuniaoEmailExterno.reuniao_id' => $id), 'fields' => array('ReuniaoEmailExterno.id', 'ReuniaoEmailExterno.email')));

		$strEmail = "";
		foreach ($emails as $value) {
			$strEmail .= $value;
			$strEmail .= ", ";
		}
		$strEmail = rtrim($strEmail, ', ');
		
		$participantes = array();
		foreach ($reuniao['ReuniaoParticipante'] as $value) {
			$participantes[] = $value['usuario_id'];
 		}
		
		$conhecedores = array();
		foreach ($reuniao['ReuniaoConhecedor'] as $value) {
			$conhecedores[] = $value['usuario_id'];
 		}
		
		$this->set('usuarios', $usuarios);
		$this->set('projetos', $projetos);
		$this->set('strEmail', $strEmail);
		$this->set('participantes', $participantes);
		$this->set('conhecedores', $conhecedores);
		
		$this->request->data = $reuniao;
		
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
		$this->Reuniao->id = $id;
		if (!$this->Reuniao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Reuniao->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Reuniao", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
