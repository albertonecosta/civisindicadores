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
/**
 * Objetivo Controller
 *
 * @property Objetivo $Objetivo
 * @property SessionComponent $Session
 */
class ObjetivoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Objetivo'])){
				$count = count($_SESSION['Search']['Objetivo']);
				$_SESSION['Search']['Objetivo'][$count]['busca'] = $this->request->data['Objetivo']['busca']; 
           		$_SESSION['Search']['Objetivo'][$count]['buscar_em'] = $this->request->data['Objetivo']['buscar_em']; 
			}else{
				$_SESSION['Search']['Objetivo'][0]['busca'] = $this->request->data['Objetivo']['busca']; 
            	$_SESSION['Search']['Objetivo'][0]['buscar_em'] = $this->request->data['Objetivo']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Objetivo'])){
			foreach($_SESSION['Search']['Objetivo'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Objetivo.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					$buscar_em = $termo_busca['buscar_em']." ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
				}
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		$this->Objetivo->recursive = 0;
		$this->paginate['conditions'][] = array('Objetivo.status = ' => Util::ATIVO,'Objetivo.tipo' => 1);
		$this->paginate['order'] = array('Objetivo.titulo' => 'asc');
		$this->set('objetivo', $this->paginate());
		
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
		unset($_SESSION['Search']['Objetivo'][$filtro]);
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
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Objetivo->recursive = 2;
		$this->set('objetivo', $this->Objetivo->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->request->data["Objetivo"]["tipo"]=1;
			$this->Objetivo->create();
			if ($this->Objetivo->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Objetivo", array(), "adicionar", true, $this->Objetivo->id, $this->Auth->user("id"));
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
		
		$this->loadModel('Dimensao');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$dimensoes2 = $this->Dimensao->find('all', array('conditions' => array('Dimensao.status' => Util::ATIVO), 'fields' => array('Dimensao.id', 'Dimensao.titulo')));
		$dimensoes = array();
		foreach($dimensoes2 as $dimensao){
			$dimensoes[$dimensao['Dimensao']['id']] = $dimensao['Dimensao']['titulo'];
		}
		
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO, 'Objetivo.tipo' => Util::TIPO_PADRAO), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('objetivos', $objetivos);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {		
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Objetivo->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Objetivo", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Objetivo->read(null, $id);
		}
		
		$ordem = array();
		for ($i = 1; $i <= 9; $i++){
			$ordem[$i] = $i;
		}
			
		$this->loadModel('Dimensao');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$dimensoes2 = $this->Dimensao->find('all', array('conditions' => array('Dimensao.status' => Util::ATIVO), 'fields' => array('Dimensao.id', 'Dimensao.titulo')));
		$dimensoes = array();
		foreach($dimensoes2 as $dimensao){
			$dimensoes[$dimensao['Dimensao']['id']] = $dimensao['Dimensao']['titulo'];
		}
		
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO, 'Objetivo.tipo' => Util::TIPO_PADRAO, 'Objetivo.id !=' => $id), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('objetivos', $objetivos);
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
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Objetivo->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Objetivo", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
