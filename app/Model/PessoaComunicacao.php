<?php
App::uses('AppModel', 'Model');
/**
 * PessoaComunicacao Model
 *
 * @property Pessoa $Pessoa
 * @property Comunicacao $Comunicacao
 */
class PessoaComunicacao extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pessoa' => array(
			'className' => 'Pessoa',
			'foreignKey' => 'pessoa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Comunicacao' => array(
			'className' => 'Comunicacao',
			'foreignKey' => 'comunicacao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
