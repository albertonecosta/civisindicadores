<?php
App::uses('AppController', 'Controller');
/**
 * Grupo Controller
 *
 * @property Grupo $Grupo
 * @property SessionComponent $Session
 */
class GrupoController extends AppController {
	
	/**
	 * Models usados no controller
	 * @var array
	 */
	var $uses = array("Grupo", "Permissao", "Regra");
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::beforeFilter()
	 */
	public function beforeFilter(){
		parent::beforeFilter();
	}


	/**
	 * index method
	 * Método responsável pela exibição dos dados principais da seção
	 * @return void
	 */
	public function index() {
		
		if(!empty($this->request->data)) {
			if(isset($_SESSION['Search']['Grupo'])){
				$count = count($_SESSION['Search']['Grupo']);
				$_SESSION['Search']['Grupo'][$count]['busca'] = $this->request->data['Grupo']['busca'];
				$_SESSION['Search']['Grupo'][$count]['buscar_em'] = $this->request->data['Grupo']['buscar_em'];
			}else{
				$_SESSION['Search']['Grupo'][0]['busca'] = $this->request->data['Grupo']['busca'];
				$_SESSION['Search']['Grupo'][0]['buscar_em'] = $this->request->data['Grupo']['buscar_em'];
			}
		}
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Grupo'])){
			foreach($_SESSION['Search']['Grupo'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
		
			}
		}
		
		$this->Grupo->recursive = 0;
		$this->paginate['conditions'][] = array('Grupo.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Grupo.titulo' => 'asc');
		
		//Verificando algumas permissões
		$this->set('grupo', $this->paginate());
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
		unset($_SESSION['Search']['Grupo'][$filtro]);
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
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('grupo', $this->Grupo->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		
		if ($this->request->is('post')) {
			
			$this->Grupo->begin(); // iniciando transação
			
			try{
				
				if ($this->Grupo->save($this->request->data)) {
					
					if(isset($this->request->data['permissoes']) && is_array($this->request->data['permissoes'])){
						foreach($this->request->data['permissoes'] as $chave => $flag){
							foreach($flag as $acao){
								$grupoPermissoes = $this->ControleDeAcesso->getRestricoesPorChave($chave. "." . $acao);
								if(count($grupoPermissoes)>0){
									$this->Permissao->create(array('grupo_id'=>$this->Grupo->id, 'descricao'=>$chave. "." . $acao));
									$respPermissao = $this->Permissao->save();
									if(!$respPermissao){
										throw new Exception("Erro ao salvar permissão",null);
									}
									foreach($grupoPermissoes as $permissao){
										$this->Regra->create(array('permissao_id'=>$respPermissao['Permissao']['id'], 'descricao'=>$permissao));
										if(!$this->Regra->save()){
											throw new Exception("Erro ao salvar regra",null);
										}
									}
								}
									
							}
						}
					}
					
					$this->Audit->salvar($this->request->data, "Grupo", array(), "adicionar", true, $this->Grupo->id, $this->Auth->user("id"));				
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
					$this->Grupo->commit();
					$this->redirect(array('action' => 'index'));
					
				} else {
					$this->Grupo->rollback();
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
				}
				
			}catch(Exception $e){
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
				$this->Grupo->rollback();
			}
		}
		$this->set('restricoes', $this->ControleDeAcesso->getRestricoes());
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		
		$this->Grupo->id = $id;		
		if (!$this->Grupo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {	
			$this->Grupo->begin();
			try{	
				if ($this->Grupo->save($this->request->data)) {
					
					// DELETANDO AS REGRAS, PARA QUE POSSAM SER INSERIDAS NOVAMENTE
					$this->Grupo->query("DELETE FROM regras WHERE permissao_id IN (SELECT id FROM permissoes WHERE grupo_id = $id)");
					
					// DELETANDO AS PERMISSÕES, PARA QUE POSSAM SER INSERIDAS NOVAMENTE
					$this->Grupo->query("DELETE FROM permissoes WHERE grupo_id = $id");
						
					// INSERINDO AS REGRAS DE PERMISSÃO NO PERFIL
					if(isset($this->request->data['permissoes']) && is_array($this->request->data['permissoes'])){
						foreach($this->request->data['permissoes'] as $chave => $flag){
							foreach($flag as $acao){
								$grupoPermissoes = $this->ControleDeAcesso->getRestricoesPorChave($chave. "." . $acao);
								if(count($grupoPermissoes)>0){
									$this->Permissao->create(array('grupo_id'=>$id, 'descricao'=>$chave. "." . $acao));
									$respPermissao = $this->Permissao->save();
									if(!$respPermissao){
										throw new Exception("Erro ao salvar permissão",null);
									}
									foreach($grupoPermissoes as $permissao){
										$this->Regra->create(array('permissao_id'=>$respPermissao['Permissao']['id'], 'descricao'=>$permissao));
										if(!$this->Regra->save()){
											throw new Exception("Erro ao salvar regra",null);
										}
									}
								}
									
							}
						}
					}
					
					$this->Audit->salvar($this->request->data, "Grupo", array(), "editar", false, $id, $this->Auth->user("id"));
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
					$this->Grupo->commit();
					$this->redirect(array('action' => 'index'));
					
				} else {
					
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'erro');
					$this->Grupo->rollback();
				}
			}catch(Exception $e){
				echo $e->getMessage();
				die;
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
				$this->Grupo->rollback();
			}
		}
		
		$this->request->data = $this->Grupo->read(null, $id);
		$this->Audit->setDadosAntes($this->request->data);
		$permissoes = array() ;
		if(isset($this->request->data['Permissao']) && count($this->request->data['Permissao'])>0){
			foreach($this->request->data['Permissao'] as $permissao){
				$permissoes[] = $permissao['descricao'];
			}
		}
		$this->set('permissoes', $permissoes);
		$this->set('restricoes', $this->ControleDeAcesso->getRestricoes());
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
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Grupo->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Grupo", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
			
	}
}
