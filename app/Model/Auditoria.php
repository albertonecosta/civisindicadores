<?php
App::uses('AppModel', 'Model');
/**
 * Auditoria Model
 *
 * @property Usuario $Usuario
 */
class Auditoria extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
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
		'AuditoriaCampos' => array(
			'className' => 'AuditoriaCampos',
			'foreignKey' => 'auditoria_id',
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
