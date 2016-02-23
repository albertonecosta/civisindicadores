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
App::uses('Projeto', 'Model');

/**
 * Atividade Model
 *
 * @property Usuario $Usuario
 */
class Atividade extends AppModel {

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
		'responsavel_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo responsável é obrigatório',
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
		'marco' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Marco é obrigatório',
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
		'Pai' => array(
			'className' => 'Atividade',
			'foreignKey' => 'atividade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Anomalia' => array(
			'className' => 'Anomalia',
			'foreignKey' => 'anomalia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AcaoEstrategica' => array(
			'className' => 'AcaoEstrategica',
			'foreignKey' => 'objetivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Filho' => array(
			'className' => 'Atividade',
			'foreignKey' => 'atividade_id',
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
	 * Salva 
	 * 
	 * (non-PHPdoc)
	 * @see Model::afterSave()
	 */
	public function afterSave($created){

		if (@$this->data["Atividade"]["projeto_id"]){
		
			$atividades = $this->find("all",array("conditions"=>array('Atividade.projeto_id'=> $this->data["Atividade"]["projeto_id"],'Atividade.status !='=> Util::INATIVO)));
			$andamento=0;
			$cont=0;
			foreach($atividades as $campos){
				
				$andamento += str_replace("%","",$campos["Atividade"]["andamento"]);
				$cont++;
				
			}
			$media = $andamento/$cont;
			$projeto = new Projeto();
			$projeto->id = $this->data["Atividade"]["projeto_id"];
			$projeto->saveField("andamento", $media);
				
		}
	
		
		
	}
	
	public function beforeSave($options){
			
		/* Deixa a data em formato americano antes de salvar na base */
		if(!empty($this->data['Atividade']['data_inicio_previsto'])){
			$this->data['Atividade']['data_inicio_previsto'] = Util::inverteData($this->data['Atividade']['data_inicio_previsto']);
		}
		if(!empty($this->data['Atividade']['data_fim_previsto'])){
			$this->data['Atividade']['data_fim_previsto'] = Util::inverteData($this->data['Atividade']['data_fim_previsto']);
		}
		if(!empty($this->data['Atividade']['data_conclusao'])){
			$this->data['Atividade']['data_conclusao'] = Util::inverteData($this->data['Atividade']['data_conclusao']);
		}
		if(!empty($this->data['Atividade']['lembrete'])){
			$this->data['Atividade']['lembrete'] = Util::inverteData($this->data['Atividade']['lembrete']);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Atividade"])){
				if(isset($model['Atividade']['data_inicio_previsto'])){
					$results[$key]['Atividade']['data_inicio_previsto'] = Util::inverteData($model['Atividade']['data_inicio_previsto']);
				}
				if(isset($model['Atividade']['data_fim_previsto'])){
					$results[$key]['Atividade']['data_fim_previsto'] = Util::inverteData($model['Atividade']['data_fim_previsto']);
				}
				if(isset($model['Atividade']['data_conclusao'])){
					$results[$key]['Atividade']['data_conclusao'] = Util::inverteData($model['Atividade']['data_conclusao']);
				}
				if(isset($model['Atividade']['lembrete'])){
					$results[$key]['Atividade']['lembrete'] = Util::inverteData($model['Atividade']['lembrete']);
				}
			}
			
		}
		return $results;
	}

}
