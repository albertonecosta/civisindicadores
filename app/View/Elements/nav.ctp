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
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Comunicação
		        <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		      <li>
		      	<?php 
		      		echo $this->Html->link(__('Reuniões'), array('controller' => 'Reuniao','action' => 'index'));
		      	?>
		      </li>
		      <li>
		      	<?php 
		      		echo $this->Html->link(__('Tarefas'), array('controller' => 'Tarefa','action' => 'index'));
				?>
		      </li>
		      <li>
		      <?php 
	            	echo $this->Html->link(__('Marcadores'), array('controller' => 'Marcador','action' => 'index'));
	            ?>
	          </li>  
		      <li>
		      	<?php 
		      			echo $this->Html->link(__('Procedimentos'), array('controller' => 'Procedimento','action' => 'index'));
					
				?>
		      </li>
		    </ul>
          </li>
          
          
		  <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            	Cadastros
		        <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Usuários'), array('controller' => 'Usuario','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Empresas'), array('controller' => 'Empresa','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
			      	
			      		echo $this->Html->link(__('Grupos'), array('controller' => 'Grupo','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Cargos'), array('controller' => 'Cargo','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
		      			echo $this->Html->link(__('Vinculos'), array('controller' => 'Vinculo','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
						echo $this->Html->link(__('Setores'), array('controller' => 'Setor','action' => 'index'));
					
				?>
		      </li>
		      <li>
		      	<?php 
		      		
						echo $this->Html->link(__('Departamentos'), array('controller' => 'Departamento','action' => 'index'));
					
				?>
		      </li>
		      
		    </ul>
          </li>
		  
		  
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
