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
 * Indicador Controller
 *
 * @property Indicador $Indicador
 * @property SessionComponent $Session
 */
class IndicadorController extends AppController {
	
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
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Indicador.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
	    // Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		$this->Indicador->recursive = 2;
		$this->paginate['conditions'][] = array('Indicador.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('Indicador.titulo' => 'asc');
		$this->set('indicador', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function visualizar($id = null) {
		$this->Indicador->id = $id;
		if (!$this->Indicador->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		
		$this->loadModel('IndicadorResponsavelMeta');
		$this->IndicadorResponsavelMeta->recursive = 2;
		$indicadorResponsavelMeta = $this->IndicadorResponsavelMeta->find('all', array('conditions' => array('IndicadorResponsavelMeta.indicador_id' => $id)));

		$this->loadModel('IndicadorResponsavelrealizado');
		$this->IndicadorResponsavelrealizado->recursive = 2;
		$indicadorResponsavelrealizado = $this->IndicadorResponsavelrealizado->find('all', array('conditions' => array('IndicadorResponsavelrealizado.indicador_id' => $id)));
		
		$this->loadModel('IndicadorAutorizadoVisualizar');
		$this->IndicadorAutorizadoVisualizar->recursive = 2;
		$indicadorAutorizadoVisualizar = $this->IndicadorAutorizadoVisualizar->find('all', array('conditions' => array('IndicadorAutorizadoVisualizar.indicador_id' => $id)));
		
		//Inicio do algoritimo para transformar a string de anos em array
		$this->Indicador->read();
		$anos = $this->Indicador->read(null, $id);
		$anos = explode(",", $anos['Indicador']['anos']);
		foreach($anos as $ano){
			$anos2[$ano] = $ano;
		}
		//Fim de algoritimo para tranfirmar a string
		
		$this->Indicador->recursive = 2;
		$this->set('indicador', $this->Indicador->read(null, $id));
		$this->set('indicadorResponsavelMeta', $indicadorResponsavelMeta);
		$this->set('indicadorResponsavelrealizado', $indicadorResponsavelrealizado);
		$this->set('indicadorAutorizadoVisualizar', $indicadorAutorizadoVisualizar);
		$this->set('anos', $anos2);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function adicionar() {	
		if ($this->request->is('post')) {
			$this->Indicador->create();
			
			//Algoritimo para montar a string de anos
			$anos = '';
			$anosAntes = $this->request->data['Indicador']['anos'];
			foreach($this->request->data['Indicador']['anos'] as $ano){
				$anos .= $ano.',';
			}
			$anos = rtrim($anos, ",");
			$this->request->data['Indicador']['anos'] = $anos;
			//Fim do algoritimo para montar string do ano
			
			if ($this->Indicador->save($this->request->data)) {
				
				$data = array();
				$this->loadModel('IndicadorResponsavelRealizado');
				foreach($this->request->data['Indicador']['responsavel_realizado'] as $responavelRealizado){
					$this->request->data['IndicadorResponsavelRealizado']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorResponsavelRealizado']['usuario_id'] = $responavelRealizado;	
					$this->IndicadorResponsavelRealizado->save($this->request->data);
					$this->IndicadorResponsavelRealizado->id = null;
				}
				
				$data = array();
				$this->loadModel('IndicadorResponsavelMeta');
				foreach($this->request->data['Indicador']['responsavel_meta'] as $responavelMeta){
					$this->request->data['IndicadorResponsavelMeta']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorResponsavelMeta']['usuario_id'] = $responavelMeta;	
					$this->IndicadorResponsavelMeta->save($this->request->data);
					$this->IndicadorResponsavelMeta->id = null;
				}
				
				$data = array();
				$this->loadModel('IndicadorAutorizadoVisualizar');
				foreach($this->request->data['Indicador']['autorizado_visualizar'] as $autorizadoVisualizar){
					$this->request->data['IndicadorAutorizadoVisualizar']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorAutorizadoVisualizar']['usuario_id'] = $autorizadoVisualizar;	
					$this->IndicadorAutorizadoVisualizar->save($this->request->data);
					$this->IndicadorAutorizadoVisualizar->id = null;
				}
				
				$this->loadModel("IndicadorMeta");
				$this->loadModel("IndicadorRealizado");
				
				$this->Audit->salvar($this->request->data, "Indicador", array(), "adicionar", true, $this->Indicador->id, $this->Auth->user("id"));
				
				foreach($anosAntes as $ano){
					$indices['indicador_id'] = $this->Indicador->id;
					$indices['ano'] = $ano;
					$indices['janeiro'] = 0;
					$indices['fevereiro'] = 0;
					$indices['marco'] = 0;
					$indices['abril'] = 0;
					$indices['maio'] = 0;
					$indices['junho'] = 0;
					$indices['julho'] = 0;
					$indices['agosto'] = 0;
					$indices['setembro'] = 0;
					$indices['outubro'] = 0;
					$indices['novembro'] = 0;
					$indices['dezembro'] = 0;
					$indicadorIndice['IndicadorMeta'] = $indices;
					$indicadorIndice['IndicadorRealizado'] = $indices;
					$this->IndicadorMeta->save($indicadorIndice);
					$this->IndicadorRealizado->save($indicadorIndice);
					$this->IndicadorMeta->id = null;
					$this->IndicadorRealizado->id = null;					
				}
					
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$ordem = array();
		for ($i = 1; $i <= 40; $i++){
			$ordem[$i] = $i;
		}
		
		$indicadores = $this->Indicador->find('list', array('conditions' => array('Indicador.status' => Util::ATIVO), 'fields' => array('Indicador.id', 'Indicador.titulo'), 'order' => array('Indicador.titulo')));
		
		$this->loadModel('Faixa');
		$faixas = $this->Faixa->find('list', array('conditions' => array('Faixa.status' => Util::ATIVO), 'fields' => array('Faixa.id', 'Faixa.titulo'), 'order' => array('Faixa.titulo')));
		
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo'), 'order' => array('Objetivo.titulo')));
		
		$this->loadModel('Projeto');
		$projetos = $this->Projeto->find('list', array('conditions' => array('Projeto.status' => Util::ATIVO), 'fields' => array('Projeto.id', 'Projeto.titulo'), 'order' => array('Projeto.titulo')));
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'), 'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$tiposCalculo = array(Util::TIPO_CALCULO_NEGATIVO => 'Negativo', Util::TIPO_CALCULO_NEGATIVO_NAO_ACUMULATIVO => 'Negativo não acumulativo',
							Util::TIPO_CALCULO_POSITIVO => 'Positivo', Util::TIPO_CALCULO_POSITIVO_NAO_CUMULATIVO => 'Positivo não acumulativo');
		
		$this->set('ordem', $ordem);
		$this->set('indicadores', $indicadores);
		$this->set('faixas', $faixas);
		$this->set('objetivos', $objetivos);
		$this->set('usuarios', $usuarios);
		$this->set('projetos', $projetos);
		$this->set('tiposCalculo', $tiposCalculo);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function editar($id = null) {
		$this->Indicador->id = $id;
		if (!$this->Indicador->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			//Algoritimo para montar a string de anos
			$anos = '';
			foreach($this->request->data['Indicador']['anos'] as $ano){
				$anos .= $ano.',';
			}
			$anos = rtrim($anos, ",");
			$this->request->data['Indicador']['anos'] = $anos;
			//Fim do algoritimo para montar string do ano
			
			if ($this->Indicador->save($this->request->data)) {
				
				$this->Indicador->query("delete from indicador_responsavel_meta where indicador_id = $id");
				$this->Indicador->query("delete from indicador_responsavel_realizado where indicador_id = $id");
				$this->Indicador->query("delete from indicador_autorizado_visualizar where indicador_id = $id");
				
				$data = array();
				$this->loadModel('IndicadorResponsavelRealizado');
				foreach($this->request->data['Indicador']['responsavel_realizado'] as $responavelRealizado){
					$this->request->data['IndicadorResponsavelRealizado']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorResponsavelRealizado']['usuario_id'] = $responavelRealizado;	
					$this->IndicadorResponsavelRealizado->save($this->request->data);
					$this->IndicadorResponsavelRealizado->id = null;
				}
				
				$data = array();
				$this->loadModel('IndicadorResponsavelMeta');
				foreach($this->request->data['Indicador']['responsavel_meta'] as $responavelMeta){
					$this->request->data['IndicadorResponsavelMeta']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorResponsavelMeta']['usuario_id'] = $responavelMeta;	
					$this->IndicadorResponsavelMeta->save($this->request->data);
					$this->IndicadorResponsavelMeta->id = null;
				}
				
				$data = array();
				$this->loadModel('IndicadorAutorizadoVisualizar');
				foreach($this->request->data['Indicador']['autorizado_visualizar'] as $autorizadoVisualizar){
					$this->request->data['IndicadorAutorizadoVisualizar']['indicador_id'] = $this->Indicador->id;
					$this->request->data['IndicadorAutorizadoVisualizar']['usuario_id'] = $autorizadoVisualizar;	
					$this->IndicadorAutorizadoVisualizar->save($this->request->data);
					$this->IndicadorAutorizadoVisualizar->id = null;
				}
				
				$this->Audit->salvar($this->request->data, "Indicador", array(), "editar", false, $id, $this->Auth->user("id"));
				
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}else{
			$this->request->data = $this->Indicador->read(null, $id);
			$this->Audit->setDadosAntes($this->request->data);
		}
		
		$ordem = array();
		for ($i = 1; $i <= 40; $i++){
			$ordem[$i] = $i;
		}
		
		$indicadores = $this->Indicador->find('list', array('conditions' => array('Indicador.status' => Util::ATIVO, 'Indicador.id !=' => $id), 'fields' => array('Indicador.id', 'Indicador.titulo'), 'order' => array('Indicador.titulo')));
		
		$this->loadModel('Faixa');
		$faixas = $this->Faixa->find('list', array('conditions' => array('Faixa.status' => Util::ATIVO), 'fields' => array('Faixa.id', 'Faixa.titulo'), 'order' => array('Faixa.titulo')));
		
		$this->loadModel('Objetivo');
		$objetivos = $this->Objetivo->find('list', array('conditions' => array('Objetivo.status' => Util::ATIVO), 'fields' => array('Objetivo.id', 'Objetivo.titulo'), 'order' => array('Objetivo.titulo')));
		
		
		$this->loadModel('Projeto');
		$projetos = $this->Projeto->find('list', array('conditions' => array('Projeto.status' => Util::ATIVO), 'fields' => array('Projeto.id', 'Projeto.titulo'), 'order' => array('Projeto.titulo')));
		
		$this->loadModel('Usuario');
		//Buscamos pelo metodo find('all') para poder buscar pelos campos dos models da relação
		$usuarios2 = $this->Usuario->find('all', array('conditions' => array('Usuario.status' => Util::ATIVO), 'fields' => array('Usuario.id', 'Pessoa.titulo'), 'order' => array('Pessoa.titulo')));
		$usuarios = array();
		foreach($usuarios2 as $usuario){
			$usuarios[$usuario['Usuario']['id']] = $usuario['Pessoa']['titulo'];
		}
		
		$this->loadModel('IndicadorResponsavelMeta');
		$indicadorResponsavelMeta = $this->IndicadorResponsavelMeta->find('list', array('conditions' => array('indicador_id' => $id), 'fields' => array('usuario_id')));
		
		$this->loadModel('IndicadorResponsavelrealizado');
		$indicadorResponsavelrealizado = $this->IndicadorResponsavelrealizado->find('list', array('conditions' => array('indicador_id' => $id), 'fields' => array('usuario_id')));
		
		$this->loadModel('IndicadorAutorizadoVisualizar');
		$indicadorAutorizadoVisualizar = $this->IndicadorAutorizadoVisualizar->find('list', array('conditions' => array('indicador_id' => $id), 'fields' => array('usuario_id')));
		
		//Inicio do algoritimo para transformar a string de anos em array
		$this->Indicador->read();
		$anos = $this->Indicador->read(null, $id);
		$anos = explode(",", $anos['Indicador']['anos']);
		foreach($anos as $ano){
			$anos2[$ano] = $ano;
		}
		//Fim de algoritimo para tranfirmar a string
		
		$tiposCalculo = array(Util::TIPO_CALCULO_NEGATIVO => 'Negativo', Util::TIPO_CALCULO_NEGATIVO_NAO_ACUMULATIVO => 'Negativo não acumulativo',
							Util::TIPO_CALCULO_POSITIVO => 'Positivo', Util::TIPO_CALCULO_POSITIVO_NAO_CUMULATIVO => 'Positivo não acumulativo');
		
		$this->set('ordem', $ordem);
		$this->set('indicadores', $indicadores);
		$this->set('faixas', $faixas);
		$this->set('objetivos', $objetivos);
		$this->set('projetos', $projetos);
		$this->set('usuarios', $usuarios);
		$this->set('tiposCalculo', $tiposCalculo);
		$this->set('indicadorResponsavelMeta', $indicadorResponsavelMeta);
		$this->set('indicadorResponsavelrealizado', $indicadorResponsavelrealizado);
		$this->set('indicadorAutorizadoVisualizar', $indicadorAutorizadoVisualizar);
		$this->set('anos', $anos2);
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
		$this->Indicador->id = $id;
		if (!$this->Indicador->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->Indicador->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Indicador", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
