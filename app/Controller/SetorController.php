<?php
App::uses('AppController', 'Controller');
/**
 * Setor Controller
 *
 * @property Setor $Setor
 * @property SessionComponent $Session
 */
class SetorController extends AppController {
	
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
		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['Setor'])){
				$count = count($_SESSION['Search']['Setor']);
				$_SESSION['Search']['Setor'][$count]['busca'] = $this->request->data['Setor']['busca']; 
           		$_SESSION['Search']['Setor'][$count]['buscar_em'] = $this->request->data['Setor']['buscar_em']; 
			}else{
				$_SESSION['Search']['Setor'][0]['busca'] = $this->request->data['Setor']['busca']; 
            	$_SESSION['Search']['Setor'][0]['buscar_em'] = $this->request->data['Setor']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Setor'])){
			foreach($_SESSION['Search']['Setor'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Setor->recursive = 0;
		$this->paginate['conditions'][] = array('Setor.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Setor.titulo' => 'asc');
		$this->set('setor', $this->paginate());
		
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
		unset($_SESSION['Search']['Setor'][$filtro]);
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
		$this->Setor->id = $id;
		if (!$this->Setor->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('setor', $this->Setor->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Setor->create();
			if ($this->Setor->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Setor", array(), "adicionar", true, $this->Setor->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Setor->id = $id;
		if (!$this->Setor->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Setor->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Setor", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Setor->read(null, $id);
		}
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
		$this->Setor->id = $id;
		if (!$this->Setor->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Setor->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Setor", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
