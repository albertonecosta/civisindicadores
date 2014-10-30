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
 * Projeto Controller
 *
 * @property Projeto $Projeto
 * @property SessionComponent $Session
 */
class ProjetoController extends AppController {

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
		
		//Verificamos se o Array de dados de busca vem com dados para adicionarmos na sessão		
		if(!empty($this->request->data)) {	

			if(isset($_SESSION['Search']['Projeto'])){
				$count = count($_SESSION['Search']['Projeto']);
				$_SESSION['Search']['Projeto'][$count]['busca'] = $this->request->data['Projeto']['busca']; 
           		$_SESSION['Search']['Projeto'][$count]['buscar_em'] = $this->request->data['Projeto']['buscar_em']; 
			}else{
				$_SESSION['Search']['Projeto'][0]['busca'] = $this->request->data['Projeto']['busca']; 
            	$_SESSION['Search']['Projeto'][0]['buscar_em'] = $this->request->data['Projeto']['buscar_em']; 
			}
        }
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
        $busca = array();
		if(isset($_SESSION['Search']['Projeto'])){
			foreach($_SESSION['Search']['Projeto'] as $termo_busca){
				if($termo_busca['buscar_em'] == "Projeto.data_inicio_previsto"){
					$busca[] = "AND to_char({$termo_busca['buscar_em']}, 'DD/MM/YYYY') ILIKE '%".addslashes($termo_busca['busca'])."%'";
				}else{
					$busca[] = "AND {$termo_busca['buscar_em']} ILIKE '%".addslashes($termo_busca['busca'])."%'";
				}
			}
		}
		$busca = implode(" ", $busca);
		$pagina = (empty($_GET['pagina'])) ? 1 : $_GET['pagina'];
		$offset = $this->offset($pagina);
		
		$projeto = $this->Projeto->query("
			SELECT Projeto.*, Pessoa.titulo as nome, Setor.titulo as setor, Departamento.titulo as departamento 
			FROM projeto Projeto 
			INNER JOIN usuario Usuario ON Usuario.id = Projeto.usuario_id 
			INNER JOIN pessoa Pessoa ON Pessoa.id = Usuario.pessoa_id 
			LEFT JOIN setor Setor ON Usuario.setor_id = Setor.id 
			LEFT JOIN departamento Departamento ON Departamento.id = Usuario.departamento_id 
			WHERE Projeto.status = ".Util::ATIVO." {$busca}
			ORDER BY Projeto.data_fim_previsto asc LIMIT ". self::PERPAGE ." OFFSET $offset
		");
		
		$total = $this->Projeto->query("
				SELECT count(*) as total
				FROM projeto Projeto
				INNER JOIN usuario Usuario ON Usuario.id = Projeto.usuario_id
				INNER JOIN pessoa Pessoa ON Pessoa.id = Usuario.pessoa_id
				LEFT JOIN setor Setor ON Usuario.setor_id = Setor.id
				LEFT JOIN departamento Departamento ON Departamento.id = Usuario.departamento_id
				WHERE Projeto.status = ".Util::ATIVO." {$busca}");
		$total = $total[0][0]["total"];
		
		$this->loadModel('Acao');
		$this->Acao->recursive = 0;
		$projetos = array();
		$acoes = array();
		foreach($projeto as $p){
			$projetos[] = $p[0];
			$acoes[$p[0]['id']] = $this->Acao->find('all', array('conditions'=>array('Acao.projeto_id'=>$p[0]['id']),'order' => array('Acao.data_inicio_previsto','Acao.marco','Acao.titulo')));
		}
		
		$this->paginacao($projetos, $total, $pagina);
		$this->set('projetos', $projetos);
		$this->set('acoes', $acoes);
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
		unset($_SESSION['Search']['Projeto'][$filtro]);
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
		$this->Projeto->id = $id;
		
		
		if (!$this->Projeto->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$projeto = $this->Projeto->read(null, $id);
		
		/*
		 * Algoritimo para pegar os dados das ações
		 */
		$projeto = array($projeto);
		
		$this->loadModel('Usuario');
		foreach ($projeto as $key => $value) {
		
			$pessoas = array();
			foreach ($value['Acao'] as $key2 => $value2) {
				$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $value2['responsavel_id'])));
				$pessoas[$key2]['id'] = $usuario['Usuario']['id'];
				$pessoas[$key2]['titulo'] = $usuario['Pessoa']['titulo'];
				$pessoas[$key2]['email'] = $usuario['Pessoa']['email'];
				$projeto[$key]['Acao'][$key2]['Responsavel'] = $pessoas;
			}
			
		}
			
