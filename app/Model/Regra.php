<?php
class Regra extends AppModel{
	
	/**
	 * Nome da tabela
	 * @var String
	 */
	var $useTable = "regras";
	
	/**
	 * Relacionamentos belongsTo do módulo
	 * @var array
	 */
	var $belongsTo = array('Permissao');
}