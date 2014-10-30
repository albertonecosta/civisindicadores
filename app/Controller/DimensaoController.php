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
 * Dimensao Controller
 *
 * @property Dimensao $Dimensao
 * @property SessionComponent $Session
 */
class DimensaoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Dimensao'])){
				$count = count($_SESSION['Search']['Dimensao']);
				$_SESSION['Search']['Dimensao'][$count]['busca'] = $this->request->data['Dimensao']['busca']; 
           		$_SESSION['Search']['Dimensao'][$count]['buscar_em'] = $this->request->data['Dimensao']['buscar_em']; 
			}else{
				$_SESSION['Search']['Dimensao'][0]['busca'] = $this->request->data['Dimensao']['busca']; 
            	$_SESSION['Search']['Dimensao'][0]['buscar_em'] = $this->request->data['Dimensao']['buscar_em']; 
			}
        }
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Dimensao'])){
			foreach($_SESSION['Search']['Dimensao'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Dimensao->recursive = 0;
		$this->paginate['conditions'][] = array('Dimensao.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Dimensao.titulo' => 'asc');
		$this->set('dimensao', $this->paginate());
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
		unset($_SESSION['Search']['Dimensao'][$filtro]);
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
		$this->Dimensao->id = $id;
		if (!$this->Dimensao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Dimensao->recursive = 2;
		$this->set('dimensao', $this->Dimensao->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Dimensao->create();
			if ($this->Dimensao->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Dimensão", array(), "adicionar", true, $this->Dimensao->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$ordem = array();
		for ($i = 1; $i <= 9; $i++){
			$ordem[$i] = $i;
		}
		
		$this->loadModel('Empresa');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$empresas2 = $this->Empresa->find('all', array('conditions' => array('Empresa.status' => Util::ATIVO), 'fields' => array('Empresa.id', 'Pessoa.titulo')));
		$empresas = array();
		foreach($empresas2 as $empresa){
			$empresas[$empresa['Empresa']['id']] = $empresa['Pessoa']['titulo'];
		}
		
		$this->set('ordem', $ordem);
		$this->set('empresas', $empresas);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Dimensao->id = $id;
		if (!$this->Dimensao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dimensao->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Dimensão", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Dimensao->read(null, $id);
			$this->Audit->setDadosAntes($this->request->data);
		}
		
		$ordem = array();
		for ($i = 1; $i <= 9; $i++){
			$ordem[$i] = $i;
		}
			
		$this->loadModel('Empresa');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$empresas2 = $this->Empresa->find('all', array('conditions' => array('Empresa.status' => Util::ATIVO), 'fields' => array('Empresa.id', 'Pessoa.titulo')));
		$empresas = array();
		foreach($empresas2 as $empresa){
			$empresas[$empresa['Empresa']['id']] = $empresa['Pessoa']['titulo'];
		}
		
		$this->set('ordem', $ordem);
		$this->set('empresas', $empresas);
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
		$this->Dimensao->id = $id;
		if (!$this->Dimensao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Dimensao->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Dimensão", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
