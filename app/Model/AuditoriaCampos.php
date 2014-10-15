<?php
App::uses('AppModel', 'Model');
/**
 * AuditoriaCampos Model
 *
 * @property Usuario $Usuario
 */
class AuditoriaCampos extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Auditoria' => array(
			'className' => 'Auditoria',
			'foreignKey' => 'auditoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
