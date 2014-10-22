<?php
App::uses('AppController', 'Controller');
/**
 * Medida Controller
 *
 * @property Medida $Medida
 * @property SessionComponent $Session
 */
class MedidaController extends AppController {
	
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
			if(isset($_SESSION['Search']['Medida'])){
				$count = count($_SESSION['Search']['Medida']);
				$_SESSION['Search']['Medida'][$count]['busca'] = $this->request->data['Medida']['busca']; 
           		$_SESSION['Search']['Medida'][$count]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}else{
				$_SESSION['Search']['Medida'][0]['busca'] = $this->request->data['Medida']['busca']; 
            	$_SESSION['Search']['Medida'][0]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}
        }
		
		
		$situacao_busca = array('não informado' => Util::NAO_INFORMADO,'adequado'  => Util::ADEQUADO,'atenção'  => Util::ATENCAO,'preocupante'  => Util::PREOCUPANTE,'concluído' => Util::CONCLUIDO);
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Medida'])){
			foreach($_SESSION['Search']['Medida'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Medida.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "Medida.data_ultima_atualizacao"){
						$buscar_em = 'Medida.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "Medida.situacao"){
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
		$this->Medida->recursive = 0;
		
		
		
		if ($this->usuarioLogado["Grupo"]["titulo"] == "Ponto Focal") {
			$this->paginate['conditions'][] = array('Medida.titulo ILIKE' => ''.$this->usuarioLogado["Departamento"]["titulo"].'__ -%');
		}
		
		$this->paginate['conditions'][] = array('Medida.tipo' => 2,'Medida.status !=' => Util::INATIVO );
		
		$this->paginate['order'] = array('Medida.titulo' => 'asc');
		
		
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
		$medidas = array();
		$projetos = array();
		
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$medidas[] = $p[0];
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
				
		
		$this->set('medida', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('medidas', $medidas);
		$this->set('situacao', $situacao);
			
	}
	
	public function painel_acoes() {
		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['Medida'])){
				$count = count($_SESSION['Search']['Medida']);
				$_SESSION['Search']['Medida'][$count]['busca'] = $this->request->data['Medida']['busca']; 
           		$_SESSION['Search']['Medida'][$count]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}else{
				$_SESSION['Search']['Medida'][0]['busca'] = $this->request->data['Medida']['busca']; 
            	$_SESSION['Search']['Medida'][0]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}
        }
		
		
		
		$situacao_busca = array('não informado' => Util::NAO_INFORMADO,'adequado'  => Util::ADEQUADO,'atenção'  => Util::ATENCAO,'preocupante'  => Util::PREOCUPANTE,'concluído' => Util::CONCLUIDO);
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Medida'])){
			foreach($_SESSION['Search']['Medida'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Medida.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "Medida.data_ultima_atualizacao"){
						$buscar_em = 'Medida.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "Medida.situacao"){
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
		$this->Medida->recursive = 0;
		
		
		
		if ($this->usuarioLogado["Grupo"]["titulo"] == "Ponto Focal") {
			$this->paginate['conditions'][] = array('Medida.titulo ILIKE' => ''.$this->usuarioLogado["Departamento"]["titulo"].'__ -%');
		}
		
		$this->paginate['conditions'][] = array('Medida.tipo' => 2,'Medida.status !=' => Util::INATIVO );
		
		$this->paginate['order'] = array('Medida.data_ultima_atualizacao' => 'asc');
		
		
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
		$medidas = array();
		$projetos = array();
		
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$medidas[] = $p[0];
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
				
		
		$this->set('medida', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('medidas', $medidas);
		$this->set('situacao', $situacao);
		$status_medida = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$this->set('status_medida', $status_medida);
			
	}
	
	public function indice_revisao() {
		
		if(!empty($this->request->data)) {			
			if(isset($_SESSION['Search']['Medida'])){
				$count = count($_SESSION['Search']['Medida']);
				$_SESSION['Search']['Medida'][$count]['busca'] = $this->request->data['Medida']['busca']; 
           		$_SESSION['Search']['Medida'][$count]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}else{
				$_SESSION['Search']['Medida'][0]['busca'] = $this->request->data['Medida']['busca']; 
            	$_SESSION['Search']['Medida'][0]['buscar_em'] = $this->request->data['Medida']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		if(isset($_SESSION['Search']['Medida'])){
			foreach($_SESSION['Search']['Medida'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Medida.ano"){
					$buscar_em = $termo_busca['buscar_em']." =";
					$busca = addslashes($termo_busca['busca']);
				}else{
					if($termo_busca['buscar_em'] == "Medida.data_ultima_atualizacao"){
						$buscar_em = 'Medida.data_ultima_atualizacao'." =";
						$busca = addslashes(Util::inverteData($termo_busca['busca']));
					}
					else {
						if($termo_busca['buscar_em'] == "Medida.situacao"){
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
		$this->Medida->recursive = 0;
		
		$this->paginate['conditions'][] = array('Medida.tipo' => 2,'Medida.status !=' => Util::INATIVO );
		$this->paginate['order'] = array('Medida.titulo' => 'asc');
		
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
		$medidas = array();
		$projetos = array();
		

		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$medidas[] = $p[0];
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
				
		
		$this->set('medida', $this->paginate());
		$this->set('projetos', $projetos);
		$this->set('objetivoProjeto', $objetivoProjeto);
		$this->set('medidas', $medidas);
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
		
		unset($_SESSION['Search']['Medida'][$filtro]);
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

		$this->Medida->id = $id;
		if (!$this->Medida->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Medida->recursive = 2;
		$this->set('medida', $this->Medida->read(null, $id));
		
		
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
		$medidas = array();
		$projetos = array();
		

		
		foreach($objetivoProjeto as $p){
			if($p[0]['objetivo_id'] != "" || $p[0]['objetivo_id'] != null ){
				$medidas[] = $p[0];
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
			$this->Medida->create();
			if ($this->Medida->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Medida", array(), "adicionar", true, $this->Medida->id, $this->Auth->user("id"));
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
		
		$medidas = $this->Medida->find('list', array('conditions' => array('Medida.status' => Util::ATIVO, 'Medida.tipo' => Util::TIPO_PADRAO), 'fields' => array('Medida.id', 'Medida.titulo')));
		$status_medida = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
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
		$this->set('medidas', $medidas);
		$this->set('status_medida', $status_medida);
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
		
		$this->Medida->id = $id;
		if (!$this->Medida->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Medida->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Medida", array(), "editar", false, $id, $this->Auth->user("id"));
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
		
		$medidas = $this->Medida->find('list', array('conditions' => array('Medida.status' => Util::ATIVO, 'Medida.tipo' => Util::TIPO_PADRAO, 'Medida.id !=' => $id), 'fields' => array('Medida.id', 'Medida.titulo')));
		$status_medida = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
			
		
		$this->set('ordem', $ordem);
		$this->set('dimensoes', $dimensoes);
		$this->set('medidas', $medidas);
		$this->set('status_medida', $status_medida);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		
		$this->request->data = $this->Medida->read(null, $id);
		
	}
	*/
	
	public function editar($id = null) {
		
		$this->Medida->id = $id;
		if (!$this->Medida->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Medida->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Medida", array(), "editar", false, $id, $this->Auth->user("id"));
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
		
		$medidas = $this->Medida->find('list', array('conditions' => array('Medida.status' => Util::ATIVO, 'Medida.tipo' => Util::TIPO_PADRAO, 'Medida.id !=' => $id), 'fields' => array('Medida.id', 'Medida.titulo')));
		$status_medida = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
		$situacao = array(Util::NAO_INFORMADO => 'Não Informado', Util::ADEQUADO => 'Adequado', Util::ATENCAO => 'Atenção', Util::PREOCUPANTE => 'Preocupante', Util::CONCLUIDO => 'Concluído');
		$prioridades = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F');
		$andamento = array('0%' => '0%', '5%' => '5%', '10%' => '10%', '15%' => '15%','20%' => '20%','25%' => '25%', '30%' => '30%','35%' => '35%', '40%' => '40%','45%' => '45%', '50%' => '50%','55%' => '55%', '60%' => '60%','65%' => '65%', '70%' => '70%','75%' => '75%', '80%' => '80%','85%' => '85%', '90%' => '90%','95%' => '95%', '100%' => '100%');
		
		$editado_em = $this->Medida->query("
			select auditoria.*, pessoa.titulo, pessoa.email from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			where alias_controller = 'Medida' and alias_acao = 'editar' and elemento_id = '".$this->Medida->id."' 
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
		$this->set('medidas', $medidas);
		$this->set('status_medida', $status_medida);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		//Responsável
		$this->set('usuarios', $usuarios);
		$this->set('pessoas', $pessoas);
		
		
		$this->request->data = $this->Medida->read(null, $id);
		
	}
	
	public function revisar($id = null) {
		
		$this->Medida->id = $id;
		if (!$this->Medida->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Medida->save($this->request->data)) {
				$this->Audit->salvar($this->request->data, "Medida", array(), "revisar", false, $id, $this->Auth->user("id"));
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
		
		$medidas = $this->Medida->find('list', array('conditions' => array('Medida.status' => Util::ATIVO, 'Medida.tipo' => Util::TIPO_PADRAO, 'Medida.id !=' => $id), 'fields' => array('Medida.id', 'Medida.titulo')));
		$status_medida = array(Util::NAO_INICIADO => 'Não Iniciada', Util::EM_ANDAMENTO => 'Em Andamento', Util::AGUARDANDO_OUTRA_PESSOA => 'Bloqueada', Util::CONCLUIDO => 'Concluida', Util::CANCELADO => 'Cancelada');
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
		$editado_em = $this->Medida->query("
			select auditoria.*, pessoa.titulo, pessoa.email, auditoria_campos.valor_novo from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			inner join auditoria_campos on auditoria.id = auditoria_id
			where alias_controller = 'Medida' and (alias_acao = 'editar' or alias_acao = 'adicionar' ) and elemento_id = '".$this->Medida->id."' 
			order by auditoria.created desc 
			limit 1;		
		");
		
		$editado = array();
		foreach($editado_em as $vetorEditado){
			$editado[]= $vetorEditado[0];
		}
		$this->set('editado_em', $editado);
		
		//Log de revisão
		$revisado_em = $this->Medida->query("
			select auditoria.*, pessoa.titulo, pessoa.email, auditoria_campos.valor_novo from auditoria 
			inner join usuario on usuario_id = usuario.id 
			inner join pessoa on pessoa_id = pessoa.id 
			inner join auditoria_campos on auditoria.id = auditoria_id
			where alias_controller = 'Medida' and alias_acao = 'revisar' and elemento_id = '".$this->Medida->id."' 
			order by auditoria.created desc 
			limit 1;		
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
		$this->set('medidas', $medidas);
		$this->set('status_medida', $status_medida);
		$this->set('prioridades', $prioridades);
		$this->set('andamento', $andamento);
		$this->set('situacao', $situacao);
		
		//Responsável
		$this->set('usuarios', $usuarios);
		$this->set('pessoas', $pessoas);
		
		$this->request->data = $this->Medida->read(null, $id);
				
		$this->Medida->recursive = 2;
		$this->set('medida', $this->Medida->read(null, $id));
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
		$this->Medida->id = $id;
		if (!$this->Medida->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Medida->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Medida", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));

	}
}
