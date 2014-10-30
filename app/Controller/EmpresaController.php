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
 * Empresa Controller
 *
 * @property Empresa $Empresa
 * @property SessionComponent $Session
 */
class EmpresaController extends AppController {
	
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
			if(isset($_SESSION['Search']['Empresa'])){
				$count = count($_SESSION['Search']['Empresa']);
				$_SESSION['Search']['Empresa'][$count]['busca'] = $this->request->data['Empresa']['busca']; 
           		$_SESSION['Search']['Empresa'][$count]['buscar_em'] = $this->request->data['Empresa']['buscar_em']; 
			}else{
				$_SESSION['Search']['Empresa'][0]['busca'] = $this->request->data['Empresa']['busca']; 
            	$_SESSION['Search']['Empresa'][0]['buscar_em'] = $this->request->data['Empresa']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Empresa'])){
			foreach($_SESSION['Search']['Empresa'] as $termo_busca){
				$buscar_em = $termo_busca['buscar_em']." ILIKE";
				$busca = '%'.addslashes($termo_busca['busca']).'%';
				$this->paginate['conditions'][] = array($buscar_em => $busca);
				
			}
		}
		$this->Empresa->recursive = 1;
		
		$this->paginate['conditions'][] = array('Empresa.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Pessoa.titulo' => 'asc');
		
		$this->set('empresa', $this->paginate());
		
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
		unset($_SESSION['Search']['Empresa'][$filtro]);
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
		$this->Empresa->id = $id;
		if (!$this->Empresa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Empresa->recursive = 2;
		$this->set('empresa', $this->Empresa->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
		
		if ($this->request->is('post')) {
			$this->Empresa->create();
			$this->loadModel("Pessoa");
			$this->loadModel("Endereco");
			
			$this->Endereco->set($this->request->data);
			$this->Pessoa->set($this->request->data);
			$this->Empresa->set($this->request->data);			
			
			//Encadeamento para fazer as validações de todos os dados da empresa
			if ($this->Endereco->validates()){
				if($this->Pessoa->validates()){
					if($this->Empresa->validates()){						
						
						$this->Endereco->save($this->request->data);
						$this->request->data['Pessoa']['endereco_id'] = $this->Endereco->id;
						$this->Pessoa->save($this->request->data);
						$this->request->data['Empresa']['pessoa_id'] = $this->Pessoa->id;
						$this->Empresa->save($this->request->data);
						
						$this->Audit->salvar($this->request->data, "Empresa", array(), "adicionar", true, $this->Empresa->id, $this->Auth->user("id"));
						
						$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
						$this->redirect(array('action' => 'index'));
					}else{
						$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
					}
				}else{
					$this->Empresa->validates();
					$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');					
				}				
			}else{
				$this->Pessoa->validates();
				$this->Empresa->validates();
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
			
		}
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$empresas2 = $this->Empresa->find('all', array('conditions' => array('Empresa.status' => Util::ATIVO, 'Empresa.matriz' => '1'), 'fields' => array('Empresa.id', 'Pessoa.titulo')));
		$empresas = array();
		foreach($empresas2 as $empresa){
			$empresas[$empresa['Empresa']['id']] = $empresa['Pessoa']['titulo'];
		}
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
	
		$this->Empresa->id = $id;
		if (!is_numeric($id) || !$this->Empresa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->loadModel("Pessoa");
			$this->loadModel("Endereco");
			
			$this->Endereco->set($this->request->data);
			$this->Pessoa->set($this->request->data);
			$this->Empresa->set($this->request->data);		
			
			//Encadeamento para fazer as validações de todos os dados do usuário
			if ($this->Endereco->validates()){
				if($this->Pessoa->validates()){
					if($this->Empresa->validates()){	
						$this->Endereco->save($this->request->data);
						$this->request->data['Pessoa']['endereco_id'] = $this->Endereco->id;
						$this->Pessoa->save($this->request->data);
						$this->request->data['Empresa']['pessoa_id'] = $this->Pessoa->id;
						$this->Empresa->save($this->request->data);
						
						$this->Audit->salvar($this->request->data, "Empresa", array(), "editar", false, $id, $this->Auth->user("id"));
						
						$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
						$this->redirect(array('action' => 'index'));
					}else{
						$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
					}
				}else{
					$this->Empresa->validates();
					$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');					
				}				
			}else{
				$this->Pessoa->validates();
				$this->Empresa->validates();
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$empresas2 = $this->Empresa->find('all', array('conditions' => array('Empresa.status' => Util::ATIVO, 'Empresa.matriz' => '1', 'Empresa.id !=' => $id), 'fields' => array('Empresa.id', 'Pessoa.titulo')));
		$empresas = array();
		foreach($empresas2 as $empresa){
			$empresas[$empresa['Empresa']['id']] = $empresa['Pessoa']['titulo'];
		}
		$this->set('empresas', $empresas);
		$this->request->data = $this->Empresa->read(null, $id);
		$this->loadModel("Endereco");
		$endereco = $this->Endereco->find('first', array('conditions'=>array('id'=>$this->request->data["Pessoa"]["endereco_id"])));
		if($endereco){
			$this->request->data["Endereco"] = $endereco["Endereco"];
		}
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
		$this->Empresa->id = $id;
		if (!is_numeric($id) || !$this->Empresa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Empresa->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Empresa", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
	
}
