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
 * Anomalia Controller
 *
 * @property Anomalia $Anomalia
 * @property SessionComponent $Session
 */
class AnomaliaController extends AppController {
	
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
		
		//unset($_SESSION['Search']['Anomalia']);
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['Anomalia'])){
				$count = count($_SESSION['Search']['Anomalia']);
				$_SESSION['Search']['Anomalia'][$count]['busca'] = $this->request->data['Anomalia']['busca']; 
           		$_SESSION['Search']['Anomalia'][$count]['buscar_em'] = $this->request->data['Anomalia']['buscar_em']; 
			}else{
				$_SESSION['Search']['Anomalia'][0]['busca'] = $this->request->data['Anomalia']['busca']; 
            	$_SESSION['Search']['Anomalia'][0]['buscar_em'] = $this->request->data['Anomalia']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Anomalia'])){
			foreach($_SESSION['Search']['Anomalia'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Anomalia.data"){
					$buscar_em = 'TO_CHAR('.$termo_busca['buscar_em'].",'DD/MM/YYYY') ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
					$this->paginate['conditions'][] = array($buscar_em => $busca);
				}else{
					$buscar_em = $termo_busca['buscar_em']." ILIKE";
					$busca = '%'.addslashes($termo_busca['busca']).'%';
					$this->paginate['conditions'][] = array($buscar_em => $busca);
				}
			}
		}
		$this->Anomalia->recursive = 1;
		
		$this->paginate['conditions'][] = array('Anomalia.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Anomalia.id' => 'asc');
		
		$this->set('anomalia', $this->paginate());
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
		unset($_SESSION['Search']['Anomalia'][$filtro]);
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
		$this->Anomalia->id = $id;
		if (!$this->Anomalia->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('anomalia', $this->Anomalia->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->Anomalia->create();
			if ($this->Anomalia->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Anomalia", array(), "adicionar", true, $this->Anomalia->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		$this->loadModel("Indicador");
		$indicadores = $this->Indicador->find("list", array('conditions' => array('Indicador.status' => Util::ATIVO), 'fields' => array('Indicador.id', 'Indicador.titulo')));
		$this->set("indicadores", $indicadores);
	}
	
	/**
	 * 
	 */
	public function ajaxAdicionar(){
		$this->layout = "ajax";
		if ($this->request->is('post')) {
			$this->Anomalia->create();
			if ($this->Anomalia->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Anomalia", array(), "adicionar", true, $this->Anomalia->id, $this->Auth->user("id"));
				echo Util::REGISTRO_ADICIONADO_SUCESSO;
				die;
			} else {
				echo Util::REGISTRO_ADICIONADO_FALHA;
				die;
			}
		}
		$data = date("d")."/".$_GET['mes']."/".date("Y");
		$this->loadModel("Indicador");
		$indicadores = $this->Indicador->find("list", array('conditions' => array('Indicador.status' => Util::ATIVO), 'fields' => array('Indicador.id', 'Indicador.titulo')));
		$this->set("indicadores", $indicadores);
		$this->set("data", $data);
		$this->set("idIndicador", $_GET['idIndicador']);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Anomalia->id = $id;
		if (!$this->Anomalia->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Anomalia->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Anomalia", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		$this->loadModel("Indicador");
		$indicadores = $this->Indicador->find("list", array('conditions' => array('Indicador.status' => Util::ATIVO), 'fields' => array('Indicador.id', 'Indicador.titulo')));
		$this->set("indicadores", $indicadores);
		$this->request->data = $this->Anomalia->read(null, $id);
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
		$this->Anomalia->id = $id;
		if (!$this->Anomalia->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Anomalia->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Anomalia", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * ajaxPainelAnomalia method
	 *
	 * @return void
	 */
	public function ajaxPainelAnomalia($idAnomalia) {
		$this->layout = "ajax";
		$anomalia = $this->Anomalia->read(null, $idAnomalia);
		$this->loadModel('Usuario');
		$responsaveis = array();
		$count = 0;
		//Logica para pegar o responsavel pela acao - Necessario para não usar o recursivo 2 da anomalia, por problemas de performance
		foreach($anomalia['Acao'] as $acao){
			
			$responsavel = $this->Usuario->find("all", array('conditions' => array('Usuario.id' => $acao['responsavel_id'])));
			$responsaveis[$count]['Responsavel']['id'] = $responsavel[0]['Usuario']['id'];
			$responsaveis[$count]['Responsavel']['nome'] = $responsavel[0]['Pessoa']['titulo'];
			foreach($responsavel[0]['AcaoResponsavel'] as $acaoResponsavel){
				if($acaoResponsavel['id'] == $acao['id']){
					$responsaveis[$count]['Responsavel']['acao_id'] = $acaoResponsavel['id'];
				}
			}
			$this->Usuario->id = null;
			$count++;
		}
		$this->set("anomalia", $anomalia);
		$this->set("responsaveis", $responsaveis);
	}
}
