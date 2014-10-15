<?php
App::uses('AppModel', 'Model');
/**
 * ObjetivoProjeto Model
 *
 * @property Usuario $Usuario
 */
class ObjetivoProjeto extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		),
		'Objetivo' => array(
			'className' => 'Objetivo',
			'foreignKey' => 'objetivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
