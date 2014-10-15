<?php
App::uses('AppModel', 'Model');
/**
 * MarcadorObjetivo Model
 *
 * @property MarcadorObjetivo $MarcadorObjetivo
 */
class MarcadorObjetivo extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $useTable = "marcador_objetivo";

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
			'Marcador' => array(
				'className' => 'Marcador',
				'foreignKey' => 'marcador_id',
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
		)
	);
}
