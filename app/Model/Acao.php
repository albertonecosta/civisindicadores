<?php
App::uses('AppModel', 'Model');
/**
 * Acao Model
 *
 * @property Usuario $Usuario
 */
class Acao extends AppModel {

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
		'responsavel_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo responsável é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'supervisor_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo supervisor é obrigatório',
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
		'concluido' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Concluido é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'marco' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Marco é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Status é obrigatório',
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
			'foreignKey' => 'responsavel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Supervisor' => array(
			'className' => 'Usuario',
			'foreignKey' => 'supervisor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pai' => array(
			'className' => 'Acao',
			'foreignKey' => 'acao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Anomalia' => array(
			'className' => 'Anomalia',
			'foreignKey' => 'anomalia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Medida' => array(
			'className' => 'Objetivo',
			'foreignKey' => 'objetivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Filho' => array(
			'className' => 'Acao',
			'foreignKey' => 'acao_id',
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
		if(!empty($this->data['Acao']['data_inicio_previsto'])){
			$this->data['Acao']['data_inicio_previsto'] = Util::inverteData($this->data['Acao']['data_inicio_previsto']);
		}
		if(!empty($this->data['Acao']['data_fim_previsto'])){
			$this->data['Acao']['data_fim_previsto'] = Util::inverteData($this->data['Acao']['data_fim_previsto']);
		}
		if(!empty($this->data['Acao']['data_conclusao'])){
			$this->data['Acao']['data_conclusao'] = Util::inverteData($this->data['Acao']['data_conclusao']);
		}
		if(!empty($this->data['Acao']['lembrete'])){
			$this->data['Acao']['lembrete'] = Util::inverteData($this->data['Acao']['lembrete']);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Acao"])){
				if(isset($model['Acao']['data_inicio_previsto'])){
					$results[$key]['Acao']['data_inicio_previsto'] = Util::inverteData($model['Acao']['data_inicio_previsto']);
				}
				if(isset($model['Acao']['data_fim_previsto'])){
					$results[$key]['Acao']['data_fim_previsto'] = Util::inverteData($model['Acao']['data_fim_previsto']);
				}
				if(isset($model['Acao']['data_conclusao'])){
					$results[$key]['Acao']['data_conclusao'] = Util::inverteData($model['Acao']['data_conclusao']);
				}
				if(isset($model['Acao']['lembrete'])){
					$results[$key]['Acao']['lembrete'] = Util::inverteData($model['Acao']['lembrete']);
				}
			}
			
		}
		return $results;
	}

}
