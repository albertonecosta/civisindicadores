<?php
/**
 * Ajustes das inflections para português
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link          http://wiki.github.com/jrbasso/cake_ptbr/inflections
 */

// Alteração do inflector
$_uninflected = array(
	'usuario', 'vinculo', 'pessoa_comunicacao', 'pessoa', 'endereco', 'comunicacao', 'cargo', 'grupo',
	'empresa', 'departamento', 'dimensao', 'objetivo', 'projeto', 'objetivo_projeto', 'plano_acao_projeto',
	'acao', 'comentario', 'plano_acao', 'acao_plano_acao', 'indicador', 'faixa', 'indicador_responsavel_realizado',
	'indicador_responsavel_meta', 'indicador_autorizado_visualizar', 'indicador_meta', 'indicador_realizado',
	'anomalia', 'setor', 'procedimento', 'tarefa', 'reuniao', 'reuniao_conhecedor', 'reuniao_participante', 'reuniao_email_externo',
	'organograma', 'post', 'auditoria', 'auditoria_campos', 'aplicacao','patrocinador_projeto','programa','marcador','marcador_objetivo'

);

$_pluralIrregular = array('exemplo' => 'exemplos');

Inflector::rules('singular', array(
	'rules' => array(
		'/^(.*)(oes|aes|aos)$/i' => '\1ao',
		'/^(.*)(a|e|o|u)is$/i' => '\1\2l',
		'/^(.*)e?is$/i' => '\1il',
		'/^(.*)(r|s|z)es$/i' => '\1\2',
		'/^(.*)ns$/i' => '\1m',
		'/^(.*)s$/i' => '\1',
	),
	'uninflected' => $_uninflected,
	'irregular' => array_flip($_pluralIrregular)
), true);

Inflector::rules('plural', array(
	'rules' => array(
		'/^(.*)ao$/i' => '\1oes',
		'/^(.*)(r|s|z)$/i' => '\1\2es',
		'/^(.*)(a|e|o|u)l$/i' => '\1\2is',
		'/^(.*)il$/i' => '\1is',
		'/^(.*)(m|n)$/i' => '\1ns',
		'/^(.*)$/i' => '\1s'
	),
	'uninflected' => $_uninflected,
	'irregular' => $_pluralIrregular
), true);

unset($_uninflected, $_pluralIrregular);