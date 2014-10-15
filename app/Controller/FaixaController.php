<?php
App::uses('AppController', 'Controller');
/**
 * Faixa Controller
 *
 * @property Faixa $Faixa
 * @property SessionComponent $Session
 */
class FaixaController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$verifica_permissao = $this->Acl->check(array('model' => 'Grupo',
				'foreign_key' => $_SESSION['Auth']['User']['Grupo']['id']
		),
				'Faixa/index');
		
		if($verifica_permissao){
		
			if(!empty($this->request->data)) {			
				if(isset($_SESSION['Search']['Faixa'])){
					$count = count($_SESSION['Search']['Faixa']);
					$_SESSION['Search']['Faixa'][$count]['busca'] = $this->request->data['Faixa']['busca']; 
	           		$_SESSION['Search']['Faixa'][$count]['buscar_em'] = $this->request->data['Faixa']['buscar_em']; 
				}else{
					$_SESSION['Search']['Faixa'][0]['busca'] = $this->request->data['Faixa']['busca']; 
	            	$_SESSION['Search']['Faixa'][0]['buscar_em'] = $this->request->data['Faixa']['buscar_em']; 
				}
	        }
			
			//Lemos a sessão se não estiver vázia para aplicar os filtros
			if(isset($_SESSION['Search']['Faixa'])){
				foreach($_SESSION['Search']['Faixa'] as $termo_busca){
					$buscar_em = 'Faixa.'.$termo_busca['buscar_em']." ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
					$this->paginate['conditions'][] = array($buscar_em => $busca);
					
				}
			}
			
			$this->Faixa->recursive = 0;
			
			$this->paginate['conditions'][] = array('Faixa.status = ' => Util::ATIVO);
			$this->paginate['order'] = array('Faixa.titulo' => 'asc');
			
			$this->set('faixa', $this->paginate());
			
		}else{
			$this->Session->setFlash("Você não tem acesso ao item Faixa", 'alert');
			$this->redirect(array('controller'=> 'aplicacao' ,'action' => 'index'));
		}
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
		
		unset($_SESSION['Search']['Faixa'][$filtro]);
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
		
		$verifica_permissao = $this->Acl->check(array('model' => 'Grupo',
				'foreign_key' => $_SESSION['Auth']['User']['Grupo']['id']
		),
				'Faixa/visualizar');
		
		if($verifica_permissao){
		
			$this->Faixa->id = $id;
			if (!$this->Faixa->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			$this->set('faixa', $this->Faixa->read(null, $id));
			
		}else{
			$this->Session->setFlash("Você não tem permissão de visualizar Faixa", 'alert');
			$this->redirect(array('action' => 'index'));
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function adicionar() {
		
		$verifica_permissao = $this->Acl->check(array('model' => 'Grupo',
				'foreign_key' => $_SESSION['Auth']['User']['Grupo']['id']
		),
				'Faixa/adicionar');
		
		if($verifica_permissao){
		
			if ($this->request->is('post')) {
				$this->Faixa->create();
				if ($this->Faixa->save($this->request->data)) {
					$this->Audit->salvar($this->request->data, "Faixa", array(), "adicionar", true, $this->Faixa->id, $this->Auth->user("id"));
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
				}
			}
			
		}else{
			$this->Session->setFlash("Você não tem permissão de adicionar Faixa", 'alert');
			$this->redirect(array('action' => 'index'));
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
		
		$verifica_permissao = $this->Acl->check(array('model' => 'Grupo',
				'foreign_key' => $_SESSION['Auth']['User']['Grupo']['id']
		),
				'Faixa/editar');
		
		if($verifica_permissao){
		
			$this->Faixa->id = $id;
			if (!$this->Faixa->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->Faixa->save($this->request->data)) {
					$this->Audit->salvar($this->request->data, "Faixa", array(), "editar", false, $id, $this->Auth->user("id"));
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
				}
			}
			
			$this->request->data = $this->Faixa->read(null, $id);
			$this->Audit->setDadosAntes($this->request->data);
			
		}else{
			$this->Session->setFlash("Você não tem permissão de editar Faixa", 'alert');
			$this->redirect(array('action' => 'index'));
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
		
		$verifica_permissao = $this->Acl->check(array('model' => 'Grupo',
				'foreign_key' => $_SESSION['Auth']['User']['Grupo']['id']
		),
				'Faixa/excluir');
		
		if($verifica_permissao){
		
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			$this->Faixa->id = $id;
			if (!$this->Faixa->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			if ($this->Faixa->saveField('status', Util::INATIVO)) {
				$this->Audit->salvar("", "Faixa", array(), "excluir", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
			$this->redirect(array('action' => 'index'));
			
		}else{
			$this->Session->setFlash("Você não tem permissão de excluir Faixa", 'alert');
			$this->redirect(array('action' => 'index'));
		}
	}
}