		$this->set('projeto', $projeto);
	}
	
	/**
	 * visulizar method
	 *
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function visualizar($id = null) {
		
		$this->Projeto->id = $id;
		if (!$this->Projeto->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->Projeto->recursive = 2;
		$this->set('projeto', $this->Projeto->read(null, $id));
		
		$array = $this->Projeto->data["ObjetivoProjeto"];
		$objetivos= array();
		foreach($array as $campos){
			$objetivos[$campos['Objetivo']['id']] = $campos['Objetivo']['titulo'];
		}
		
		$this->set('objetivos',$objetivos);
		
		$array2 = $this->Projeto->data["PatrocinadorProjeto"];
		$patrocinadores= array();
		foreach($array2 as $campos){
			$patrocinadores[] = $campos['Pessoa']['titulo'];
		}
		
		$this->set('patrocinadores',$patrocinadores);
		
		$this->loadModel('Acao');
		$acoes = $this->Acao->query("SELECT Acao.*, Pessoa.titulo as nome
			FROM acao Acao 
			INNER JOIN usuario Usuario ON Usuario.id = Acao.responsavel_id 
			INNER JOIN pessoa Pessoa ON Pessoa.id = Usuario.pessoa_id 
			WHERE Acao.status<>0 and Acao.projeto_id = {$id} and Acao.acao_id is NULL
			ORDER BY Acao.data_inicio_previsto asc, Acao.marco,Acao.titulo");
		$x=0;
		foreach($acoes as $novas){
			$x++;
			$acoes1[$x] = $novas[0];
			$filhos = $this->Acao->query("SELECT Acao.*, Pessoa.titulo as nome
			FROM acao Acao 
			INNER JOIN usuario Usuario ON Usuario.id = Acao.responsavel_id 
			INNER JOIN pessoa Pessoa ON Pessoa.id = Usuario.pessoa_id 
			WHERE Acao.status<>0 and Acao.acao_id = ".$novas[0]["id"]."
			ORDER BY Acao.data_inicio_previsto asc, Acao.marco,Acao.titulo");
			
			foreach($filhos as $novosFilhos){
				$acoes1[$x]["Filhos"][]=$novosFilhos[0];
			}
		}
		Configure::write('debug', 0);
		
			$this->loadModel("Usuario");

			$this->Usuario->recursive = 2;
			$usuario = $this->Usuario->find("first", array("conditions" => array('Usuario.id' => 25)));

			if(isset($this->request->data['data_atual']) && $this->request->data['data_atual'] == "atual"){
				$data = date("Y");
			}else{
				$data = $this->request->data['data_selecionada'];
			}			
			$this->loadModel("Indicador");
			$this->Indicador->recursive = 1;
			$indicadores = $this->Indicador->find("all", array('conditions' => array('Indicador.status' => Util::ATIVO,'Indicador.projeto_id'=>$id), 'order' => array('Indicador.ordem ASC')));
		
			
			//Algoritimo para buscar pelos indicadores do ano selecionado pelo usuario e fazer seus calculos de meta e realizado
			$indicadoresFiltrados = array();
			//Atualmente trazendo apenas indicador do ano atual
			$_SESSION['ano_selecionado_indicadores'] = date("Y");
			$anoSelecionado = $_SESSION['ano_selecionado_indicadores'];
			foreach ($indicadores as $indicador) {
				$filhos = $this->Indicador->find("all", array('conditions' => array('Indicador.indicador_id' => $indicador['Indicador']['id']), 'order' => array('Indicador.ordem ASC')));
						$indicador['TotalIndicador'] = Util::getTotalIndicador($indicador, $filhos);
						$indicador['TotalAnomalias'] = Util::getTotalAnomalias($indicador);
						$indicadoresFiltrados[] = $indicador;


			}
			//Fim de algoritimo para pegar indicadores pelo ano
			
			//Pegamos apenas os indicadores que o usuário é responsavel			
			foreach ($indicadoresFiltrados as $key => $value) {
				
				$achou = false;
				$indice = "";
				foreach ($usuario['IndicadorResponsavel'] as $key2 => $value2) {
					if($value['Indicador']['id'] == $value2['id']){
						$achou = true;
						break;
					}
				}
				if($achou == false){
					unset($indicadoresFiltrados[$key]);
				}
			}

			$anomalias = array();
			foreach($indicadoresFiltrados as $key => $value){
				if(count($value['Anomalia']) > 0){
					$anomalias[] = $value['Anomalia'];
				}
			}
			
			
		$this->set("indicadores", $indicadoresFiltrados);
		$this->set('acoes', $acoes1);
			
	}

	/**
	 * adicionar method
	 *
	 * @return void
	 */
	public function adicionar() {
		
		if ($this->request->is('post')) {
			$this->Projeto->create();
			if ($this->Projeto->save($this->request->data)) {
				$this->loadModel("ObjetivoProjeto");
				foreach($this->request->data['Projeto']['objetivos'] as $objetivos){					
					$this->request->data['ObjetivoProjeto']['projeto_id'] = $this->Projeto->id;
					$this->request->data['ObjetivoProjeto']['objetivo_id'] = $objetivos;
					$this->ObjetivoProjeto->save($this->request->data);
					$this->ObjetivoProjeto->id = null;					
				}
				
				$this->loadModel("PatrocinadorProjeto");
				foreach($this->request->data['Projeto']['patrocinadores'] as $patrocinadores){
					$this->request->data['PatrocinadorProjeto']['projeto_id'] = $this->Projeto->id;
					$this->request->data['PatrocinadorProjeto']['pessoa_id'] = $patrocinadores;
					$this->PatrocinadorProjeto->save($this->request->data);
					$this->PatrocinadorProjeto->id = null;
				}
				
				$this->Audit->salvar($this->request->data, "Projeto", array(), "adicionar", true, $this->Projeto->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status !=' => Util::INATIVO,'Objetivo.tipo' => 2), 'fields' => array('Objetivo.id', 'Objetivo.titulo'),'order' => array('Objetivo.titulo')));
		$this->loadModel('Programa');
		$programas = $this->Programa->find('list', array('conditions' => array('Programa.status' => Util::ATIVO), 'fields' => array('Programa.id', 'Programa.titulo'),'order' => array('Programa.titulo')));
		$this->set('programas', $programas);
		//Pessoas para preencher o responsável
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$pessoas = array();
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
		
		$this->set('usuarios', $usuarios);
		$this->set('objetivos', $objetivos);
		$this->set('programas', $programas);
		$this->set('pessoas', $pessoas);
		
		//Campos Novos de Projeto (Gestão de Portfólio)
		
		$tamanho = array('P' => 'Pequeno', 'M' => 'Médio', 'G' => 'Grande');
		$perspectiva_temporal = array('Curto Prazo' => 'Curto Prazo (até 3 meses)', 'Médio Prazo' => 'Médio Prazo (até 1 ano)', 'Longo Prazo' => 'Longo Prazo (mais que 1 ano)');
		$complexidade = array('Baixa' => 'Baixa', 'Média' => 'Média', 'Alta' => 'Alta');
		$importancia_politica = array('Baixa' => 'Baixa', 'Média' => 'Média', 'Alta' => 'Alta');
		$saude_projeto = array('0' => 'Adequada', '1' => 'Atenção', '2' => 'Inadequada');
		$situacao = array('0' => 'A Iniciar', '1' => 'Em Andamento', '2' => 'Bloqueado','3' => 'Suspenso','4' => 'Cancelado');
		
		
		$this->set('tamanho',$tamanho);
		$this->set('perspectiva_temporal',$perspectiva_temporal);
		$this->set('complexidade',$complexidade);
		$this->set('importancia_politica',$importancia_politica);
		$this->set('saude_projeto',$saude_projeto);
		$this->set('situacao',$situacao);
		
	}

	/**
	 * editar method
	 *
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function editar($id = null) {
		
		$this->Projeto->id = $id;
		$this->Projeto->read();
		$objetivoProjeto = $this->Projeto->data['ObjetivoProjeto'];
		$patrocinadorProjeto = $this->Projeto->data['PatrocinadorProjeto'];
		
		if (!$this->Projeto->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Projeto->save($this->request->data)) {				
				$this->loadModel("ObjetivoProjeto");
				foreach($objetivoProjeto as $objProj){
					$this->ObjetivoProjeto->query("delete from objetivo_projeto where id = {$objProj['id']}");
				}
				
				if($this->request->data['Projeto']['objetivos'] != ""){
					foreach($this->request->data['Projeto']['objetivos'] as $objetivos){
						$this->request->data['ObjetivoProjeto']['projeto_id'] = $this->Projeto->id;
						$this->request->data['ObjetivoProjeto']['objetivo_id'] = $objetivos;
						$this->ObjetivoProjeto->save($this->request->data);
						$this->ObjetivoProjeto->id = null;
					}
				}
					
				$this->loadModel("PatrocinadorProjeto");
				foreach($patrocinadorProjeto as $patrProj){
					$this->PatrocinadorProjeto->query("delete from patrocinador_projeto where id = {$patrProj['id']}");
				}
				
				if($this->request->data['Projeto']['patrocinadores'] != ""){
					foreach($this->request->data['Projeto']['patrocinadores'] as $patrocinadores){
						$this->request->data['PatrocinadorProjeto']['projeto_id'] = $this->Projeto->id;
						$this->request->data['PatrocinadorProjeto']['pessoa_id'] = $patrocinadores;
						$this->PatrocinadorProjeto->save($this->request->data);
						$this->PatrocinadorProjeto->id = null;
					}
				}
				
				
				$this->Audit->salvar($this->request->data, "Projeto", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		$this->loadModel('Programa');
		$this->loadModel('Usuario');
		$this->loadModel('Objetivo');
		
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' =>  array('Objetivo.status !=' => Util::INATIVO,'Objetivo.tipo' => 2), 'fields' => array('Objetivo.id', 'Objetivo.titulo')));

		
		// Carregando os objetivos ativos do projeto
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo'),'order' => array('Objetivo.titulo')));
		$this->request->data = $this->Projeto->read(null, $id);
		
		$array = $this->request->data["ObjetivoProjeto"];
		$selected = array();
		foreach($array as $campos){
			$selected[] = $campos['objetivo_id'];
		}

		
		// Carregando 
		$programas = $this->Programa->find('list', array('conditions' => array('Programa.status' => Util::ATIVO), 'fields' => array('Programa.id', 'Programa.titulo'),'order' => array('Programa.titulo')));
		
		$this->set('programas', $programas);
		
		$this->loadModel('Pessoa');
		$pessoas2 = $this->Pessoa->find('list', array('fields' => array('Pessoa.id', 'Pessoa.titulo'),'order' => array('Pessoa.titulo')));
		
		$pessoas = array();
		//Retirando nomes vazios
		foreach($pessoas2 as $key => $pessoa){
			if(!($pessoa == "") || !empty($pessoa)){
				$pessoas[$key] = $pessoa;
			}
		}
		
		$array2 = $this->request->data["PatrocinadorProjeto"];
		$selected2 = array();
		foreach($array2 as $campos2){
			$selected2[] = $campos2['pessoa_id'];
		}
						
		
		$this->set('usuarios', $usuarios);
		$this->set('objetivos', $objetivos);
		$this->set('selected',$selected);
		$this->set('pessoas',$pessoas);
		$this->set('selected2',$selected2);
		
		//Campos Novos de Projeto (Gestão de Portfólio)
		
		$tamanho = array('P' => 'Pequeno', 'M' => 'Médio', 'G' => 'Grande');
		$perspectiva_temporal = array('Curto Prazo' => 'Curto Prazo (até 3 meses)', 'Médio Prazo' => 'Médio Prazo (até 1 ano)', 'Longo Prazo' => 'Longo Prazo (mais que 1 ano)');
		$complexidade = array('Baixa' => 'Baixa', 'Média' => 'Média', 'Alta' => 'Alta');
		$importancia_politica = array('Baixa' => 'Baixa', 'Média' => 'Média', 'Alta' => 'Alta');
		$saude_projeto = array('0' => 'Adequada', '1' => 'Atenção', '2' => 'Inadequada');
		$situacao = array('0' => 'A Iniciar', '1' => 'Em Andamento', '2' => 'Bloqueado','3' => 'Suspenso','4' => 'Cancelado');
		
		
		$this->set('tamanho',$tamanho);
		$this->set('perspectiva_temporal',$perspectiva_temporal);
		$this->set('complexidade',$complexidade);
		$this->set('importancia_politica',$importancia_politica);
		$this->set('saude_projeto',$saude_projeto);
		$this->set('situacao',$situacao);

	}

	/**
	 * Método responsável por excluir, logicamente, um projeto e todos seus relacionamentos (ações/tarefas/posts)
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param int $id
	 * @return void
	 */
	public function excluir($id = null) {
		
		try{
			
			// iniciando uma transação
			$DS = $this->Projeto->getDataSource();
			$DS->begin();
			
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			$this->Projeto->id = $id;
			if (empty($id) || !is_numeric($id) || !$this->Projeto->exists()) {
				throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
			}
			
			if ($this->Projeto->saveField('status', Util::INATIVO)) {
				
				// Deletando, logicamente, os posts
				$this->Projeto->query("UPDATE post SET status = ".Util::INATIVO." where acao_id in (select id from acao where projeto_id = $id)");
				
				// Deletando, logicamente, as tarefas
				$this->Projeto->query("UPDATE tarefa SET status = ".Util::INATIVO." where acao_id in (select id from acao where projeto_id = $id)");
				
				// Deletando, logicamente, as ações
				$this->Projeto->query("UPDATE acao SET status = ".Util::INATIVO." where projeto_id = $id");
				
				// Salvando na tabela de auditoria (log)
				$this->Audit->salvar("", "Projeto", array(), "excluir", false, $id, $this->Auth->user("id"));
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

	/**
	 * cronograma method
	 *
	 * @throws NotFoundException
	 * @return void
	 */	
	public function cronograma(){
		$this->layout = "ajax";
		$this->loadModel("Acao");
		
		$this->Acao->recursive = 2;
		$acoes = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.projeto_id' => $_GET['projeto_id']), 'order' => array('Acao.data_inicio_previsto ASC')));

		$this->set('acoes', $acoes);
		$this->set('projeto_id', $_GET['projeto_id']);
	}
	
	/**
	 * 
	 */
	public function salvar_datas_cronograma(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->loadModel("Acao");
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$quantidadeRegistros = count($this->request->data['Acao']['id']);
			$arrayRegistrosOrganizados = array();
			$count = 0;
			
			if($this->request->data['Acao']['dias_a_mais'][0] == ""){	
					
				for($i=0;$i<$quantidadeRegistros;$i++){
					$arrayRegistrosOrganizados[$i]['id'] = $this->request->data['Acao']['id'][$count];
					$arrayRegistrosOrganizados[$i]['data_inicio_previsto'] = $this->request->data['Acao']['data_inicio_previsto'][$count];
					$arrayRegistrosOrganizados[$i]['data_fim_previsto'] = $this->request->data['Acao']['data_fim_previsto'][$count];
					$count++;
				}
					
				foreach($arrayRegistrosOrganizados as $arrayRegistro){
					$sqlAtualizaDatas = $this->Acao->query("UPDATE acao SET data_inicio_previsto = '".$arrayRegistro['data_inicio_previsto']."',
																	data_fim_previsto = '".$arrayRegistro['data_fim_previsto']."'
													WHERE acao.id='".$arrayRegistro['id']."'");
				}
				
			}else{
				
				for($i=0;$i<$quantidadeRegistros;$i++){
					$arrayRegistrosOrganizados[$i]['id'] = $this->request->data['Acao']['id'][$count];
					$arrayRegistrosOrganizados[$i]['data_inicio_previsto'] = $this->request->data['Acao']['data_inicio_previsto'][$count];
					$arrayRegistrosOrganizados[$i]['data_fim_previsto'] = $this->request->data['Acao']['data_fim_previsto'][$count];
					$count++;
				}
					
				foreach($arrayRegistrosOrganizados as $arrayRegistro){
					$dataParaBanco = Util::inverteData($arrayRegistro['data_inicio_previsto']);
					$nova_data_fim_previsto = date('Y-m-d', strtotime("+".$this->request->data['Acao']['dias_a_mais'][0]." days",strtotime($dataParaBanco)));
					
					$sqlAtualizaDatas = $this->Acao->query("UPDATE acao SET data_inicio_previsto = '".$arrayRegistro['data_inicio_previsto']."',
																	data_fim_previsto = '".$nova_data_fim_previsto."'
													WHERE acao.id='".$arrayRegistro['id']."'");
					
				}
				
			}
			
			
		}
		
		$msg = "Registros alterados com sucesso";
		
		$json["msg"] = $msg;
		echo json_encode($json);
	}
	
	/**
	 * 
	 */
	public function exibirGrafico(){
		$this->autoRender = false;
		$this->layout = "ajax";
		
		$this->loadModel("Acao");
		$this->Acao->recursive = -1;
		$acoes = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.projeto_id' => $_GET['projeto_id'])));
		
		$total = count($acoes);
		$participacao = array('Em andamento' => 0, 'Não Iniciada' => 0, 'Aguardando outra pessoa' => 0, 'Concluida' => 0, 'Cancelada' => 0);
		foreach ($acoes as $key => $value) {
			switch ($value['Acao']['status']) {
				case Util::EM_ANDAMENTO:
					$participacao['Em andamento']++;
					break;
				case Util::NAO_INICIADO:
					$participacao['Não Iniciada']++;
					break;
				case Util::AGUARDANDO_OUTRA_PESSOA:
					$participacao['Aguardando outra pessoa']++;
					break;
				case Util::CONCLUIDO:
					$participacao['Concluida']++;
					break;
				case Util::CANCELADO:
					$participacao['Cancelada']++;
					break;
				default:					
					break;
			}
		}
		
		$retorno = array('type' => 'pie', 'name' => 'Participação', 'data' => array());
		foreach ($participacao as $key => $value) {
			if($value == 0){
				unset($participacao[$key]);
			}else{
				$proporcao = ($value/$total)*100;
				$retorno['data'][] = array($key, floatval(number_format($proporcao, 2)));
			}
		}
		echo json_encode($retorno);
		
	}

	/**
	 * cronograma method
	 *
	 * @throws NotFoundException
	 * @return void
	 */	
	public function exibirGantt($id = null){
		$this->autoRender = false;
		$this->layout = "ajax";
		$_GET['projeto_id'] = $id;
		
		$this->loadModel("Acao");
		$this->Acao->recursive = -1;
		$acoes = $this->Acao->find('all', array('conditions' => array('Acao.status != ' => Util::INATIVO, 'Acao.projeto_id' => $_GET['projeto_id'])));
		
		//$retorno = array('data' => array(), 'links' => array());
		//$data = array();
		//$link = array();
		$dados = array();
		$count = 0;
		foreach ($acoes as $key => $value) {
			$count++;
			$diferenca = Util::difData($value['Acao']['data_inicio_previsto'], $value['Acao']['data_fim_previsto'], 'D');
			if($value['Acao']['acao_id'] != null){
				//$link[] = array('id' => $count, 'source' => $value['Acao']['acao_id'], 'target' => $value['Acao']['id'], 'type' => "0");
				//$data[] = array('id' => $value['Acao']['id'], 'text' => $value['Acao']['titulo'], 'start_date' => str_replace("/", "-", $value['Acao']['data_inicio_previsto']), 'duration' => $diferenca, 'progress' => 0, 'open' => true, 'parent' => $value['Acao']['acao_id']);
				$inicio = explode("/", $value['Acao']['data_inicio_previsto']);
				$fim = explode("/", $value['Acao']['data_fim_previsto']);
				$dados[] = array('name' => $value['Acao']['titulo'], "desc" => "", "values" => array(array('id' => $value['Acao']['id'], "from" => "/Date(".mktime(0,0,0, $inicio[1], $inicio[0], $inicio[2])."000)/", "to" => "/Date(".mktime(0,0,0, $fim[1], $fim[0], $fim[2])."000)/", "desc" => $value['Acao']['titulo'], "dep" => $value['Acao']['acao_id'])));
			}else{
				//$data[] = array('id' => $value['Acao']['id'], 'text' => $value['Acao']['titulo'], 'start_date' => str_replace("/", "-", $value['Acao']['data_inicio_previsto']), 'duration' => $diferenca, 'progress' => 0, 'open' => true);
				$inicio = explode("/", $value['Acao']['data_inicio_previsto']);
				$fim = explode("/", $value['Acao']['data_fim_previsto']);
				$dados[] = array('name' => $value['Acao']['titulo'], "desc" => "", "values" => array(array('id' => $value['Acao']['id'], "from" => "/Date(".mktime(0,0,0, $inicio[1], $inicio[0], $inicio[2])."000)/", "to" => "/Date(".mktime(0,0,0, $fim[1], $fim[0], $fim[2])."000)/", "desc" => $value['Acao']['titulo'])));
			}		
		}
		//$retorno['data'] = $data;
		//$retorno['links'] = $link;
		echo json_encode($dados);
		
	}
}
