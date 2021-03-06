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
 * Faixa Controller
 *
 * @property Faixa $Faixa
 * @property SessionComponent $Session
 */
class FaixaController extends AppController {
	
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
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		
		$this->Faixa->recursive = 0;
		
		$this->paginate['conditions'][] = array('Faixa.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Faixa.titulo' => 'asc');
		
		$this->set('faixa', $this->paginate());
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
		$this->Faixa->id = $id;
		if (!$this->Faixa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('faixa', $this->Faixa->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
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
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
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
	}
	
}
