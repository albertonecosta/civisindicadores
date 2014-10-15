<?php
App::uses('AppModel', 'Model');
/**
 * Reuniao Model
 *
 * @property Usuario $Usuario
 */
class Reuniao extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'titulo' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Título é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'local' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Local é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Data é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pauta' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Pauta é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hora_inicio' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Hora de início é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hora_fim' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Hora final é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ReuniaoParticipante' => array(
			'className' => 'ReuniaoParticipante',
			'foreignKey' => 'reuniao_id',
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
		'ReuniaoConhecedor' => array(
			'className' => 'ReuniaoConhecedor',
			'foreignKey' => 'reuniao_id',
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
		'ReuniaoEmailExterno' => array(
			'className' => 'ReuniaoEmailExterno',
			'foreignKey' => 'reuniao_id',
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
		'Tarefa' => array(
			'className' => 'Tarefa',
			'foreignKey' => 'reuniao_id',
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
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function beforeSave($options){
			
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Reuniao']['data'])){
			$this->data['Reuniao']['data'] = Util::inverteData($this->data['Reuniao']['data']);
		}
	}

	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Reuniao"])){
				if(isset($model['Reuniao']['data'])){
					$results[$key]['Reuniao']['data'] = Util::inverteData($model['Reuniao']['data']);
				}
			}			
		}
		return $results;
	}

}
