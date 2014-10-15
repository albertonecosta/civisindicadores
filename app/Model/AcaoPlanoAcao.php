<?php
App::uses('AppModel', 'Model');
/**
 * PlanoAcao Model
 *
 * @property Usuario $Usuario
 */
class AcaoPlanoAcao extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PlanoAcao' => array(
			'className' => 'PlanoAcao',
			'foreignKey' => 'plano_acao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Acao' => array(
			'className' => 'Acao',
			'foreignKey' => 'acao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
