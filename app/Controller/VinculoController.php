<?php
App::uses('AppController', 'Controller');
/**
 * Vinculo Controller
 *
 * @property Vinculo $Vinculo
 * @property SessionComponent $Session
 */
class VinculoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Vinculo'])){
				$count = count($_SESSION['Search']['Vinculo']);
				$_SESSION['Search']['Vinculo'][$count]['busca'] = $this->request->data['Vinculo']['busca']; 
           		$_SESSION['Search']['Vinculo'][$count]['buscar_em'] = $this->request->data['Vinculo']['buscar_em']; 
			}else{
				$_SESSION['Search']['Vinculo'][0]['busca'] = $this->request->data['Vinculo']['busca']; 
            	$_SESSION['Search']['Vinculo'][0]['buscar_em'] = $this->request->data['Vinculo']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Vinculo'])){
			foreach($_SESSION['Search']['Vinculo'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Vinculo->recursive = 0;
		$this->paginate['conditions'][] = array('Vinculo.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Vinculo.titulo' => 'asc');
		$this->set('vinculo', $this->paginate());
		
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
		unset($_SESSION['Search']['Vinculo'][$filtro]);
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
		$this->Vinculo->id = $id;
		if (!$this->Vinculo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('vinculo', $this->Vinculo->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Vinculo->create();
			if ($this->Vinculo->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Vinculo", array(), "adicionar", true, $this->Vinculo->id, $this->Auth->user("id"));
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
		$this->Vinculo->id = $id;
		if (!$this->Vinculo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Vinculo->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Vinculo", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Vinculo->read(null, $id);
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
		$this->Vinculo->id = $id;
		if (!$this->Vinculo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Vinculo->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Vinculo", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
	
}
