<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
/**
 * EsqueciSenha Model
 *
 */
class EsqueciSenha extends AppModel {

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'esqueci_senha';

	/**
	 * hasMany
	 * 
	 */
	public $belongsTo = array('Usuario');

	/**
	 * Método responsável por verificar se o email passado existe e retornar o id do usuario caso exista o email
	 * @param String $email
	 * @throws Exception
	 * @access public
	 */
	public function verificaEmail($email){
		
		$this->Usuario->recursive = 0;
		$retorno = $this->Usuario->find('first',array('fields' => 'Usuario.id','conditions'=>array('Pessoa.email'=>$email)));
		return count($retorno) ? $retorno['Usuario']['id'] : false;
	}

	/**
	 * Método responsável por salvar uma solicitação de nova senha
	 * @param Integer $id
	 * @throws Exception
	 * @access public
	 */
	public function registraSolicitacaoSenha($id){
		$hash = Security::hash(String::uuid(),'sha1',true);
		$data = array(
			'usuario_id' => $id,
			'hash' => $hash,
			'data' => date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 1, date('Y'))),
			'ativo' => true
		);
		return ($this->save($data)) ? $hash : false;
	}

	public function desativaSolicitacaoSenha(){
		
	}
}
