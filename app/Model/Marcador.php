<?php
App::uses('AppModel', 'Model');
/**
 * Marcador Model
 *
 * @property Marcador $Marcador
 */
class Marcador extends AppModel {
	
	var $useTable = "marcador";

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
		'MarcadorObjetivo'
	);
	
	

}
