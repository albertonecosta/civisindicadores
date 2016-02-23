<?php
/**
 *
 * Copyright [2014] - Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
 *
 */
App::uses('AppController', 'Controller');
/**
 *  Controller
 *
 * @property AcaoEstrategica $AcaoEstrategica
 * @property SessionComponent $Session
 */
class AcaoEstrategicaController extends AppController {
	
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
			if(isset($_SESSION['Search']['AcaoEstrategica'])){
				$count = count($_SESSION['Search']['AcaoEstrategica']);
				$_SESSION['Search']['AcaoEstrategica'][$count]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
           		$_SESSION['Search']['AcaoEstrategica'][$count]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}else{
				$_SESSION['Search']['AcaoEstrategica'][0]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
            	$_SESSION['Search']['AcaoEstrategica'][0]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}
        }
		
		
		$situacao_busca = array('não informado' => Util::NAO_INFORMADO,'adequado'  => Util::ADEQUADO,'atenção'  => Util::ATENCAO,'preocupante'  => Util::PREOCUPANTE,'concluído' => Util::CONCLUIDO);
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['AcaoEstrategica'])){
			foreach($_SESSION['Search']['AcaoEstrategica'] as $termo_busca){
				if($termo_busca['buscar_em'] == "AcaoEstrategica.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "AcaoEstrategica.data_ultima_atualizacao"){
						$buscar_em = 'AcaoEstrategica.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "AcaoEstrategica.situacao"){
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($situacao_busca[strtolower($termo_busca['busca'])]).'%';
						}
						else {
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($termo_busca['busca']).'%';
						}
					}
				}				
				
				
				$this->paginate['conditions'][] = array($buscar_em => $busca);
			}
		}
		$this->AcaoEstrategica->recursive = 0;
		
		
		
		if ($this->usuarioLogado["Grupo"]["titulo"] == "Ponto Focal") {
			$this->paginate['conditions'][] = array('AcaoEstrategica.titulo ILIKE' => ''.$this->usuarioLogado["Departamento"]["titulo"].'__ -%');
		}
		
		$this->paginate['conditions'][] = array('AcaoEstrategica.tipo' => 2,'AcaoEstrategica.status !=' => Util::INATIVO );
		
		$this->paginate['order'] = array('AcaoEstrategica.titulo' => 'asc');
		
		
		$this->loadModel('ObjetivoProjeto');
		$objetivoProjeto = $this->ObjetivoProjeto->query("
			SELECT ObjetivoProjeto.*
			FROM objetivo_projeto ObjetivoProjeto
			inner join objetivo obj on obj.id = ObjetivoProjeto.objetivo_id			
			WHERE ObjetivoProjeto.objetivo_id is not null
			AND obj.tipo = 2
		");
		
		$this->loadModel('Projeto');
		$this->Projeto->recursive = 0;
		$acoesEstrategicas = array();
		$projetos = array();
		
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$acaoestrategicas[] = $p[0];
				$projetos[$p[0]['objetivo_id']] = $this->Projeto->find('all', array(
									    'joins' => array(
									        array('table' => 'objetivo_projeto',
									            'alias' => 'ObjetivoProjeto',
									            'type' => 'INNER',
									            'conditions' => array(
									                'Projeto.id = ObjetivoProjeto.projeto_id'
									            )
									        )
									    ),
								'conditions'=>array('ObjetivoProjeto.objetivo_id'=>$p[0]['objetivo_id'])) 
					);
			}
		}
				
		
		$this->set('acaoEstrategica', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('acoesEstrategicas', $acoesEstrategicas);
		$this->set('situacao', $situacao);
			
	}
	
	/**
	 * painel de acoes method
	 *
	 * @return void
	 */
	public function painel_acoes() {
		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['AcaoEstrategica'])){
				$count = count($_SESSION['Search']['AcaoEstrategica']);
				$_SESSION['Search']['AcaoEstrategica'][$count]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
           		$_SESSION['Search']['AcaoEstrategica'][$count]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}else{
				$_SESSION['Search']['AcaoEstrategica'][0]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
            	$_SESSION['Search']['AcaoEstrategica'][0]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}
        }
		
		
		
		$situacao_busca = array('não informado' => Util::NAO_INFORMADO,'adequado'  => Util::ADEQUADO,'atenção'  => Util::ATENCAO,'preocupante'  => Util::PREOCUPANTE,'concluído' => Util::CONCLUIDO);
		
		//Lemos a sessão se não estiver vazia para aplicar os filtros
		if(isset($_SESSION['Search']['AcaoEstrategica'])){
			foreach($_SESSION['Search']['AcaoEstrategica'] as $termo_busca){
				if($termo_busca['buscar_em'] == "AcaoEstrategica.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "AcaoEstrategica.data_ultima_atualizacao"){
						$buscar_em = 'AcaoEstrategica.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "AcaoEstrategica.situacao"){
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($situacao_busca[strtolower($termo_busca['busca'])]).'%';
						}
						else {
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($termo_busca['busca']).'%';
						}
					}
				}				
				
				
				$this->paginate['conditions'][] = array($buscar_em => $busca);
			}
		}
		$this->AcaoEstrategica->recursive = 0;
		
		
		
		if ($this->usuarioLogado["Grupo"]["titulo"] == "Ponto Focal") {
			$this->paginate['conditions'][] = array('AcaoEstrategica.titulo ILIKE' => ''.$this->usuarioLogado["Departamento"]["titulo"].'__ -%');
		}
		
		$this->paginate['conditions'][] = array('AcaoEstrategica.tipo' => 2,'AcaoEstrategica.status !=' => Util::INATIVO );
		
		$this->paginate['order'] = array('AcaoEstrategica.data_ultima_atualizacao' => 'asc');
		
		
		$this->paginate['maxLimit'] = 150;
		$this->paginate['limit'] = 150;
		
		$this->loadModel('ObjetivoProjeto');
		$objetivoProjeto = $this->ObjetivoProjeto->query("
			SELECT ObjetivoProjeto.*
			FROM objetivo_projeto ObjetivoProjeto
			inner join objetivo obj on obj.id = ObjetivoProjeto.objetivo_id			
			WHERE ObjetivoProjeto.objetivo_id is not null
			AND obj.tipo = 2
		");
		
		$this->loadModel('Projeto');
		$this->Projeto->recursive = 0;
		$acaoestrategicas = array();
		$projetos = array();
		
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$acaoestrategicas[] = $p[0];
				$projetos[$p[0]['objetivo_id']] = $this->Projeto->find('all', array(
									    'joins' => array(
									        array('table' => 'objetivo_projeto',
									            'alias' => 'ObjetivoProjeto',
									            'type' => 'INNER',
									            'conditions' => array(
									                'Projeto.id = ObjetivoProjeto.projeto_id'
									            )
									        )
									    ),
								'conditions'=>array('ObjetivoProjeto.objetivo_id'=>$p[0]['objetivo_id'])) 
					);
			}
		}
				
		
		$this->set('acaoestrategica', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('acaoestrategicas', $acaoestrategicas);
		$this->set('situacao', $situacao);
		$status_acaoestrategica = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$this->set('status_acaoestrategica', $status_acaoestrategica);
			
	}
	/**
	 * indice revisao method
	 *
	 * @return void
	 */	
	public function indice_revisao() {
		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['AcaoEstrategica'])){
				$count = count($_SESSION['Search']['AcaoEstrategica']);
				$_SESSION['Search']['AcaoEstrategica'][$count]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
           		$_SESSION['Search']['AcaoEstrategica'][$count]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}else{
				$_SESSION['Search']['AcaoEstrategica'][0]['busca'] = $this->request->data['AcaoEstrategica']['busca']; 
            	$_SESSION['Search']['AcaoEstrategica'][0]['buscar_em'] = $this->request->data['AcaoEstrategica']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vazia para aplicar os filtros
		if(isset($_SESSION['Search']['AcaoEstrategica'])){
			foreach($_SESSION['Search']['AcaoEstrategica'] as $termo_busca){
				if($termo_busca['buscar_em'] == "AcaoEstrategica.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "AcaoEstrategica.data_ultima_atualizacao"){
						$buscar_em = 'AcaoEstrategica.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "AcaoEstrategica.situacao"){
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($situacao_busca[strtolower($termo_busca['busca'])]).'%';
						}
						else {
							$buscar_em = $termo_busca['buscar_em']." ILIKE";
							$busca = '%'.addslashes($termo_busca['busca']).'%';
						}
					}
				}				
				
				
				$this->paginate['conditions'][] = array($buscar_em => $busca);
			}
		}
		$this->AcaoEstrategica->recursive = 0;
		
		$this->paginate['conditions'][] = array('AcaoEstrategica.tipo' => 2,'AcaoEstrategica.status !=' => Util::INATIVO );
		$this->paginate['order'] = array('AcaoEstrategica.titulo' => 'asc');
		
		$this->paginate['maxLimit'] = 150;
		$this->paginate['limit'] = 150;
		
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		
		$this->loadModel('ObjetivoProjeto');
		$objetivoProjeto = $this->ObjetivoProjeto->query("
			SELECT ObjetivoProjeto.*
			FROM objetivo_projeto ObjetivoProjeto
			inner join objetivo obj on obj.id = ObjetivoProjeto.objetivo_id
			WHERE ObjetivoProjeto.objetivo_id is not null
			AND obj.tipo = 2
		");
		
		$this->loadModel('Projeto');
		$this->Projeto->recursive = 0;
		$acaoestrategicas = array();
		$projetos = array();
		

		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$acaoestrategicas[] = $p[0];
				$projetos[$p[0]['objetivo_id']] = $this->Projeto->find('all', array(
									    'joins' => array(
									        array('table' => 'objetivo_projeto',
									            'alias' => 'ObjetivoProjeto',
									            'type' => 'INNER',
									            'conditions' => array(
									                'Projeto.id = ObjetivoProjeto.projeto_id'
									            )
									        )
									    ),
								'conditions'=>array('ObjetivoProjeto.objetivo_id'=>$p[0]['objetivo_id'])) 
					);
			}
		}
				
		
		$this->set('acaoestrategica', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('acaoestrategicas', $acaoestrategicas);
		$this->set('situacao', $situacao);
			
	}
	
	/**
	 * excluirFiltro method
	 *
	 * @throws NotFoundException
	 * @param int $filtro
	 * @return void
	 */
	public function excluirFiltro($filtro, $redirect = 'index'){
		$this->autoRender = false;
		
		unset($_SESSION['Search']['AcaoEstrategica'][$filtro]);
		$this->redirect(array('action' => $redirect));	
	}
	
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {

		$this->AcaoEstrategica->id = $id;
		if (!$this->AcaoEstrategica->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->AcaoEstrategica->recursive = 2;
		$this->set('acaoEstrategica', $this->AcaoEstrategica->read(null, $id));
		
		
		//Exibir Projetos
		$this->loadModel('ObjetivoProjeto');
		$objetivoProjeto = $this->ObjetivoProjeto->query("
			SELECT ObjetivoProjeto.*
			FROM objetivo_projeto ObjetivoProjeto
			inner join objetivo obj on obj.id = ObjetivoProjeto.objetivo_id
			WHERE ObjetivoProjeto.objetivo_id is not null
			AND obj.tipo = 2
		");
		
		$this->loadModel('Projeto');
		$this->Projeto->recursive = 0;
		$acoesEstrategicas = array();
		$projetos = array();
		

		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$acoesEstrategicas[] = $p[0];
				$projetos[$p[0]['objetivo_id']] = $this->Projeto->find('all', array(
									    'joins' => array(
									        array('table' => 'objetivo_projeto',
									            'alias' => 'ObjetivoProjeto',
									            'type' => 'INNER',
									            'conditions' => array(
									                'Projeto.id = ObjetivoProjeto.projeto_id'
									            )
									        )
									    ),
								'conditions'=>array('ObjetivoProjeto.objetivo_id'=>$p[0]['objetivo_id'])) 
					);
			}
		}
		
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);		
		

	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {
				
		
		if ($this->request->is('post')) {
			$this->request->data["AcaoEstrategica"]["tipo"]=2;
			$this->AcaoEstrategica->create();
			if ($this->AcaoEstrategica->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "AcaoEstrategica", array(), "adicionar", true, $this->AcaoEstrategica->id, $this->Auth->user("id"));
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
		
		$acoesEstrategicas = $this->AcaoEstrategica->find('list', array('conditions' => array('AcaoEstrategica.status' => Util::ATIVO, 'AcaoEstrategica.tipo' => Util::TIPO_PADRAO), 'fields' => array('AcaoEstrategica.id', 'AcaoEstrategica.titulo')));
		$status_acaoEstrategica = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
		
		//Responsável
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		//Pessoas para preencher o responsável
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$pessoas = array();
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
				
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('acoesEstrategicas', $acoesEstrategicas);
		$this->set('status_acaoestrategica', $status_acaoEstrategica);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		//Responsável
		$this->set('usuarios', $usuarios);
		$this->set('pessoas', $pessoas);
	
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	 /*
	public function editar2($id = null) {
		
		$this->AcaoEstrategica->id = $id;
		if (!$this->AcaoEstrategica->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->AcaoEstrategica->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "AcaoEstrategica", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
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
		
		$acaoestrategicas = $this->AcaoEstrategica->find('list', array('conditions' => array('AcaoEstrategica.status' => Util::ATIVO, 'AcaoEstrategica.tipo' => Util::TIPO_PADRAO, 'AcaoEstrategica.id !=' => $id), 'fields' => array('AcaoEstrategica.id', 'AcaoEstrategica.titulo')));
		$status_acaoestrategica = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
			
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('acaoestrategicas', $acaoestrategicas);
		$this->set('status_acaoestrategica', $status_acaoestrategica);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		
		$this->request->data = $this->AcaoEstrategica->read(null, $id);
		
	}
	*/
	
	public function editar($id = null) {
		
		$this->AcaoEstrategica->id = $id;
		if (!$this->AcaoEstrategica->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->AcaoEstrategica->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "AcaoEstrategica", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
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
		
		$acoesEstrategicas = $this->AcaoEstrategica->find('list', array('conditions' => array('AcaoEstrategica.status' => Util::ATIVO, 'AcaoEstrategica.tipo' => Util::TIPO_PADRAO, 'AcaoEstrategica.id !=' => $id), 'fields' => array('AcaoEstrategica.id', 'AcaoEstrategica.titulo')));
		$status_acaoestrategica = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
		
		$editado_em = $this->AcaoEstrategica->query("
			select auditoria.*, pessoa.titulo, pessoa.email from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			where alias_controller = 'AcaoEstrategica' and alias_acao = 'editar' and elemento_id = '".$this->AcaoEstrategica->id."' 
			order by auditoria.created desc 
			limit 1;		
		");
		
		$editado = array();
		
		foreach($editado_em as $vetorEditado){
			$editado[]= $vetorEditado[0];
		}
		
		$this->set('editado_em', $editado);
		
		
		//Responsável
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		//Pessoas para preencher o responsável
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$pessoas = array();
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
				
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('acoesEstrategicas', $acoesEstrategicas);
		$this->set('status_acaoestrategica', $status_acaoestrategica);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		//Responsável
		$this->set('usuarios', $usuarios);
		$this->set('pessoas', $pessoas);
		
		
		$this->request->data = $this->AcaoEstrategica->read(null, $id);
		
	}
	/**
	 * revisar method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */	
	public function revisar($id = null) {
		
		$this->AcaoEstrategica->id = $id;
		if (!$this->AcaoEstrategica->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->AcaoEstrategica->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "AcaoEstrategica", array(), "revisar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'indice_revisao'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
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
		
		$acaoestrategicas = $this->AcaoEstrategica->find('list', array('conditions' => array('AcaoEstrategica.status' => Util::ATIVO, 'AcaoEstrategica.tipo' => Util::TIPO_PADRAO, 'AcaoEstrategica.id !=' => $id), 'fields' => array('AcaoEstrategica.id', 'AcaoEstrategica.titulo')));
		$status_acaoestrategica = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
		
		//Responsável
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		//Pessoas para preencher o responsável
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$pessoas = array();
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
		
		
		//Log de Edição
		$editado_em = $this->AcaoEstrategica->query("
			select auditoria.*, pessoa.titulo, pessoa.email, auditoria_campos.valor_novo from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			inner join auditoria_campos on auditoria.id = auditoria_id
			where alias_controller = 'AcaoEstrategica' and (alias_acao = 'editar' or alias_acao = 'adicionar' ) and elemento_id = '".$this->AcaoEstrategica->id."' 
			order by auditoria.created desc 
			;		
		");
		
		$editado = array();
		foreach($editado_em as $vetorEditado){
			$editado[]= $vetorEditado[0];
		}
		$this->set('editado_em', $editado);
		
		//Log de revisão
		$revisado_em = $this->AcaoEstrategica->query("
			select auditoria.*, pessoa.titulo, pessoa.email, auditoria_campos.valor_novo from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			inner join auditoria_campos on auditoria.id = auditoria_id
			where alias_controller = 'AcaoEstrategica' and alias_acao = 'revisar' and elemento_id = '".$this->AcaoEstrategica->id."' 
			order by auditoria.created desc 
			;		
		");
		
		$revisado = array();
		foreach($revisado_em as $vetorRevisado){
			$revisado[]= $vetorRevisado[0];
		}
		$this->set('revisado_em', $revisado);
		
		
		//Pessoas para preencher o responsável
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$pessoas = array();
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('acaoestrategicas', $acaoestrategicas);
		$this->set('status_acaoestrategica', $status_acaoestrategica);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		//Responsável
		$this->set('usuarios', $usuarios);
		$this->set('pessoas', $pessoas);
		
		$this->request->data = $this->AcaoEstrategica->read(null, $id);
				
		$this->AcaoEstrategica->recursive = 2;
		$this->set('acaoestrategica', $this->AcaoEstrategica->read(null, $id));
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
		$this->AcaoEstrategica->id = $id;
		if (!$this->AcaoEstrategica->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->AcaoEstrategica->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "AcaoEstrategica", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));

	}
}
