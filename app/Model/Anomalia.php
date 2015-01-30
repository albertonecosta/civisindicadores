<?php
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
 *
 */
App::uses('AppModel', 'Model');
/**
 * Anomalia Model
 *
 * @property Anomalia $Anomalia
 */
class Anomalia extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'identificacao_problema' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo identificação do problema é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'estratificacao_problema' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo extratificacao do problema é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo data é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'indicador_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo indicador é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Indicador' => array(
			'className' => 'Indicador',
			'foreignKey' => 'indicador_id',
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
		'Atividade' => array(
			'className' => 'Atividade',
			'foreignKey' => 'anomalia_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Atividade.data_inicio_previsto',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function beforeSave($options){
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Anomalia']['data'])){
			$this->data['Anomalia']['data'] = Util::inverteData($this->data['Anomalia']['data']);
		}
		
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Anomalia"])){
				if(isset($model['Anomalia']['data'])){
					$results[$key]['Anomalia']['data'] = Util::inverteData($model['Anomalia']['data']);
				}
				
			}
			
		}
		return $results;
	}
}
