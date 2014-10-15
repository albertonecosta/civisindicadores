<?php
App::uses('AppModel', 'Model');
/**
 * Projeto Model
 *
 * @property Usuario $Usuario
 */
class Projeto extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'titulo' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo titulo é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'processo' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Código do Projeto é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usuario_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo responsável é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_inicio_previsto' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de início é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_fim_previsto' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de fim é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_inicio_previsto' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de início é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'concluido' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo projeto terminado é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
			'Responsavel' => array(
							'className' => 'Usuario',
							'foreignKey' => 'usuario_id',
							'conditions' => '',
							'fields' => '',
							'order' => ''),
			'Programa' => array(
					'className' => 'Programa',
					'foreignKey' => 'programa_id',
					'conditions' => '',
					'fields' => '',
					'order' => '')
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ObjetivoProjeto' => array(
			'className' => 'ObjetivoProjeto',
			'foreignKey' => 'projeto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PlanoAcaoProjeto' => array(
			'className' => 'PlanoAcaoProjeto',
			'foreignKey' => 'projeto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Reuniao' => array(
			'className' => 'Reuniao',
			'foreignKey' => 'projeto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Acao' => array(
			'className' => 'Acao',
			'foreignKey' => 'projeto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('Acao.data_inicio_previsto','Acao.marco','Acao.titulo'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),'PatrocinadorProjeto' => array(
			'className' => 'PatrocinadorProjeto',
			'foreignKey' => 'projeto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function beforeSave($options){
			
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Projeto']['data_inicio_previsto'])){
			$this->data['Projeto']['data_inicio_previsto'] = Util::inverteData($this->data['Projeto']['data_inicio_previsto']);
		}
		if(!empty($this->data['Projeto']['data_fim_previsto'])){
			$this->data['Projeto']['data_fim_previsto'] = Util::inverteData($this->data['Projeto']['data_fim_previsto']);
		}
		if(!empty($this->data['Projeto']['data_conclusao'])){
			$this->data['Projeto']['data_conclusao'] = Util::inverteData($this->data['Projeto']['data_conclusao']);
		}
		if(!empty($this->data['Projeto']['data_ultima_atualizacao'])){
			$this->data['Projeto']['data_ultima_atualizacao'] = Util::inverteData($this->data['Projeto']['data_ultima_atualizacao']);
		}
		if(isset($this->data['Projeto']["custo"]) && !empty($this->data['Projeto']["custo"])){
			$valor = str_replace(".", "", $this->data['Projeto']["custo"]);
			$this->data['Projeto']["custo"] = str_replace(",", ".", $valor);
		}
		
		if(isset($this->data['Projeto']["gasto"]) && !empty($this->data['Projeto']["gasto"])){
			$valor = str_replace(".", "", $this->data['Projeto']["gasto"]);
			$this->data['Projeto']["gasto"] = str_replace(",", ".", $valor);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Projeto"])){
				if(isset($model['Projeto']['data_inicio_previsto'])){
					$results[$key]['Projeto']['data_inicio_previsto'] = Util::inverteData($model['Projeto']['data_inicio_previsto']);
				}
				if(isset($model['Projeto']['data_fim_previsto'])){
					$results[$key]['Projeto']['data_fim_previsto'] = Util::inverteData($model['Projeto']['data_fim_previsto']);
				}
				if(isset($model['Projeto']['data_conclusao'])){
					$results[$key]['Projeto']['data_conclusao'] = Util::inverteData($model['Projeto']['data_conclusao']);
				}
				if(isset($model['Projeto']['data_ultima_atualizacao'])){
					$results[$key]['Projeto']['data_ultima_atualizacao'] = Util::inverteData($model['Projeto']['data_ultima_atualizacao']);
				}
				if(isset($model['Projeto']["custo"])){
					$results[$key]['Projeto']["custo"] = number_format($model['Projeto']["custo"], 2,',','.');
				}
				
				if(isset($model['Projeto']["gasto"])){
					$results[$key]['Projeto']["gasto"] = number_format($model['Projeto']["gasto"], 2,',','.');
				}
			}
			
		}
		return $results;
	}

}
