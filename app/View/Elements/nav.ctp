<?php
/**
 * 
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 * 
 **/
	// Verificando configuraçoes para liberação do menu
	
	// COMUNICAÇÃO
	$isReuniao = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Reuniao');
	$isTarefa = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Tarefa');
	$isMarcador = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Marcador');
	$isProcedimento = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Procedimento');
	$isCOMUNICACAO = ($isReuniao || $isTarefa || $isMarcador || $isProcedimento);
	
	// CADASTROS
	$isUsuario = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Usuario');
	$isEmpresa = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Empresa');
	$isGrupo = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Grupo');
	$isCargo = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Cargo');
	$isVinculo = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Vinculo');
	$isSetor = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Setor');
	$isDepartamento = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Departamento');
	$isCADASTROS = ($isUsuario || $isEmpresa || $isGrupo || $isCargo || $isVinculo || $isSetor || $isDepartamento);
	
	
	// GESTÃO ESTRATÉGICA
	$isDimensao = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Dimensao');
	$isObjetivo = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Objetivo');
	$isIndicador = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Indicador');
	$isMedida = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Medida');
	$isMedidaRevisao = $this->ControleDeAcesso->validaAcessoElemento('listar_revisao', 'Medida');
	$isMedidaPainel = $this->ControleDeAcesso->validaAcessoElemento('listar_painel', 'Medida');
	$isAcao = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Acao');
	$isFaixa = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Faixa');
	$isAnomalia = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Anomalia');
	$isGESTAOESTRATEGICA = ($isDimensao || $isObjetivo || $isIndicador || $isMedida || $isMedidaRevisao || $isMedidaPainel || $isAcao || $isFaixa || $isAnomalia);
	
	// GESTÃO DE PORTIFÓLIO
	$isProjeto = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Projeto');
	$isPrograma = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Programa');
	$isGESTAOPORTIFOLIO = ($isProjeto || $isPrograma);
	
	// MAPA ESTRATÉGICO
	$isMapaEstrategico = $this->ControleDeAcesso->validaAcessoElemento('listar', 'MapaEstrategico');
	
	// ORGANOGRAMA
	$isOrganograma = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Organograma');
	
