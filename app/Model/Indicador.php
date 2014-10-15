<?php
App::uses('AppModel', 'Model');
/**
 * Indicador Model
 *
 * @property Indicador $Indicador
 */
class Indicador extends AppModel {

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
		'faixa_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo faixa é obrigatório',
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
		'calculo' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo cálculo é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ordem' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo ordem é obrigatório',
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
		'Objetivo' => array(
			'className' => 'Objetivo',
			'foreignKey' => 'objetivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pai' => array(
			'className' => 'Indicador',
			'foreignKey' => 'indicador_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Faixa' => array(
			'className' => 'Faixa',
			'foreignKey' => 'faixa_id',
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
		'Responsavel' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
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
		'Filhos' => array(
			'className' => 'Indicador',
			'foreignKey' => 'indicador_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'ordem ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'IndicadorResponsavelRealizado' => array(
			'className' => 'IndicadorResponsavelRealizado',
			'foreignKey' => 'indicador_id',
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
		'IndicadorResponsavelMeta' => array(
			'className' => 'IndicadorResponsavelMeta',
			'foreignKey' => 'indicador_id',
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
		'IndicadorMeta' => array(
			'className' => 'IndicadorMeta',
			'foreignKey' => 'indicador_id',
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
		'IndicadorRealizado' => array(
			'className' => 'IndicadorRealizado',
			'foreignKey' => 'indicador_id',
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
		'Anomalia' => array(
			'className' => 'Anomalia',
			'foreignKey' => 'indicador_id',
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
		'IndicadorAutorizadoVisualizar' => array(
			'className' => 'IndicadorAutorizadoVisualizar',
			'foreignKey' => 'indicador_id',
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

}
