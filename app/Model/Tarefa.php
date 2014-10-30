<?php
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */
App::uses('AppModel', 'Model');
/**
 * Tarefa Model
 *
 * @property Usuario $Usuario
 */
class Tarefa extends AppModel {
	
	public $actsAs = array(
		'Upload.Upload' => array(
			'arquivo' => array(
				'fields' => array(
					'dir' => 'arquivo_dir'
				)
			)
		)
	);

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
		'supervisor_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo supervisor é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_inicio_previsto' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de início é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_fim_previsto' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data de fim é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'concluido' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Concluido é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'prioridade' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Prioridade é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'responsavel_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Responsável é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Status é obrigatório',
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
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'tarefa_id',
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
		'Responsavel' => array(
			'className' => 'Usuario',
			'foreignKey' => 'responsavel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Supervisor' => array(
			'className' => 'Usuario',
			'foreignKey' => 'supervisor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Reuniao' => array(
			'className' => 'Reuniao',
			'foreignKey' => 'reuniao_id',
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
	
	
	public function beforeSave($options){
			
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Tarefa']['data_inicio_previsto'])){
			$this->data['Tarefa']['data_inicio_previsto'] = Util::inverteData($this->data['Tarefa']['data_inicio_previsto']);
		}
		if(!empty($this->data['Tarefa']['data_fim_previsto'])){
			$this->data['Tarefa']['data_fim_previsto'] = Util::inverteData($this->data['Tarefa']['data_fim_previsto']);
		}
		if(!empty($this->data['Tarefa']['data_conclusao'])){
			$this->data['Tarefa']['data_conclusao'] = Util::inverteData($this->data['Tarefa']['data_conclusao']);
		}
		if(!empty($this->data['Tarefa']['lembrete'])){
			$this->data['Tarefa']['lembrete'] = Util::inverteData($this->data['Tarefa']['lembrete']);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Tarefa"])){
				if(isset($model['Tarefa']['data_inicio_previsto'])){
					$results[$key]['Tarefa']['data_inicio_previsto'] = Util::inverteData($model['Tarefa']['data_inicio_previsto']);
				}
				if(isset($model['Tarefa']['data_fim_previsto'])){
					$results[$key]['Tarefa']['data_fim_previsto'] = Util::inverteData($model['Tarefa']['data_fim_previsto']);
				}
				if(isset($model['Tarefa']['data_conclusao'])){
					$results[$key]['Tarefa']['data_conclusao'] = Util::inverteData($model['Tarefa']['data_conclusao']);
				}
				if(isset($model['Tarefa']['lembrete'])){
					$results[$key]['Tarefa']['lembrete'] = Util::inverteData($model['Tarefa']['lembrete']);
				}
			}
			
		}
		return $results;
	}

}
