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
 * Procedimento Controller
 *
 * @property Procedimento $Procedimento
 * @property SessionComponent $Session
 */
class ProcedimentoController extends AppController {
	
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
			if(isset($_SESSION['Search']['Procedimento'])){
				$count = count($_SESSION['Search']['Procedimento']);
				$_SESSION['Search']['Procedimento'][$count]['busca'] = $this->request->data['Procedimento']['busca']; 
           		$_SESSION['Search']['Procedimento'][$count]['buscar_em'] = $this->request->data['Procedimento']['buscar_em']; 
			}else{
				$_SESSION['Search']['Procedimento'][0]['busca'] = $this->request->data['Procedimento']['busca']; 
            	$_SESSION['Search']['Procedimento'][0]['buscar_em'] = $this->request->data['Procedimento']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Procedimento'])){
			foreach($_SESSION['Search']['Procedimento'] as $termo_busca){
				$buscar_em = 'Procedimento.'.$termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Procedimento->recursive = 2;
		
		$this->paginate['conditions'][] = array('Procedimento.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Procedimento.titulo' => 'asc');
		
		$this->set('procedimento', $this->paginate());
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
		
		unset($_SESSION['Search']['Procedimento'][$filtro]);
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
		$this->Procedimento->id = $id;
		if (!$this->Procedimento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Procedimento->recursive = 2;
		$this->set('procedimento', $this->Procedimento->read(null, $id));
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
		$this->Procedimento->id = $id;
		if (!$this->Procedimento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Procedimento->recursive = 2;
		$this->set('procedimento', $this->Procedimento->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Procedimento->create();
			if ($this->Procedimento->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Procedimento", array(), "adicionar", true, $this->Procedimento->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$this->set("usuarios", $usuarios);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Procedimento->id = $id;
		if (!$this->Procedimento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Procedimento->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Procedimento", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$this->set("usuarios", $usuarios);
		
		$this->request->data = $this->Procedimento->read(null, $id);
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
		$this->Procedimento->id = $id;
		if (!$this->Procedimento->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Procedimento->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Procedimento", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
