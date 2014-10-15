<?php
App::uses('AppController', 'Controller');
/**
 * MapaEstrategico Controller
 *
 * @property MapaEstrategico $MapaEstrategico
 * @property SessionComponent $Session
 */
class MapaEstrategicoController extends AppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
    	$this->Auth->allowedActions = array('ajaxGrafico', 'recuperarIndicadoresFilhos', 'ajaxPainelResumo', 'ajaxPainelResumoApenas', 'ajaxPainelAcoes', 'ajaxFormIndices');
	}
	
	public function index(){
		
		if($this->request->is("post")){
			$this->Session->write('ano_selecionado_indicadores',  $this->request->data['Indicador']['anos'][0]);
			$anoSelecionado = $this->request->data['Indicador']['anos'][0];
		}else{
			$this->Session->write('ano_selecionado_indicadores', date("Y"));
			$anoSelecionado = date("Y");
		}
		
		$this->loadModel("Dimensao");
		$this->Dimensao->recursive = 2;
		$dimensoes = $this->Dimensao->find("all", array('conditions' => array('Dimensao.status' => Util::ATIVO)));
		
		$this->set("anoSelecionado", $anoSelecionado);
		$this->set("dimensoes", $dimensoes);
				
	}
	
	public function indicadores($id = null){
		$this->index();
		Configure::write('debug', 0);
		
		$this->layout = "ajax";
		
		$this->loadModel("Indicador");
		
		$this->Indicador->recursive = 1;
		$indicadores = $this->Indicador->find("all", array('conditions' => array('Indicador.objetivo_id' => $id, 'Indicador.status' => Util::ATIVO), 'order' => array('Indicador.ordem ASC')));
		
		
		//Algoritimo para buscar pelos indicadores do ano selecionado pelo usuario e fazer seus calculos de meta e realizado
		$indicadoresFiltrados = array();
		$anoSelecionado = $this->Session->read('ano_selecionado_indicadores');
		foreach ($indicadores as $indicador) {
			$filhos = $this->Indicador->find("all", array('conditions' => array('Indicador.objetivo_id' => $id, 'Indicador.indicador_id' => $indicador['Indicador']['id']), 'order' => array('Indicador.ordem ASC')));
			if($indicador['Indicador']['anos'] != null or $indicador['Indicador']['anos'] != ''){
				$anos = explode(",", $indicador['Indicador']['anos']);
				if(in_array($anoSelecionado, $anos)){
					$indicador['TotalIndicador'] = Util::getTotalIndicador($indicador, $filhos);
					$indicador['TotalAnomalias'] = Util::getTotalAnomalias($indicador);
					$indicadoresFiltrados[] = $indicador;
				}
			}			
		}
//var_dump($indicadoresFiltrados);
//die;
		//Fim de algoritimo para pegar indicadores pelo ano
		
		//Ver melhor forma de fazer esse algoritito com Túlio
		//Algoritimo de ordenação para criar arvore de Pais e filhos correta
		/*$arrayOrdenado = array();
		foreach($indicadoresFiltrados as $key1 => $value){
			if($value['Pai']['id'] != null){
				foreach ($arrayOrdenado as $key2 => $value2) {
					if($value2['Indicador']['id'] == $value['Pai']['id']){
						$arrayOrdenado[] = $arrayOrdenado[$key2 + 1];						
						$arrayOrdenado[$key2 + 1] = $value;
					}
				}
			}else{
				$arrayOrdenado[] = $value;
			}
		}*/
		//Fim de algoritimo de ordenação
		
		//var_dump($arrayOrdenado);
		
		$this->loadModel("Objetivo");
		$objetivos = $this->Objetivo->find("all", array('conditions' => array('Objetivo.objetivo_id' => $id)));
		
		//Usar $arrayOrdenado ou $indicadoresFiltrados
		 $this->set("indicadores",$indicadoresFiltrados);
		 $this->set("objetivos", $objetivos);
		 $this->set("objetivoPaiId", $id);
		 $this->set("id_usuario_logado", $this->Auth->user('id'));
		
	}
	
	public function indicadoresPorProjeto($id = null){
		Configure::write('debug', 0);
	
		$this->layout = "ajax";
	
		$this->loadModel("Indicador");
	
		$this->Indicador->recursive = 1;
		$indicadores = $this->Indicador->find("all", array('conditions' => array('Indicador.projeto_id' => $id, 'Indicador.status' => Util::ATIVO), 'order' => array('Indicador.ordem ASC')));
	
	
		//Algoritimo para buscar pelos indicadores do ano selecionado pelo usuario e fazer seus calculos de meta e realizado
		$indicadoresFiltrados = array();
		$anoSelecionado = $this->Session->read('ano_selecionado_indicadores');
		foreach ($indicadores as $indicador) {
			$filhos = $this->Indicador->find("all", array('conditions' => array('Indicador.projeto_id' => $id, 'Indicador.indicador_id' => $indicador['Indicador']['id']), 'order' => array('Indicador.ordem ASC')));
			if($indicador['Indicador']['anos'] != null or $indicador['Indicador']['anos'] != ''){
				$anos = explode(",", $indicador['Indicador']['anos']);
				if(in_array($anoSelecionado, $anos)){
					$indicador['TotalIndicador'] = Util::getTotalIndicador($indicador, $filhos);
					$indicador['TotalAnomalias'] = Util::getTotalAnomalias($indicador);
					$indicadoresFiltrados[] = $indicador;
				}
			}
		}
	
		//Usar $arrayOrdenado ou $indicadoresFiltrados
		$this->set("indicadores",$indicadoresFiltrados);
		$this->set("objetivos", array());
		$this->set("projetoId", $id);
		$this->set("id_usuario_logado", $this->Auth->user('id'));
		
		$this->render("indicadores");
	
	}

	public function ajaxGrafico(){
		
		$this->autoRender = false;
		Configure::write('debug', 0);
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			
			$this->loadModel("IndicadorMeta");
			$this->loadModel("IndicadorRealizado");
			$anoSelecionado = $this->Session->read("ano_selecionado_indicadores");
			$indicadorId = $this->request->query['IdIndicador'];//$this->request->data['Indicador']['id'];
			$this->IndicadorMeta->recursive = -1;
			$metas = $this->IndicadorMeta->find('all', array('conditions' => array('IndicadorMeta.indicador_id = ' => $indicadorId, 'IndicadorMeta.ano = ' => $anoSelecionado)));
			$this->IndicadorRealizado->recursive = -1;
			$realizados = $this->IndicadorRealizado->find('all', array('conditions' => array('IndicadorRealizado.indicador_id' => $indicadorId, 'IndicadorRealizado.ano' => $anoSelecionado)));
		
			$arrayJson = array(0 => array('name' => 'Realizado', 'data' => array()), 1 => array('name' => 'Meta', 'data' => array()));
			foreach($metas[0]['IndicadorMeta'] as $chave => $meta){
				if($chave != 'indicador_id' && $chave != 'ano' && $chave != 'id'){
					$meta = str_replace(".", "", $meta);
					$meta = str_replace(",", ".", $meta);
					$arrayJson[1]['data'][] = (float)$meta;
				}
			}
			foreach($realizados[0]['IndicadorRealizado'] as $chave => $realizado){
				if($chave != 'indicador_id' && $chave != 'ano' && $chave != 'id'){
					$realizado = str_replace(".", "", $realizado);
					$realizado = str_replace(",", ".", $realizado);
					$arrayJson[0]['data'][] = (float)$realizado;
				}
			}
			
			
		}			
		echo json_encode($arrayJson);
	}

	public function recuperarIndicadoresFilhos(){
		$this->autoRender = false;
		Configure::write('debug', 0);
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$idFilhos = array();
			$this->loadModel("Indicador");
			$indicadores = $this->Indicador->find("first", array('conditions' => array('Indicador.status' => Util::ATIVO,'Indicador.objetivo_id' => $this->request->data['objetivo_id'], 'Indicador.id' => $this->request->data['indicador_id']), 'order' => array('Indicador.ordem ASC')));
			foreach ($indicadores['Filhos'] as $filho) {
				$idFilhos[] = $filho[id];
			}
			echo json_encode($idFilhos);
		}
		
	}
	
	public function ajaxPainelResumo(){
		$this->layout = "ajax";
		$this->loadModel("Indicador");
		
		if(!empty($this->request->data['objetivo_id'])){
			$indicador = $this->Indicador->find("first", array('conditions' => array('Indicador.status' => Util::ATIVO,'Indicador.objetivo_id' => $this->request->data['objetivo_id'], 'Indicador.id' => $this->request->data['indicador_id'])));
		}else if(!empty($this->request->data['projeto_id'])){
			$indicador = $this->Indicador->find("first", array('conditions' => array('Indicador.status' => Util::ATIVO,'Indicador.projeto_id' => $this->request->data['projeto_id'], 'Indicador.id' => $this->request->data['indicador_id'])));
		}
		
		foreach ($indicador['IndicadorMeta'] as $key => $value) {
			if($value['ano'] == $this->Session->read("ano_selecionado_indicadores")){
				$indicador['IndicadorMeta'] = $value;
				break;
			}
		}
		foreach ($indicador['IndicadorRealizado'] as $key => $value) {
			if($value['ano'] == $this->Session->read("ano_selecionado_indicadores")){
				$indicador['IndicadorRealizado'] = $value;
				break;
			}
		}
		$this->set("indicador", $indicador);
		$this->set("mes", $this->request->data['mes']);
	}

	public function ajaxPainelResumoApenas(){
		$this->layout = "ajax";
		$this->loadModel("Indicador");
		$indicador = $this->Indicador->find("first", array('conditions' => array('Indicador.status' => Util::ATIVO, 'Indicador.id' => $this->request->data['indicador_id'])));
		foreach ($indicador['IndicadorMeta'] as $key => $value) {
			if($value['ano'] == $this->Session->read("ano_selecionado_indicadores")){
				$indicador['IndicadorMeta'] = $value;
				break;
			}
		}
		foreach ($indicador['IndicadorRealizado'] as $key => $value) {
			if($value['ano'] == $this->Session->read("ano_selecionado_indicadores")){
				$indicador['IndicadorRealizado'] = $value;
				break;
			}
		}
		$this->set("indicador", $indicador);
		$this->set("mes", $this->request->data['mes']);
	}


	public function ajaxPainelAcoes(){
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->loadModel("Acao");
		$acoes = $this->Acao->find("all", array('conditions' => array('Acao.objetivo_id' => $this->request->data['objetivo_id'])));
		$this->set("objetivo_id", $this->request->data['objetivo_id']);
		$this->set("acoes", $acoes);
	}
	
	public function ajaxFormIndices(){
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->loadModel("Indicador");
		$this->Indicador->recursive = 2;
		$indicador = $this->Indicador->find("first", array("conditions" => array("Indicador.id" => $this->request->data['indicador_id']), 'order' => array('Indicador.ordem ASC')));
		
		$this->set("indicadorPai", $indicador);
		$this->set("objetivoPaiId", $this->request->data['objetivo_id']);
		$this->set("ano", $this->Session->read("ano_selecionado_indicadores"));
		 $this->set("id_usuario_logado", $this->Auth->user('id'));
	}
	
	/**
	 * Função para salvar os forms vindos do mapa estrategico
	 */
	public function salvar(){
		
		
		$this->layout = "ajax";		
		
		$this->loadModel("Indicador");
		$this->loadModel("IndicadorMeta");
		$this->loadModel("IndicadorRealizado");
		
		//Primeiramente varremos cada índice do formulário
		//Cada índice equivale as metas e aos realizados de cada indicador
		foreach ($this->request->data as $key => $value) {
			
			//Preparamos as variaveis dos dados a serem salvos, do indicador atual do foreach e os pais desse indicador
			$dadosAsalvar = $value;			
			$indicador = $this->Indicador->find("first", array('conditions' => array('Indicador.id' => $value['Indicador']['id'])));
			$paisSelecionados = array();
			
			//Algoritimo para identificar a arvore de pais do indicador
			//Atualmente está configurado para pegar até 10 niveis de pais acima do indicador
			if(isset($value['Indicador']['pai_id']) && $value['Indicador']['pai_id'] != null){
				$pais = array($value['Indicador']['pai_id']);
				for ($i=0; $i < 10; $i++) {
					if(isset($pais[$i])){
						$indicadorPai = $this->Indicador->find('first', array('conditions' => array('Indicador.id' => $pais[$i])));
						$paisSelecionados[] = $indicadorPai;
						$pais[] = $indicadorPai['Pai']['id'];
					}
				}			
			}
			//Fim do algoritimo para identificar a arvore de pais do indicador
			
			$base = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			
			//Fazemos o calculo do indicador em questão			
			$base[0] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['janeiro']);
			$dadosAsalvar['IndicadorMeta']['janeiro'] = Util::trataNumero($base[0], false);					
			$base[1] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['fevereiro']);
			$dadosAsalvar['IndicadorMeta']['fevereiro'] = Util::trataNumero($base[1], false);					
			$base[2] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['marco']);
			$dadosAsalvar['IndicadorMeta']['marco'] = Util::trataNumero($base[2], false);
			$base[3] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['abril']);
			$dadosAsalvar['IndicadorMeta']['abril'] = Util::trataNumero($base[3], false);	
			$base[4] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['maio']);
			$dadosAsalvar['IndicadorMeta']['maio'] = Util::trataNumero($base[4], false);	
			$base[5] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['junho']);
			$dadosAsalvar['IndicadorMeta']['junho'] = Util::trataNumero($base[5], false);	
			$base[6] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['julho']);
			$dadosAsalvar['IndicadorMeta']['julho'] = Util::trataNumero($base[6], false);	
			$base[7] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['agosto']);
			$dadosAsalvar['IndicadorMeta']['agosto'] = Util::trataNumero($base[7], false);	
			$base[8] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['setembro']);
			$dadosAsalvar['IndicadorMeta']['setembro'] = Util::trataNumero($base[8], false);	
			$base[9] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['outubro']);
			$dadosAsalvar['IndicadorMeta']['outubro'] = Util::trataNumero($base[9], false);	
			$base[10] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['novembro']);
			$dadosAsalvar['IndicadorMeta']['novembro'] = Util::trataNumero($base[10], false);	
			$base[11] += Util::trataNumero($this->request->data[$key]['IndicadorMeta']['dezembro']);
			$dadosAsalvar['IndicadorMeta']['dezembro'] = Util::trataNumero($base[11], false);
			
			$base[12] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['janeiro']);
			$dadosAsalvar['IndicadorRealizado']['janeiro'] = Util::trataNumero($base[12], false);
			$base[13] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['fevereiro']);
			$dadosAsalvar['IndicadorRealizado']['fevereiro'] = Util::trataNumero($base[13], false);
			$base[14] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['marco']);
			$dadosAsalvar['IndicadorRealizado']['marco'] = Util::trataNumero($base[14], false);
			$base[15] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['abril']);
			$dadosAsalvar['IndicadorRealizado']['abril'] = Util::trataNumero($base[15], false);
			$base[16] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['maio']);
			$dadosAsalvar['IndicadorRealizado']['maio'] = Util::trataNumero($base[16], false);
			$base[17] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['junho']);
			$dadosAsalvar['IndicadorRealizado']['junho'] = Util::trataNumero($base[17], false);
			$base[18] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['julho']);
			$dadosAsalvar['IndicadorRealizado']['julho'] = Util::trataNumero($base[18], false);
			$base[19] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['agosto']);
			$dadosAsalvar['IndicadorRealizado']['agosto'] = Util::trataNumero($base[19], false);
			$base[20] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['setembro']);
			$dadosAsalvar['IndicadorRealizado']['setembro'] = Util::trataNumero($base[20], false);
			$base[21] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['outubro']);
			$dadosAsalvar['IndicadorRealizado']['outubro'] = Util::trataNumero($base[21], false);
			$base[22] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['novembro']);
			$dadosAsalvar['IndicadorRealizado']['novembro'] = Util::trataNumero($base[22], false);
			$base[23] += Util::trataNumero($this->request->data[$key]['IndicadorRealizado']['dezembro']);
			$dadosAsalvar['IndicadorRealizado']['dezembro'] = Util::trataNumero($base[23], false);
				
			
			//Atualizamos o valor do indicador no banco de dados e passamos 
			//para a etapa de atualizar os dados dos pais recursivamente
			$this->IndicadorRealizado->save($dadosAsalvar);
			$this->IndicadorMeta->save($dadosAsalvar);
			$this->IndicadorRealizado->id = null;
			$this->IndicadorMeta->id = null;
			
			//Primeiramente verificamos se o indicador possui algum pai
			if(count($paisSelecionados) > 0){
				//Se sim, varremos o array de pais recursivos
				foreach ($paisSelecionados as $pai) {
					
					//Para cada pai queremos atualizar somente as metas e os realizados do ano selecionado pelo User
					//Então pegamos os id da meta e do realizado desse ano para usar na busca mais a frente
					foreach ($pai['IndicadorMeta'] as $meta) {
						if($meta['ano'] == $this->Session->read("ano_selecionado_indicadores")){
							$idMeta = $meta['id'];
						}						
					}
					foreach ($pai['IndicadorRealizado'] as $realizado) {
						if($realizado['ano'] == $this->Session->read("ano_selecionado_indicadores")){
							$idRealizado = $realizado['id'];
						}
					}
					//Fim da logica para pegar a meta e o realizado do ano selecionado pelo User
					
					//Criamos arrays que servirão como base de calculo para os filhos desse indicador Pai
					$totalMeta = array("IndicadorMeta" => array("id" => $idMeta,"janeiro" => 0, "fevereiro" => 0, "marco" => 0,"abril" => 0, "maio" => 0, "junho" => 0,"julho" => 0, "agosto" => 0, "setembro" => 0,"outubro" => 0, "novembro" => 0, "dezembro" => 0));
					$totalRealizado = array("IndicadorRealizado" => array("id" => $idRealizado,"janeiro" => 0, "fevereiro" => 0, "marco" => 0,"abril" => 0, "maio" => 0, "junho" => 0,"julho" => 0, "agosto" => 0, "setembro" => 0,"outubro" => 0, "novembro" => 0, "dezembro" => 0));
					
					//Variável usada para a divisão do indice total do indicador caso o cálculo dele seja do tipo média
					$count = 0;
					
					//Buscamos pelos índices dos filhos desse indicador Pai e realizamos os calculos de cada um
					foreach ($pai['Filhos'] as $filho) {
						$metas = $this->IndicadorMeta->find("first", array("conditions" => array("IndicadorMeta.indicador_id" => $filho['id'], "IndicadorMeta.ano" => $this->Session->read("ano_selecionado_indicadores"))));
						$realizados = $this->IndicadorRealizado->find("first", array("conditions" => array("IndicadorRealizado.indicador_id" => $filho['id'], "IndicadorRealizado.ano" => $this->Session->read("ano_selecionado_indicadores"))));
						if($filho['tipo_calculo'] == Util::TIPO_CALCULO_POSITIVO){
							
							$totalMeta['IndicadorMeta']['janeiro'] += str_replace(",", ".", str_replace(".", "",  $metas['IndicadorMeta']['janeiro']));
							$totalMeta['IndicadorMeta']['fevereiro'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['fevereiro']));
							$totalMeta['IndicadorMeta']['marco'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['marco']));
							$totalMeta['IndicadorMeta']['abril'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['abril']));
							$totalMeta['IndicadorMeta']['maio'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['maio']));
							$totalMeta['IndicadorMeta']['junho'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['junho']));
							$totalMeta['IndicadorMeta']['julho'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['julho']));
							$totalMeta['IndicadorMeta']['agosto'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['agosto']));
							$totalMeta['IndicadorMeta']['setembro'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['setembro']));
							$totalMeta['IndicadorMeta']['outubro'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['outubro']));
							$totalMeta['IndicadorMeta']['novembro'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['novembro']));
							$totalMeta['IndicadorMeta']['dezembro'] += str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['dezembro']));
							
							$totalRealizado['IndicadorRealizado']['janeiro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['janeiro']));
							$totalRealizado['IndicadorRealizado']['fevereiro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['fevereiro']));
							$totalRealizado['IndicadorRealizado']['marco'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['marco']));
							$totalRealizado['IndicadorRealizado']['abril'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['abril']));
							$totalRealizado['IndicadorRealizado']['maio'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['maio']));
							$totalRealizado['IndicadorRealizado']['junho'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['junho']));
							$totalRealizado['IndicadorRealizado']['julho'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['julho']));
							$totalRealizado['IndicadorRealizado']['agosto'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['agosto']));
							$totalRealizado['IndicadorRealizado']['setembro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['setembro']));
							$totalRealizado['IndicadorRealizado']['outubro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['outubro']));
							$totalRealizado['IndicadorRealizado']['novembro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['novembro']));
							$totalRealizado['IndicadorRealizado']['dezembro'] += str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['dezembro']));
							$count ++;
						}else if($filho['tipo_calculo'] == Util::TIPO_CALCULO_NEGATIVO){
							
							$totalMeta['IndicadorMeta']['janeiro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['janeiro']));
							$totalMeta['IndicadorMeta']['fevereiro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['fevereiro']));
							$totalMeta['IndicadorMeta']['marco'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['marco']));
							$totalMeta['IndicadorMeta']['abril'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['abril']));
							$totalMeta['IndicadorMeta']['maio'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['maio']));
							$totalMeta['IndicadorMeta']['junho'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['junho']));
							$totalMeta['IndicadorMeta']['julho'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['julho']));
							$totalMeta['IndicadorMeta']['agosto'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['agosto']));
							$totalMeta['IndicadorMeta']['setembro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['setembro']));
							$totalMeta['IndicadorMeta']['outubro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['outubro']));
							$totalMeta['IndicadorMeta']['novembro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['novembro']));
							$totalMeta['IndicadorMeta']['dezembro'] -= str_replace(",", ".", str_replace(".", "", $metas['IndicadorMeta']['dezembro']));
							
							$totalRealizado['IndicadorRealizado']['janeiro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['janeiro']));
							$totalRealizado['IndicadorRealizado']['fevereiro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['fevereiro']));
							$totalRealizado['IndicadorRealizado']['marco'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['marco']));
							$totalRealizado['IndicadorRealizado']['abril'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['abril']));
							$totalRealizado['IndicadorRealizado']['maio'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['maio']));
							$totalRealizado['IndicadorRealizado']['junho'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['junho']));
							$totalRealizado['IndicadorRealizado']['julho'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['julho']));
							$totalRealizado['IndicadorRealizado']['agosto'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['agosto']));
							$totalRealizado['IndicadorRealizado']['setembro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['setembro']));
							$totalRealizado['IndicadorRealizado']['outubro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['outubro']));
							$totalRealizado['IndicadorRealizado']['novembro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['novembro']));
							$totalRealizado['IndicadorRealizado']['dezembro'] -= str_replace(",", ".", str_replace(".", "", $realizados['IndicadorRealizado']['dezembro']));
							$count ++;
							
						}
					}					
					
					//Ao final se o indicador for do tipo média, tiramos a média desse indicador com base na quantidade dos seus filhos relevantes so cálculo
					if($pai['Indicador']['calculo'] == Util::CALCULO_MEDIA){
						
						$totalMeta['IndicadorMeta']['janeiro'] = number_format($totalMeta['IndicadorMeta']['janeiro']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['fevereiro'] = number_format($totalMeta['IndicadorMeta']['fevereiro']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['marco'] = number_format($totalMeta['IndicadorMeta']['marco']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['abril'] = number_format($totalMeta['IndicadorMeta']['abril']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['maio'] = number_format($totalMeta['IndicadorMeta']['maio']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['junho'] = number_format($totalMeta['IndicadorMeta']['junho']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['julho'] = number_format($totalMeta['IndicadorMeta']['julho']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['agosto'] = number_format($totalMeta['IndicadorMeta']['agosto']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['setembro'] = number_format($totalMeta['IndicadorMeta']['setembro']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['outubro'] = number_format($totalMeta['IndicadorMeta']['outubro']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['novembro'] = number_format($totalMeta['IndicadorMeta']['novembro']/$count, 2, ",", ".");
						$totalMeta['IndicadorMeta']['dezembro'] = number_format($totalMeta['IndicadorMeta']['dezembro']/$count, 2, ",", ".");
						
						$totalRealizado['IndicadorRealizado']['janeiro'] = number_format($totalRealizado['IndicadorRealizado']['janeiro']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['fevereiro'] = number_format($totalRealizado['IndicadorRealizado']['fevereiro']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['marco'] = number_format($totalRealizado['IndicadorRealizado']['marco']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['abril'] = number_format($totalRealizado['IndicadorRealizado']['abril']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['maio'] = number_format($totalRealizado['IndicadorRealizado']['maio']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['junho'] = number_format($totalRealizado['IndicadorRealizado']['junho']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['julho'] = number_format($totalRealizado['IndicadorRealizado']['julho']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['agosto'] = number_format($totalRealizado['IndicadorRealizado']['agosto']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['setembro'] = number_format($totalRealizado['IndicadorRealizado']['setembro']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['outubro'] = number_format($totalRealizado['IndicadorRealizado']['outubro']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['novembro'] = number_format($totalRealizado['IndicadorRealizado']['novembro']/$count, 2, ",", ".");
						$totalRealizado['IndicadorRealizado']['dezembro'] = number_format($totalRealizado['IndicadorRealizado']['dezembro']/$count, 2, ",", ".");
					}
					
					//Ao final, atualizamos os valores, para ficarem no formato adequado para inserir no banco de dados
					foreach ($totalMeta["IndicadorMeta"] as $key => $value) {
						$totalMeta["IndicadorMeta"][$key] = str_replace(".", ",", $value);
					}
					foreach ($totalRealizado["IndicadorRealizado"] as $key => $value) {
						$totalRealizado["IndicadorRealizado"][$key] = str_replace(".", ",", $value);
					}
					
					//Salvamos os dados desse pai no banco
					$this->IndicadorRealizado->save($totalRealizado);
					$this->IndicadorMeta->save($totalMeta);
					$this->IndicadorRealizado->id = null;
					$this->IndicadorMeta->id = null;
				}
			}			
		}
		echo Util::REGISTRO_ADICIONADO_SUCESSO;
	}

}
