<?php
App::uses('AppController', 'Controller');
/**
 * Organograma Controller
 *
 * @property Organograma $Organograma
 * @property SessionComponent $Session
 */
class OrganogramaController extends AppController {
	
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
		
		$this->loadModel("Usuario");
		$this->loadModel("Setor");
		$this->loadModel("Departamento");
		$idDepartamento = $this->Auth->user('departamento_id');
		
		//Virificamos se o Array de dados de busca vem com dados para adicionarmos na sessão
		if(!empty($this->request->data)) {
			if(!empty($this->request->data['Projeto']['busca'])){
				$add = true;
				if(isset($_SESSION['Search']['Organograma'])){
					// verificando se a busca realizada já existe na sessão
					foreach($_SESSION['Search']['Organograma'] as $busca){
						if($this->request->data['Projeto']['busca'] == $busca["busca"]){
							$add = false;	
						}
					}
				}
				// caso não exista, adiciona na sessão
				if($add){
					$_SESSION['Search']['Organograma'][]['busca'] = $this->request->data['Projeto']['busca'];
				}
			}
		}else{
			if(empty($_SESSION['Search']['Organograma'])){
				$_SESSION['Search']['Organograma'][]['busca'] = $idDepartamento;
			}
		}
		
		//Lemos a sessão se não estiver vázia para aplicar os filtros
		$userConditions["AND"][] = array("Usuario.status"=>Util::ATIVO);
		if(isset($_SESSION['Search']['Organograma'])){
			foreach($_SESSION['Search']['Organograma'] as $termo_busca){
				$userConditions["OR"][] = array("Usuario.departamento_id"=>$termo_busca["busca"]);
			}
		}
		
		$usuarios = $this->Usuario->find("all", array('conditions' => $userConditions));
		
		$setoresSuperiores = $this->Setor->find("all", array('conditions' => array("Setor.status" => Util::ATIVO, 'Setor.tipo' => Util::TIPO_SUPERIOR)));
		$setoresInferiores = $this->Setor->find("all", array('conditions' => array("Setor.status" => Util::ATIVO, 'Setor.tipo' => Util::TIPO_INFERIOR)));
		$departamentos = $this->Departamento->find("all", array('conditions' => array("Departamento.status" => Util::ATIVO)));
		$labelDepartamentos = array();
		foreach($departamentos as $departamento){
			$labelDepartamentos[$departamento["Departamento"]["id"]] = $departamento["Departamento"]["titulo"];
		}
		
		$usuariosPorSetor = array();
		foreach($usuarios as $usuario){
			$usuariosPorSetor[$usuario["Usuario"]["setor_id"]][] = $usuario;
		}
		
		$this->set('usuariosPorSetor', $usuariosPorSetor);
		$this->set('setoresSuperiores', $setoresSuperiores);
		$this->set('setoresInferiores', $setoresInferiores);
		$this->set('departamentos', $departamentos);
		$this->set('labelDepartamentos', $labelDepartamentos);
		$this->set('idDepartamento', $idDepartamento);
		
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
		unset($_SESSION['Search']['Organograma'][$filtro]);
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * 
	 */
	public function ajaxPainelResumo(){
		Configure::write('debug', 0);
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			if(isset($this->request->data['data_atual']) && $this->request->data['data_atual'] == "atual"){
				$data = date("Y");
			}else{
				$data = $this->request->data['data_selecionada'];
			}			
			$this->loadModel("Usuario");
			$this->loadModel("Indicador");
			$this->Usuario->recursive = 2;
			$usuario = $this->Usuario->find("first", array("conditions" => array('Usuario.id' => $this->request->data['usuario_id'])));
			
			$this->Indicador->recursive = 1;
			$indicadores = $this->Indicador->find("all", array('conditions' => array('Indicador.status' => Util::ATIVO), 'order' => array('Indicador.ordem ASC')));
		
			
			//Algoritimo para buscar pelos indicadores do ano selecionado pelo usuario e fazer seus calculos de meta e realizado
			$indicadoresFiltrados = array();
			//Atualmente trazendo apenas indicador do ano atual
			$_SESSION['ano_selecionado_indicadores'] = date("Y");
			$anoSelecionado = $_SESSION['ano_selecionado_indicadores'];
			foreach ($indicadores as $indicador) {
				$filhos = $this->Indicador->find("all", array('conditions' => array('Indicador.indicador_id' => $indicador['Indicador']['id']), 'order' => array('Indicador.ordem ASC')));
				if($indicador['anos'] != null or $indicador['Indicador']['anos'] != ''){
					$anos = explode(",", $indicador['Indicador']['anos']);
					if(in_array($anoSelecionado, $anos)){
						$indicador['TotalIndicador'] = Util::getTotalIndicador($indicador, $filhos);
						$indicador['TotalAnomalias'] = Util::getTotalAnomalias($indicador);
						$indicadoresFiltrados[] = $indicador;
					}
				}			
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
			
			$this->set("usuario", $usuario);
			$this->set("indicadores", $indicadoresFiltrados);
			$this->set("anomaliasAssociadas", $anomalias);
		}
		
	}

}
