<?php
App::uses('AppModel', 'Model');
/**
 * Anomalia Model
 *
 * @property Anomalia $Anomalia
 */
class Anomalia extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'identificacao_problema' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo identificação do problema é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'estratificacao_problema' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo extratificacao do problema é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'indicador_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo indicador é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Concluído é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Indicador' => array(
			'className' => 'Indicador',
			'foreignKey' => 'indicador_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Acao' => array(
			'className' => 'Acao',
			'foreignKey' => 'anomalia_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Acao.data_inicio_previsto',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function beforeSave($options){
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Anomalia']['data'])){
			$this->data['Anomalia']['data'] = Util::inverteData($this->data['Anomalia']['data']);
		}
		if(!empty($this->data['Anomalia']['data_conclusao'])){
			$this->data['Anomalia']['data_conclusao'] = Util::inverteData($this->data['Anomalia']['data_conclusao']);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Anomalia"])){
				if(isset($model['Anomalia']['data'])){
					$results[$key]['Anomalia']['data'] = Util::inverteData($model['Anomalia']['data']);
				}
				if(isset($model['Anomalia']['data_conclusao'])){
					$results[$key]['Anomalia']['data_conclusao'] = Util::inverteData($model['Anomalia']['data_conclusao']);
				}
			}
			
		}
		return $results;
	}
}
