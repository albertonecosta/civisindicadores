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
 * Usuario Model
 *
 * @property Pessoa $Pessoa
 * @property Cargo $Cargo
 * @property Vinculo $Vinculo
 */
class Usuario extends AppModel {
	
	public $actsAs = array(
		'Upload.Upload' => array(
            'imagem_perfil' => array(
            	'fields' => array(
					'dir' => 'diretorio_imagem_perfil'
				),
                'thumbnailSizes' => array(
                    'pequeno' => '45x52',
                    'medio' => '88x120',
                    'grande' => '264x360'
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
		"login"=>array(
			"Obrigatório"=>array(
				"rule"=>"notEmpty",
				"message"=>"Campo login é obrigatório"
			),
            'between' => array(
                'rule' => array('between', 4, 100),
                'message' => 'Login deve conter entre 4 e 100 caracteres'
            ),
			"Unico"=>array(
				"rule"=>"isUnicoLoginAtivo",
				"message"=>"Login inválido, favor informe outro."
			)
		),
		'senha'=>array(
			'Obrigatório'=>array(
				'rule'=>'notEmpty',
				'message'=>'Campo senha é obrigatório'
			),
			'Tamanho Mínimo'=>array(
				'rule' => array('minLength', 6),
				'message'=>'Senha deve ter no mínimo 6 caracteres'
			),
			'Match Passwords'=>array(
				'rule'=>'matchPasswords',
				'message'=>'Confirmação de senha inválida'
			)
		),
		"confirmacao_senha"=>array(
			"Obrigatório"=>array(
				"rule"=>"notEmpty",
				"message"=>"Confirme sua senha"
			)
		),
		'grupo_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Grupo é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cargo_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Cargo é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'vinculo_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Vínculo é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'setor_id' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Setor é obrigatório',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'chefe' => array(
			'Obrigatório' => array(
				'rule' => array('notempty'),
				'message' => 'Campo Chefia é obrigatório',
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
		'Pessoa' => array(
			'className' => 'Pessoa',
			'foreignKey' => 'pessoa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Vinculo' => array(
			'className' => 'Vinculo',
			'foreignKey' => 'vinculo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Grupo' => array(
			'className' => 'Grupo',
			'foreignKey' => 'grupo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Departamento' => array(
			'className' => 'Departamento',
			'foreignKey' => 'departamento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Setor' => array(
			'className' => 'Setor',
			'foreignKey' => 'setor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Endereco' => array(
			'className' => 'Endereco',
			'foreignKey' => 'endereco_id',
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
		'AtividadeResponsavel' => array(
			'className' => 'Atividade',
			'foreignKey' => 'responsavel_id',
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
		'AtividadeSupervisor' => array(
			'className' => 'Atividade',
			'foreignKey' => 'supervisor_id',
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
		'IndicadorResponsavel' => array(
			'className' => 'Indicador',
			'foreignKey' => 'usuario_id',
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
		'IndicadorResponsavelRealizado' => array(
			'className' => 'IndicadorResponsavelRealizado',
			'foreignKey' => 'usuario_id',
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
		'IndicadorResponsavelMeta' => array(
			'className' => 'IndicadorResponsavelMeta',
			'foreignKey' => 'usuario_id',
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
		'IndicadorAutorizadoVisualizar' => array(
			'className' => 'IndicadorAutorizadoVisualizar',
			'foreignKey' => 'usuario_id',
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
		'Procedimento' => array(
			'className' => 'Procedimento',
			'foreignKey' => 'usuario_id',
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
		'ReuniaoParticipante' => array(
			'className' => 'ReuniaoParticipante',
			'foreignKey' => 'usuario_id',
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
		'ReuniaoConhecedor' => array(
			'className' => 'ReuniaoConhecedor',
			'foreignKey' => 'usuario_id',
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
		'TarefaResponsavel' => array(
			'className' => 'Tarefa',
			'foreignKey' => 'responsavel_id',
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
		'TarefaSupervisor' => array(
			'className' => 'Tarefa',
			'foreignKey' => 'supervisor_id',
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
		'ProjetoResponsavel' => array(
			'className' => 'Projeto',
			'foreignKey' => 'usuario_id',
			'dependent' => false,
			'conditions' =>  array("ProjetoResponsavel.status<>'0'"),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'usuario_id',
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
	
	public function isUnicoLoginAtivo($data){
		$arrayLogin = $this->find('list', 
			array(
				'conditions'=>array(
							'status'=>Util::ATIVO,
							'id != '=> (isset($this->data['Usuario']['id'])) ? $this->data['Usuario']['id'] : null), 
				'fields'=>array('Usuario.login')
			)
		);
		foreach($arrayLogin as $login){
			if(strtolower($data['login']) == strtolower($login)){
				return false;
			}
		}
		return true;
	}
	
	public function matchPasswords($data){
		if(Router::getParam('action') == 'adicionar'){
			if($data['senha'] != $this->data['Usuario']['confirmacao_senha']){
				$this->invalidate('confirmacao_senha','Confirmação de senha inválida');
				return false;
			}
		}
		return true;
	}
	
	function beforeSave($data){
		/* caso a ação seja adicionar, aplica a criptografia a senha */
		if(Router::getParam('action') == 'adicionar'){
			if(!empty($this->data['Usuario']['senha'])){
				$this->data['Usuario']['senha'] = AuthComponent::password($this->data['Usuario']['senha']);
			}
		}
		return true;
	}
	
	public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['Usuario']['grupo_id'])) {
            $groupId = $this->data['Usuario']['grupo_id'];
        } else {
            $groupId = $this->field('grupo_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Grupo' => array('id' => $groupId));
        }
    }
    
	public function bindNode($user) {
	    return array('model' => 'Grupo', 'foreign_key' => $user['Usuario']['grupo_id']);
	}
}
