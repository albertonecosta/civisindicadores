<?php
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */
App::uses('AppController', 'Controller');
/**
 * Departamento Controller
 *
 * @property Departamento $Departamento
 * @property SessionComponent $Session
 */
class DepartamentoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Departamento'])){
				$count = count($_SESSION['Search']['Departamento']);
				$_SESSION['Search']['Departamento'][$count]['busca'] = $this->request->data['Departamento']['busca']; 
           		$_SESSION['Search']['Departamento'][$count]['buscar_em'] = $this->request->data['Departamento']['buscar_em']; 
			}else{
				$_SESSION['Search']['Departamento'][0]['busca'] = $this->request->data['Departamento']['busca']; 
            	$_SESSION['Search']['Departamento'][0]['buscar_em'] = $this->request->data['Departamento']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Departamento'])){
			foreach($_SESSION['Search']['Departamento'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Departamento->recursive = 0;
		$this->paginate['conditions'][] = array('Departamento.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Departamento.titulo' => 'asc');
		$this->set('departamento', $this->paginate());
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
		unset($_SESSION['Search']['Departamento'][$filtro]);
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
		$this->Departamento->id = $id;
		if (!$this->Departamento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('departamento', $this->Departamento->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Departamento->create();
			if ($this->Departamento->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Departamento", array(), "adicionar", true, $this->Departamento->id, $this->Auth->user("id"));
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
		$this->Departamento->id = $id;
		if (!$this->Departamento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Departamento->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Departamento", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Departamento->read(null, $id);
			$this->Audit->setDadosAntes($this->request->data);
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
		$this->Departamento->id = $id;
		if (!$this->Departamento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Departamento->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Departamento", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
