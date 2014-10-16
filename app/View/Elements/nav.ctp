<?php
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
		  
		  
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Gestão Estratégica
		        <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		      <li>
		      	<?php 
		      		
						echo $this->Html->link(__('Dimensões'), array('controller' => 'Dimensao','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Objetivos'), array('controller' => 'Objetivo','action' => 'index'));
		      		
		      	?>
		      </li>
			  <li class="">
			  	<?php 
		      		
						echo $this->Html->link(__('Indicadores'), array('controller' => 'Indicador','action' => 'index'));
					
				?>
			  </li>
			  <li class="">
				<?php echo $this->Html->link(__('Ações Estratégicas'), array('controller' => 'Medida','action' => 'index'));?>
			  </li>
			  
			  <li class="">
				<?php 
				
					echo $this->Html->link(__('Revisão das Ações'), array('controller' => 'Medida','action' => 'indice_revisao'));
				
				?>				
			  </li>
			  <li class="">
				<?php echo $this->Html->link(__('Painel Geral de Ações'), array('controller' => 'Medida','action' => 'painel_acoes'));?>
			  </li>
			  
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Atividades'), array('controller' => 'Acao','action' => 'index'));
		      		
		      	?>
		      </li>
<!--		      <li>
		      	<?php echo $this->Html->link(__('Planos de Ação'), array('controller' => 'PlanoAcao','action' => 'index'));?>
		      </li>-->
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Faixas'), array('controller' => 'Faixa','action' => 'index'));
		      		
		      	?>
		      </li>
		      <li>
		      	<?php 
		      		
						echo $this->Html->link(__('Anomalia'), array('controller' => 'Anomalia','action' => 'index'));
					
				?>
		      </li>
		    </ul>
          </li>
		
			<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Gestão de Portfólio
		        <b class="caret"></b>
		    </a>			
		    <ul class="dropdown-menu">
				<li>          
				<?php 					
					echo $this->Html->link(__('Projetos'), array('controller' => 'Projeto','action' => 'index'));
									?>
				</li>
				<li>
				<?php 
					echo $this->Html->link(__('Programas'), array('controller' => 'Programa','action' => 'index'));
				?>
				</li>
			</ul>
		  </li>
		
          <li class="">
            <?php 
            	echo $this->Html->link(__('Mapa estratégico'), array('controller' => 'MapaEstrategico','action' => 'index'));
            ?>
          </li>
          <li class="">
            <?php 
            	echo $this->Html->link(__('Organograma'), array('controller' => 'Organograma','action' => 'index'));
            ?>
          </li>
        </ul>
      </div>
    </div>
  </div><!-- /.navbar-inner -->
</div><!-- /.navbar -->
