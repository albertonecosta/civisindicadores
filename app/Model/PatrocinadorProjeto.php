<?php
App::uses('AppModel', 'Model');
/**
 * PatrocinadorProjeto Model
 *
 * @property Usuario $Usuario
 */
class PatrocinadorProjeto extends AppModel {

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
		'Pessoa' => array(
				'className' => 'Pessoa',
				'foreignKey' => 'pessoa_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);

}
