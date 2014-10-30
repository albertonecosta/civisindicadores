<?php
/**
 * 
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA

 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="uft-8">
	<title> Civis Estratégia
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->fetch('meta');
		echo $this->Html->css(array('bootstrap.min',
									'bootstrap-responsive.min',
									'cake.generic',
									'footable.core',
									'jquery-ui.min',
									'plugins/treetable/stylesheets/jquery.treetable.theme.default.css',
									'plugins/treetable/stylesheets/jquery.treetable.css',
									'plugins/lwMultiSelect/jquery.lwMultiSelect.css',
									'dhtmlxgantt',
									'slickmap',
									'gantt',
									'core',
									'font-awesome',
									'main'));
		//echo $this->Html->css('bootstrap-cerulean.min');
		echo $this->fetch('css');
		echo $this->Html->script(array('libs/jquery',
			  						   'libs/footable',
			  						   'libs/jquery-ui.min',
			  						   'plugins/treetable/javascripts/src/jquery.treetable.js'));
		
	?>