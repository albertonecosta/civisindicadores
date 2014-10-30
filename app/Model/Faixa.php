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
 * Faixa Model
 *
 * @property Usuario $Usuario
 */
class Faixa extends AppModel {

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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Indicador' => array(
			'className' => 'Indicador',
			'foreignKey' => 'faixa_id',
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
	
	public function beforeSave($options){
		
		if(isset($this->data['Faixa']["limite_vermelho"]) && !empty($this->data['Faixa']["limite_vermelho"])){
			$valor = str_replace(".", "", $this->data['Faixa']["limite_vermelho"]);
			$this->data['Faixa']["limite_vermelho"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['Faixa']["limite_amarelo"]) && !empty($this->data['Faixa']["limite_amarelo"])){
			$valor = str_replace(".", "", $this->data['Faixa']["limite_amarelo"]);
			$this->data['Faixa']["limite_amarelo"] = str_replace(",", ".", $valor);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["Faixa"])){
				if(isset($model['Faixa']["limite_vermelho"])){
					$results[$key]['Faixa']["limite_vermelho"] = number_format($model['Faixa']["limite_vermelho"], 2,',','.');
				}
				if(isset($model['Faixa']["limite_amarelo"])){
					$results[$key]['Faixa']["limite_amarelo"] = number_format($model['Faixa']["limite_amarelo"], 2,',','.');
				}
			}
			
		}
		return $results;
	}

}
