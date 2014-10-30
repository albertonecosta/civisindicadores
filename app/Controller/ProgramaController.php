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
 * Programa Controller
 *
 * @property Programa $Programa
 * @property SessionComponent $Session
 */
class ProgramaController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		
		//Verificamos se o Array de dados de busca vem com dados para adicionarmos na sessão		
		if(!empty($this->request->data)) {	

			if(isset($_SESSION['Search']['Programa'])){
				$count = count($_SESSION['Search']['Programa']);
				$_SESSION['Search']['Programa'][$count]['busca'] = $this->request->data['Programa']['busca']; 
           		$_SESSION['Search']['Programa'][$count]['buscar_em'] = $this->request->data['Programa']['buscar_em']; 
			}else{
				$_SESSION['Search']['Programa'][0]['busca'] = $this->request->data['Programa']['busca']; 
            	$_SESSION['Search']['Programa'][0]['buscar_em'] = $this->request->data['Programa']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
        $busca = array();
		if(isset($_SESSION['Search']['Programa'])){
			foreach($_SESSION['Search']['Programa'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Programa.data_inicio"){
					$busca[] = "AND to_char({$termo_busca['buscar_em']}, 'DD/MM/YYYY') ILIKE '%".addslashes($termo_busca['busca'])."%'";
				}else{
					$busca[] = "AND {$termo_busca['buscar_em']} ILIKE '%".addslashes($termo_busca['busca'])."%'";
				}
			}
		}
		$busca = implode(" ", $busca);
		$pagina = (empty($_GET['pagina'])) ? 1 : $_GET['pagina'];
		$offset = $this->offset($pagina);
		
		$programa = $this->Programa->query("
			SELECT Programa.* 
			FROM programa Programa 
			WHERE Programa.status = ".Util::ATIVO." {$busca}
			ORDER BY Programa.data_fim asc LIMIT ". self::PERPAGE ." OFFSET $offset
		");
		
		$total = $this->Programa->query("
				SELECT count(*) as total
				FROM programa Programa
				WHERE Programa.status = ".Util::ATIVO." {$busca}");
		$total = $total[0][0]["total"];
		
		$this->loadModel('Projeto');
		$this->Projeto->recursive = 0;
		$programas = array();
		$projetos = array();
		foreach($programa as $p){
			$programas[] = $p[0];
			$projetos[$p[0]['id']] = $this->Projeto->find('all', array('conditions'=>array('Projeto.programa_id'=>$p[0]['id']),'order' => array('Projeto.data_inicio_previsto','Projeto.titulo')));
		}
		
		$this->paginacao($programas, $total, $pagina);
		$this->set('programas', $programas);
		$this->set('projetos', $projetos);
		$this->set('total', $total);
		
		
		
		
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
		
		unset($_SESSION['Search']['Programa'][$filtro]);
		$this->redirect(array('action' => 'index'));	
	}
	
/**
 * imprimir method
 *
 * @throws NotFoundException
 * @param int $id
 * @return void
 */
public function imprimir($id = null) {
		
		
		$this->layout = 'ajax';
		$this->Programa->id = $id;
		
		
		if (!$this->Programa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$programa = $this->Programa->read(null, $id);
		
		/*
		 * Algoritimo para pegar os dados das ações
		 */
		$programa = array($programa);
		
		$this->loadModel('Projeto');
		$projetos = $this->Projeto->query("
			SELECT Projeto.*
			FROM projeto Projeto 
			WHERE Projeto.programa_id = {$id}
			ORDER BY Projeto.data_inicio_previsto asc,Projeto.titulo
		");
		
		foreach($projetos as $novas){
			$projetos1[] = $novas[0];
		}
		
		$this->set('projetos', $projetos1);	
		$this->set('programa', $programa);
	}
/**
 * visulizar method
 *
 * @throws NotFoundException
 * @param int $id
 * @return void
 */
	public function visualizar($id = null) {
		
		
		$this->Programa->id = $id;
		if (!$this->Programa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Programa->recursive = 2;
		$this->set('programa', $this->Programa->read(null, $id));
		
		$this->loadModel('Projeto');
		$projetos = $this->Projeto->query("
			SELECT Projeto.*
			FROM projeto Projeto 
			WHERE Projeto.programa_id = {$id}
			ORDER BY Projeto.data_inicio_previsto asc,Projeto.titulo
		");
		
		foreach($projetos as $novas){
			$projetos1[] = $novas[0];
		}
		
		$this->set('projetos', $projetos1);
		
		
	}

/**
 * adicionar method
 *
 * @return void
 */
	public function adicionar() {
		
				
		if ($this->request->is('post')) {
			$this->Programa->create();
			if ($this->Programa->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Programa", array(), "adicionar", true, $this->Programa->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		
	}
	

/**
 * editar method
 *
 * @throws NotFoundException
 * @param int $id
 * @return void
 */
	public function editar($id = null) {
		
	
				
			
		$this->Programa->id = $id;
		$this->Programa->read();
		
		
		if (!$this->Programa->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Programa->save($this->request->data)) {				
				$this->Audit->salvar($this->request->data, "Programa", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		
		$this->request->data = $this->Programa->read(null, $id);
		
		
	}

	/**
	 * Método responsável por excluir, logicamente, um programa
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function excluir($id = null) {
		
		
				
		try{
			
			// iniciando uma transação
			$DS = $this->Programa->getDataSource();
			$DS->begin();
			
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			$this->Programa->id = $id;
			if (empty($id) || !is_numeric($id) || !$this->Programa->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			
			if ($this->Programa->saveField('status', Util::INATIVO)) {
				
				// Salvando na tabela de auditoria (log)
				$this->Audit->salvar("", "Programa", array(), "excluir", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
				
				// commitando todas as transações
				$DS->commit();
				
			}else{
				// dando roll back nas transações efetuadas
				$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
				$DS->rollback();
			}
			
		}catch(Exception $e){
			$DS->rollback();
			$this->Session->setFlash($e->getMessage(), 'error');
		}
		$this->redirect(array('action' => 'index'));
	
	}
}
