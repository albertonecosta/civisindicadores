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
 * Objetivo Model
 *
 * @property Usuario $Usuario
 */
class Medida extends AppModel {

	var $useTable = "objetivo";
	
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
 		'ordem' => array(
 				'Obrigatório' => array(
 						'rule' => array('notempty'),
 						'message' => 'Campo ordem é obrigatório',
 						//'allowEmpty' => false,
 						//'required' => false,
 						//'last' => false, // Stop validation after this rule
 						//'on' => 'create', // Limit validation to 'create' or 'update' operations
 				),
 		),
 		'ano' => array(
 				'Obrigatório' => array(
 						'rule' => array('notempty'),
 						'message' => 'Campo ano é obrigatório',
 						//'allowEmpty' => false,
 						//'required' => false,
 						//'last' => false, // Stop validation after this rule
 						//'on' => 'create', // Limit validation to 'create' or 'update' operations
 				),
 		),
 		'dimensao_id' => array(
 				'Obrigatório' => array(
 						'rule' => array('notempty'),
 						'message' => 'Campo dimensão é obrigatório',
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
 		'Dimensao' => array(
 				'className' => 'Dimensao',
 				'foreignKey' => 'dimensao_id',
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
 		'PlanoAcao' => array(
 				'className' => 'PlanoAcao',
 				'foreignKey' => 'objetivo_id',
 				'dependent' => false,
 				'conditions' => '',
 				'fields' => '',
 				'order' => '',
 				'limit' => '',
 				'offset' => '',
 				'exclusive' => '',
 				'finderQuery' => '',
 				'counterQuery' => ''
 		),
 		'Indicador' => array(
 				'className' => 'Indicador',
 				'foreignKey' => 'objetivo_id',
 				'dependent' => false,
 				'conditions' => '',
 				'fields' => '',
 				'order' => '',
 				'limit' => '',
 				'offset' => '',
 				'exclusive' => '',
 				'finderQuery' => '',
 				'counterQuery' => ''
 		),
 		'Acao' => array(
 				'className' => 'Acao',
 				'foreignKey' => 'objetivo_id',
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
	
	
}
