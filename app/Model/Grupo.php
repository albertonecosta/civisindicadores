<?php
App::uses('AppModel', 'Model');
/**
 * PessoaComunicacao Model
 *
 * @property Pessoa $Pessoa
 * @property Comunicacao $Comunicacao
 */
class Grupo extends AppModel {

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
		)
	);	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Permissao',
		'PessoaComunicacao' => array(
			'className' => 'Usuario',
			'foreignKey' => 'grupo_id',
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
