<?php
App::uses('AppController', 'Controller');
/**
 * Usuario Controller
 *
 * @property Usuario $Usuario
 * @property SessionComponent $Session
 */
class UsuarioController extends AppController {
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::beforeFilter()
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
	                'Pessoa.titulo' => array(
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
		$this->Usuario->recursive = 0;
		$this->paginate['conditions'][] = array('Usuario.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Pessoa.titulo' => 'asc');
		$this->set('usuario', $this->paginate());
	}
	
	/**
	 * Método de login do usuário no sistema
	 */
	public function login(){
		$this->layout = "login";
		if($this->request->is('post')){
			if($this->Auth->login()){
				$this->redirect(array("controller" => "Aplicacao", "action" => "index"));
			}else{
				$this->Session->setFlash("Email e/ou senha incorretos", 'alert');
			}
		}
	}
	
	/**
	 * Logout do usuário no sistema
	 */
	public function logout(){
		$this->Session->delete('Auth.Permissions');
		$this->redirect($this->Auth->logout());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('usuario', $this->Usuario->read(null, $id));
		$this->loadModel("Endereco");
		$this->Endereco->recursive = 0;
		$endereco = $this->Endereco->find("all", array("conditions" => array("Endereco.id" => $this->Usuario->data['Usuario']['endereco_id'])));
		$this->set('endereco', $endereco[0]);
			
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {	

		if ($this->request->is('post')) {
			$this->Usuario->create();
			$this->loadModel("Pessoa");
			$this->loadModel("Endereco");

			$this->Endereco->set($this->request->data);
			$this->Pessoa->set($this->request->data);
			$this->Usuario->set($this->request->data);			
			
			//Encadeamento para fazer as validações de todos os dados do usuário
			if ($this->Endereco->validates()){
				if($this->Pessoa->validates()){
					if($this->Usuario->validates()){						
						
						$this->Endereco->save($this->request->data);						
						$this->Pessoa->save($this->request->data);
						$this->request->data['Usuario']['endereco_id'] = $this->Endereco->id;
						$this->request->data['Usuario']['pessoa_id'] = $this->Pessoa->id;
						$this->Usuario->save($this->request->data);
						
						
						$this->Audit->salvar($this->request->data, "Usuario", array(), "adicionar", true, $this->Usuario->id, $this->Auth->user("id"));
						
						$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
						$this->redirect(array('action' => 'index'));
					}else{
						$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
					}
				}else{
					$this->Usuario->validates();
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');					
				}				
			}else{
				$this->Pessoa->validates();
				$this->Usuario->validates();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
			
		}
		
		$this->loadModel("Cargo");
		$this->loadModel("Vinculo");
		$this->loadModel("Grupo");
		$this->loadModel("Setor");
		$this->loadModel("Departamento");
		
		$grupos = $this->Grupo->find("list", array('fields' => array('Grupo.id', 'Grupo.titulo'), 'conditions' => array('Grupo.status' => Util::ATIVO)));
		$cargos = $this->Cargo->find("list", array('fields' => array('Cargo.id', 'Cargo.titulo'), 'conditions' => array('Cargo.status' => Util::ATIVO)));
		$vinculos = $this->Vinculo->find("list", array('fields' => array('Vinculo.id', 'Vinculo.titulo'), 'conditions' => array('Vinculo.status' => Util::ATIVO)));
		$setores = $this->Setor->find("list", array('fields' => array('Setor.id', 'Setor.titulo'), 'conditions' => array('Setor.status' => Util::ATIVO)));
		$departamentos = $this->Departamento->find("list", array('fields' => array('Departamento.id', 'Departamento.titulo'), 'conditions' => array('Departamento.status' => Util::ATIVO)));
		
		$this->set("grupos", $grupos);
		$this->set("departamentos", $departamentos);
		$this->set("cargos", $cargos);
		$this->set("vinculos", $vinculos);
		$this->set("setores", $setores);
			
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
	
		$this->Usuario->id = $id;
		if (!is_numeric($id) || !$this->Usuario->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->loadModel("Pessoa");
			$this->loadModel("Endereco");
			
			$this->Endereco->set($this->request->data);
			$this->Pessoa->set($this->request->data);
			$this->Usuario->set($this->request->data);
			
			if($this->request->data['Usuario']['senha_nova'] != $this->request->data['Usuario']['confirmacao_senha_nova']){
				$this->Usuario->invalidate('confirmacao_senha_nova', 'Confirmação de senha inválida');
			}		
			
			//Encadeamento para fazer as validações de todos os dados do usuário
			if ($this->Endereco->validates()){
				if($this->Pessoa->validates()){
					if($this->Usuario->validates()){						
						if($this->request->data['Usuario']['senha_nova'] != '' || $this->request->data['Usuario']['senha_nova'] != null){
							$this->request->data['Usuario']['senha'] = AuthComponent::password($this->request->data['Usuario']['senha_nova']);
						}						
						$this->Endereco->save($this->request->data);
						$this->request->data['Usuario']['endereco_id'] = $this->Endereco->id;
						$this->Pessoa->save($this->request->data);
						$this->request->data['Usuario']['pessoa_id'] = $this->Pessoa->id;
						$this->Usuario->save($this->request->data);
						
						$this->Audit->salvar($this->request->data, "Usuario", array(), "editar", false, $id, $this->Auth->user("id"));
						
						
						$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
						$this->redirect(array('action' => 'index'));
					}else{
						$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
					}
				}else{
					$this->Usuario->validates();
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');					
				}				
			}else{
				$this->Pessoa->validates();
				$this->Usuario->validates();
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
			
		$this->request->data = $this->Usuario->read(null, $id);
		
		$this->Audit->setDadosAntes($this->request->data);
		
		$this->loadModel("Cargo");
		$this->loadModel("Vinculo");
		$this->loadModel("Grupo");
		$this->loadModel("Setor");
		$this->loadModel("Departamento");
		
		$grupos = $this->Grupo->find("list", array('fields' => array('Grupo.id', 'Grupo.titulo'), 'conditions' => array('Grupo.status' => Util::ATIVO)));
		$cargos = $this->Cargo->find("list", array('fields' => array('Cargo.id', 'Cargo.titulo'), 'conditions' => array('Cargo.status' => Util::ATIVO)));
		$vinculos = $this->Vinculo->find("list", array('fields' => array('Vinculo.id', 'Vinculo.titulo'), 'conditions' => array('Vinculo.status' => Util::ATIVO)));
		$setores = $this->Setor->find("list", array('fields' => array('Setor.id', 'Setor.titulo'), 'conditions' => array('Setor.status' => Util::ATIVO)));
		$departamentos = $this->Departamento->find("list", array('fields' => array('Departamento.id', 'Departamento.titulo'), 'conditions' => array('Departamento.status' => Util::ATIVO)));
		
		$this->set("grupos", $grupos);
		$this->set("departamentos", $departamentos);
		$this->set("cargos", $cargos);
		$this->set("vinculos", $vinculos);
		$this->set("setores", $setores);
			
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
		$this->Usuario->id = $id;
		if (!is_numeric($id) || !$this->Usuario->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Usuario->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Usuario", array(), "excluir", true, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
			
	}
}

?>