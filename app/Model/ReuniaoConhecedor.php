<?php
App::uses('AppModel', 'Model');
/**
 * ReuniaoConhecedor Model
 *
 * @property Usuario $Usuario
 */
class ReuniaoConhecedor extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Reuniao' => array(
			'className' => 'Reuniao',
			'foreignKey' => 'reuniao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Participante' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
