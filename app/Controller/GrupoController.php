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
		$acos = $this->Grupo->query("select * from acos");
		$this->set("acos", $acos);
		if ($this->request->is('post')) {
			if ($this->Grupo->save($this->request->data)) {
				$grupo = $this->Grupo;
				//Definindo as permissões padrões do sistema
				$this->Acl->deny($grupo, "controllers");
				$this->Acl->allow($grupo, "controllers/Usuario/login");
				$this->Acl->allow($grupo, "controllers/Usuario/logout");
				//Definindo as permissões escolhidas pelo usuário
				foreach($this->request->data['ModuloAcao'] as $moduloAcao){
					if(isset($moduloAcao['acao_alias'])){
						$aco = "controllers/".$moduloAcao['modulo_alias'][0];
						$this->Acl->deny($grupo, $aco);
						foreach($moduloAcao['acao_alias'] as $acaoAlias){
							$aco = "controllers/".$moduloAcao['modulo_alias'][0]."/".$acaoAlias;
							$this->Acl->allow($grupo, $aco);
						}
					}				
				}
				$this->Audit->salvar($this->request->data, "Grupo", array(), "adicionar", true, $this->Grupo->id, $this->Auth->user("id"));				
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
		
		$this->Grupo->id = $id;		
		
		//Buscamos por todos os modulos e ações do sistema
		$acos = $this->Grupo->query("select * from acos");
		$this->set("acos", $acos);
		
		//Buscamos pelas permissões do aro em questão para comparar no select da view
		$aro = $this->Grupo->query("select id from aros where model = 'Grupo' and foreign_key = $id");
		$aroId = $aro[0][0]['id'];
		$arosAcos = $this->Grupo->query("select * from aros_acos where aro_id = $aroId");
		$idAcos = array();
		foreach($arosAcos as $aroAco){
			$idAcos[] = $aroAco[0]['aco_id'];
		}
		$this->set("idAcos", $idAcos);
		
		if (!$this->Grupo->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {		
			if ($this->Grupo->save($this->request->data)) {
				//deletamos as relações antigas
				$this->Grupo->query("delete from aros_acos where aro_id = $aroId");			
				$grupo = $this->Grupo;
				//Definindo as permissões padrões do sistema
				$this->Acl->deny($grupo, "controllers");
				$this->Acl->allow($grupo, "controllers/Usuario/login");
				$this->Acl->allow($grupo, "controllers/Usuario/logout");
				//Definindo as permissões escolhidas pelo usuário
				foreach($this->request->data['ModuloAcao'] as $moduloAcao){
					if(isset($moduloAcao['acao_alias'])){
						$aco = "controllers/".$moduloAcao['modulo_alias'][0];
						$this->Acl->deny($grupo, $aco);
						foreach($moduloAcao['acao_alias'] as $acaoAlias){
							$aco = "controllers/".$moduloAcao['modulo_alias'][0]."/".$acaoAlias;
							$this->Acl->allow($grupo, $aco);
						}
					}			
				}
				$this->Audit->salvar($this->request->data, "Grupo", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		$this->request->data = $this->Grupo->read(null, $id);
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