?>
<div class="navbar navbar-static-top" style="position:relative; !important;">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="nav-collapse collapse" style="height: 0px;">
        <ul class="nav">
          <li class="">
            <a href="<?php echo $this->base;?>/Aplicacao">Home</a>
          </li>
          
          <?php if($isCOMUNICACAO){?>
          <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		          Comunicação
				  <b class="caret"></b>
			  </a>
			  <ul class="dropdown-menu">
			  	<?php if($isReuniao){?>
					<li><?php echo $this->Html->link(__('Reuniões'), array('controller' => 'Reuniao','action' => 'index'));?></li>
				<?php }?>
				<?php if($isTarefa){?>
					<li><?php echo $this->Html->link(__('Tarefas'), array('controller' => 'Tarefa','action' => 'index'));?></li>
				<?php }?>
				<?php if($isMarcador){?>
					<li><?php echo $this->Html->link(__('Marcadores'), array('controller' => 'Marcador','action' => 'index'));?></li>
				<?php }?>
				<?php if($isProcedimento){?>
					<li><?php echo $this->Html->link(__('Procedimentos'), array('controller' => 'Procedimento','action' => 'index'));?></li>
				<?php }?>
			  </ul>
          </li>
          <?php }?>
          
          <?php if($isCADASTROS){?>
		  <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Cadastros
		        <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		    	<?php if($isUsuario){?>
			      <li><?php echo $this->Html->link(__('Usuários'), array('controller' => 'Usuario','action' => 'index'));?></li>
			    <?php }?>
			    <?php if($isEmpresa){?>
			      <li><?php echo $this->Html->link(__('Empresas'), array('controller' => 'Empresa','action' => 'index'));?></li>
			    <?php }?>
			   	<?php if($isGrupo){?>
			      <li><?php echo $this->Html->link(__('Grupos'), array('controller' => 'Grupo','action' => 'index'));?></li>
			    <?php }?>
			    <?php if($isCargo){?>
			      <li><?php echo $this->Html->link(__('Cargos'), array('controller' => 'Cargo','action' => 'index'));?></li>
			    <?php }?>
			    <?php if($isVinculo){?>
			      <li><?php echo $this->Html->link(__('Vinculos'), array('controller' => 'Vinculo','action' => 'index'));?></li>
			    <?php }?>
			    <?php if($isSetor){?>
			      <li><?php echo $this->Html->link(__('Setores'), array('controller' => 'Setor','action' => 'index'));?></li>
			   	<?php }?>
			   	<?php if($isDepartamento){?>
			      <li><?php echo $this->Html->link(__('Departamentos'), array('controller' => 'Departamento','action' => 'index'));?></li>
			    <?php }?>
		    </ul>
          </li>
          <?php }?>
		  
		  <?php if($isGESTAOESTRATEGICA){?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Gestão Estratégica
		        <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		    
		      <?php if($isDimensao){?>
		     	<li><?php echo $this->Html->link(__('Dimensões'), array('controller' => 'dimensao','action' => 'index'));?></li>
		      <?php }?>
		      
		      <?php if($isObjetivo){?>
		      	<li><?php echo $this->Html->link(__('Objetivos'), array('controller' => 'objetivo','action' => 'index'));?></li>
		      <?php }?>
		      
		      <?php if($isIndicador){?>
			  	<li><?php echo $this->Html->link(__('Indicadores'), array('controller' => 'indicador','action' => 'index'));?></li>
			  <?php }?>
			  
			  <?php if($isMedida){?>
			  	<li><?php echo $this->Html->link(__('Ações Estratégicas'), array('controller' => 'medida','action' => 'index'));?></li>
			  <?php }?>
			  
			  <?php if($isMedidaRevisao){?>
			  	<li><?php echo $this->Html->link(__('Revisão das Ações'), array('controller' => 'medida','action' => 'indice_revisao'));?></li>
			  <?php }?>
			  
			  <?php if($isMedidaPainel){?>
			  	<li><?php echo $this->Html->link(__('Painel Geral de Ações'), array('controller' => 'medida','action' => 'painel_acoes'));?></li>
			  <?php }?>
			  
			  <?php if($isAcao){?>
		      	<li><?php echo $this->Html->link(__('Atividades'), array('controller' => 'acao','action' => 'index'));?></li>
		      <?php }?>
		      
			  <?php if($isFaixa){?>
		      	<li><?php echo $this->Html->link(__('Faixas'), array('controller' => 'faixa','action' => 'index'));?></li>
		      <?php }?>
		      
		      <?php if($isAnomalia){?>
		      	<li><?php echo $this->Html->link(__('Anomalia'), array('controller' => 'anomalia','action' => 'index'));?></li>
		      <?php }?>
		      
		    </ul>
          </li>
          <?php }?>
		
		  <?php if($isGESTAOPORTIFOLIO){?>
			<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Gestão de Portfólio
		        <b class="caret"></b>
		    </a>			
		    <ul class="dropdown-menu">
		    	<?php if($isProjeto){?>
				<li><?php echo $this->Html->link(__('Projetos'), array('controller' => 'Projeto','action' => 'index'));?></li>
				<?php }?>
				<?php if($isPrograma){?>
				<li><?php echo $this->Html->link(__('Programas'), array('controller' => 'Programa','action' => 'index'));?></li>
				<?php }?>
			</ul>
		  </li>
		  <?php }?>
		
		  <?php if($isMapaEstrategico){?>
          	<li><?php echo $this->Html->link(__('Mapa estratégico'), array('controller' => 'MapaEstrategico','action' => 'index'));?></li>
          <?php }?>
          <?php if($isOrganograma){?>
          	<li><?php echo $this->Html->link(__('Organograma'), array('controller' => 'Organograma','action' => 'index'));?></li>
          <?php }?>
          
        </ul>
      </div>
    </div>
  </div><!-- /.navbar-inner -->
</div><!-- /.navbar -->
