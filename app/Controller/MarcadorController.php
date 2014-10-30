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
 * Marcador Controller
 *
 * @property Marcador $Marcador
 * @property SessionComponent $Session
 */
class MarcadorController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
			if(!empty($this->request->data)) {			
				if(isset($_SESSION['Search']['Marcador'])){
					$count = count($_SESSION['Search']['Marcador']);
					$_SESSION['Search']['Marcador'][$count]['busca'] = $this->request->data['Marcador']['busca']; 
	           		$_SESSION['Search']['Marcador'][$count]['buscar_em'] = $this->request->data['Marcador']['buscar_em']; 
				}else{
					$_SESSION['Search']['Marcador'][0]['busca'] = $this->request->data['Marcador']['busca']; 
	            	$_SESSION['Search']['Marcador'][0]['buscar_em'] = $this->request->data['Marcador']['buscar_em']; 
				}
	        }
			
			//Lemos a sessão se não estiver vázia para aplicar os filtros
			if(isset($_SESSION['Search']['Marcador'])){
				foreach($_SESSION['Search']['Marcador'] as $termo_busca){
					if($termo_busca['buscar_em'] == "ano"){
						$buscar_em = 'Marcador.'.$termo_busca['buscar_em']." =";
						$busca = addslashes($termo_busca['busca']);
					}else{
						$buscar_em = 'Marcador.'.$termo_busca['buscar_em']." ILIKE";
						$busca = '%'.addslashes($termo_busca['busca']).'%';
					}
					$this->paginate['conditions'][] = array($buscar_em => $busca);
					
				}
			}
			$this->Marcador->recursive = 2;
			
			$this->paginate['conditions'][] = array('Marcador.status = ' => Util::ATIVO);
			$this->paginate['order'] = array('Marcador.titulo' => 'asc');
			
			$this->set('marcador', $this->paginate());
			
		
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
		
		unset($_SESSION['Search']['Marcador'][$filtro]);
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
		$this->Marcador->id = $id;
		if (!$this->Marcador->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Marcador->recursive = 2;
		$this->set('marcador', $this->Marcador->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function adicionar() {
		
		
			if ($this->request->is('post')) {
				
				$ds = $this->Marcador->getDataSource();
				$ds->begin();
				
				$this->Marcador->create();
				
				if ($this->Marcador->save($this->request->data)) {
					
					if(!empty($this->request->data["Marcador"]["objetivo_id"])){
						
						$this->loadModel('MarcadorObjetivo');
						foreach($this->request->data["Marcador"]["objetivo_id"] as $objetivo_id){
							$this->MarcadorObjetivo->create();
							$this->MarcadorObjetivo->save(array('marcador_id'=>$this->Marcador->id, 'objetivo_id'=>$objetivo_id));
						}
					
						$this->Audit->salvar($this->request->data, "Marcador", array(), "adicionar", true, $this->Marcador->id, $this->Auth->user("id"));
						$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
						$ds->commit();
						$this->redirect(array('action' => 'index'));
					
					}else{
						$ds->rollback();
						$this->Marcador->invalidate('objetivo_id', "Selecione pelo menos uma ação");
					}
					
				} else {
					$ds->rollback();
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
				}
			}
			
			$ordem = array();
			for ($i = 1; $i <= 9; $i++){
				$ordem[$i] = $i;
			}
			$this->loadModel('Objetivo');
			$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status !=' => Util::INATIVO, 'Objetivo.tipo' => Util::TIPO_MEDIDA), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
				
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
		
		
			$this->Marcador->id = $id;
			if (!$this->Marcador->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				
				$ds = $this->Marcador->getDataSource();
				$ds->begin();
				
				if ($this->Marcador->save($this->request->data)) {
					
					if(!empty($this->request->data["Marcador"]["objetivo_id"])){
					
						$this->loadModel('MarcadorObjetivo');
						$this->MarcadorObjetivo->query("delete from marcador_objetivo where marcador_id = {$id}");
						
						foreach($this->request->data["Marcador"]["objetivo_id"] as $objetivo_id){
							$this->MarcadorObjetivo->create();
							if(!$this->MarcadorObjetivo->save(array('marcador_id'=>$this->Marcador->id, 'objetivo_id'=>$objetivo_id))){
								$ds->rollback();
								die("Erro de SQL!");
							}
						}
					
						$this->Audit->salvar($this->request->data, "Marcador", array(), "editar", false, $id, $this->Auth->user("id"));
						$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
						$ds->commit();
						
						$this->redirect(array('action' => 'index'));
						
					}else{
						$ds->rollback();
						$this->Marcador->invalidate('objetivo_id', "Selecione pelo menos uma ação");
					}
					
				} else {
					$ds->rollback();
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
				}
				
			}else{
				$this->Marcador->recursive = 1;
				$this->request->data = $this->Marcador->read(null, $id);
				$arraySelecionados = array();
				foreach($this->request->data["MarcadorObjetivo"] as $obj){
					$arraySelecionados[] = $obj["objetivo_id"];
				}
				$this->request->data["Marcador"]["objetivo_id"] = $arraySelecionados;
			}
			
			$this->loadModel('Objetivo');
			$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status !=' => Util::INATIVO, 'Objetivo.tipo' => Util::TIPO_MEDIDA), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));
			
			$this->set('objetivos', $objetivos);
				
			$ordem = array();
			for ($i = 1; $i <= 9; $i++){
				$ordem[$i] = $i;
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
			$this->Marcador->id = $id;
			if (!$this->Marcador->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			if ($this->Marcador->saveField('status', Util::INATIVO)) {
				$this->Audit->salvar("", "Marcador", array(), "excluir", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
			$this->redirect(array('action' => 'index'));
		
	}
}
