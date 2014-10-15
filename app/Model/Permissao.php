<?php
class Permissao extends AppModel{
	
	/**
	 * Nome da tabela
	 * @var String
	 */
	var $useTable = "permissoes";
	
	/**
	 * Relacionamentos belongsTo do módulo
	 * @var array
	 */
	var $belongsTo = array('Grupo');
	
	/**
	 * Relacionamentos hasMany do módulo
	 * @var array
	 */
	var $hasMany = array('Regra');
	
}