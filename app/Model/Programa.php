<?php
App::uses('AppModel', 'Model');
/**
 * Programa Model
 *
 * @property Usuario $Usuario
 */
class Programa extends AppModel {

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
		'data_inicio' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de início é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'data_fim' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de fim é obrigatório',
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

	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
			'Projeto' => array(
			'className' => 'projeto',
			'foreignKey' => 'programa_id',
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
		if(!empty($this->data['Programa']['data_inicio'])){
			$this->data['Programa']['data_inicio'] = Util::inverteData($this->data['Programa']['data_inicio']);
		}
		if(!empty($this->data['Programa']['data_fim'])){
			$this->data['Programa']['data_fim'] = Util::inverteData($this->data['Programa']['data_fim']);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Programa"])){
				if(isset($model['Programa']['data_inicio'])){
					$results[$key]['Programa']['data_inicio'] = Util::inverteData($model['Programa']['data_inicio']);
				}
				if(isset($model['Programa']['data_fim'])){
					$results[$key]['Programa']['data_fim'] = Util::inverteData($model['Programa']['data_fim']);
				}

			}
			
		}
		return $results;
	}

}
