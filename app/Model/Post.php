<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property Usuario $Usuario
 */
class Post extends AppModel {

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
		),
		'mensagem' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo mensagem é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Filhos' => array(
			'className' => 'Post',
			'foreignKey' => 'post_id',
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
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Acao' => array(
			'className' => 'Acao',
			'foreignKey' => 'acao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pai' => array(
			'className' => 'Post',
			'foreignKey' => 'post_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Post"])){
				if(isset($model['Post']['created'])){
					$results[$key]['Post']['created'] = Util::inverteData($model['Post']['created']);
				}
				if(isset($model['Post']['modified'])){
					$results[$key]['Post']['modified'] = Util::inverteData($model['Post']['modified']);
				}
			}
			
		}
		return $results;
	}

}
