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
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo $this->Html->charset(); ?>
		<title>
			Civis Indicadores
		</title>
		<?php
			//echo $this->Html->meta('icon');
			
			echo $this->fetch('meta');
			echo $this->Html->css('bootstrap.min');
			//echo $this->Html->css('bootstrap-cerulean.min');
			echo $this->Html->css('bootstrap-responsive.min');
			echo $this->Html->css('cake.generic');
			echo $this->Html->css('footable.core');
			echo $this->Html->css('jquery-ui.min');
			echo $this->Html->css('dhtmlxgantt');
			
			echo $this->Html->css('plugins/treetable/stylesheets/jquery.treetable.theme.default.css');
			echo $this->Html->css('plugins/treetable/stylesheets/jquery.treetable.css');
			echo $this->Html->css('plugins/lwMultiSelect/jquery.lwMultiSelect.css');
			echo $this->Html->css('gantt');
			
			echo $this->Html->css('core');
			echo $this->fetch('css');
			
			echo $this->Html->script('libs/jquery');
			echo $this->Html->script('libs/footable');
			echo $this->Html->script('libs/jquery-ui.min');
			echo $this->Html->script('plugins/treetable/javascripts/src/jquery.treetable.js');
			echo $this->Html->script('libs/jquery.lwMultiSelect.min');
			echo $this->Html->script('libs/dhtmlxgantt');
			echo $this->Html->script('libs/dhtmlxgantt.locale.js');
			echo $this->Html->script('libs/jquery.fn.gantt.js');
			
		?>	
	</head>

	<body>
		<div class="navbar navbar-fixed-top" style="position:relative; !important;">
	      <div class="navbar-inner">
	        <div class="container">
	          <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="brand" href="./index.html">Civis Indicadores</a>
	          <div class="nav-collapse collapse" style="height: 0px;">
	            <ul class="nav">
	              <?php if($this->Permissions->check('Reuniao.index') || 
	              			$this->Permissions->check('Tarefa.index') || 
							$this->Permissions->check('Procedimento.index')){ ?>
	              <li class="dropdown">
	                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                	Comunicação
				        <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li>
				      	<?php if($this->Permissions->check('Reuniao.index')){
				      			echo $this->Html->link(__('Reuniões'), array('controller' => 'Reuniao','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Tarefa.index')){
				      			echo $this->Html->link(__('Tarefas'), array('controller' => 'Tarefa','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Procedimento.index')){
				      			echo $this->Html->link(__('Procedimentos'), array('controller' => 'Procedimento','action' => 'index'));
						}?>
					  </li>

				    </ul>
	              </li>
	              <?php } ?>
	              <?php if($this->Permissions->check('Usuario.index') || 
	              			$this->Permissions->check('Empresa.index') || 
							$this->Permissions->check('Grupo.index') ||
							$this->Permissions->check('Cargo.index') ||
							$this->Permissions->check('Vinculo.index') ||
							$this->Permissions->check('Setor.index') ||
							$this->Permissions->check('Departamento.index') ||
							$this->Permissions->check('Dimensao.index') ||
							$this->Permissions->check('Objetivo.index') ||
							$this->Permissions->check('Acao.index') ||
							$this->Permissions->check('PlanoAcao.index') ||
							$this->Permissions->check('Faixa.index') ||
							$this->Permissions->check('Anomalia.index')){ ?>
	              <li class="dropdown">
	                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                	Cadastros
				        <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li>
				      	<?php if($this->Permissions->check('Usuario.index')){
				      		echo $this->Html->link(__('Usuários'), array('controller' => 'Usuario','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Empresa.index')){
				      		echo $this->Html->link(__('Empresas'), array('controller' => 'Empresa','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Grupo.index')){
				      		echo $this->Html->link(__('Grupos'), array('controller' => 'Grupo','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Cargo.index')){
				      		echo $this->Html->link(__('Cargos'), array('controller' => 'Cargo','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Vinculo.index')){
				      		echo $this->Html->link(__('Vinculos'), array('controller' => 'Vinculo','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Setor.index')){
				      		echo $this->Html->link(__('Setores'), array('controller' => 'Setor','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Departamento.index')){
				      		echo $this->Html->link(__('Departamentos'), array('controller' => 'Departamento','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Dimensao.index')){
				      		echo $this->Html->link(__('Dimensões'), array('controller' => 'Dimensao','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Objetivo.index')){
				      		echo $this->Html->link(__('Objetivos'), array('controller' => 'Objetivo','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Acao.index')){
				      		echo $this->Html->link(__('Ações'), array('controller' => 'Acao','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('PlanoAcao.index')){
				      		echo $this->Html->link(__('Planos de Ação'), array('controller' => 'PlanoAcao','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Faixa.index')){
				      		echo $this->Html->link(__('Faixas'), array('controller' => 'Faixa','action' => 'index'));
						}?>
				      </li>
				      <li>
				      	<?php if($this->Permissions->check('Anomalia.index')){
				      		echo $this->Html->link(__('Anomalia'), array('controller' => 'Anomalia','action' => 'index'));
						}?>
				      </li>
				    </ul>
	              </li>
	              <?php } ?>
	              <li class="">
	              	<?php if($this->Permissions->check('Projeto.index')){
			      		echo $this->Html->link(__('Projetos'), array('controller' => 'Projeto','action' => 'index'));
					}?>
	              </li>
	              <li class="">
	              	<?php if($this->Permissions->check('Indicador.index')){
			      		echo $this->Html->link(__('Indicadores'), array('controller' => 'Indicador','action' => 'index'));
					}?>
	              </li>
	              <li class="">
	              	<?php if($this->Permissions->check('MapaEstrategico.index')){
			      		echo $this->Html->link(__('Mapa estratégico'), array('controller' => 'MapaEstrategico','action' => 'index'));
					}?>
	              </li>
	              <li class="">
	              	<?php if($this->Permissions->check('Organograma.index')){
			      		echo $this->Html->link(__('Organograma'), array('controller' => 'Organograma','action' => 'index'));
					}?>
	              </li>
	              <li class="">
	              	<?php if(isset($_SESSION['Auth']['User']['id'])){
			      		echo $this->Html->link(__('Log'), array('controller' => 'Auditoria','action' => 'index'));
					}?>
	              </li>
	              <li class="">
	              	<?php if(isset($_SESSION['Auth']['User']['id'])){
			      		echo $this->Html->link(__('Logout'), array('controller' => 'Usuario','action' => 'logout'));
					}?>
	              </li>	              
	            </ul>
	          </div>
	        </div>
	      </div>
	    </div>
		
		<div class="container">
			<?php echo $this->Session->flash(); ?>
		</div>
		<?php 
		echo $this->fetch('content');		
		echo $this->Html->script('libs/jquery.maskedinput');
		echo $this->Html->script('libs/jquery.maskMoney');
		echo $this->Html->script('libs/bootstrap.min');
		echo $this->Html->script('libs/geral');
		
		echo $this->fetch('script');
		echo $this->Js->writeBuffer(); // note: write cached scripts 
		?>
		
	</body>

</html>