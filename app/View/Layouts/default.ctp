
<?php echo $this->element('head'); ?>

</head>

<body id="<?php echo @$body_id;?>" class="site <?php echo @$body_class;?>">

	<div id="wrapper">

		<header id="header" class="clearfix">
	    	<div id="header-content" class="container clearfix">
	    		<span class="header-logo">
	    			<a href="<?php echo $this->base;?>/Aplicacao" class="header-logo-a" title="Civis Estratégia">
	    				<img src="<?php echo $this->base;?>/img/logo-civis-estrategia.png" alt="Civis Estratégia">
	    				<span class="visuallyhidden">Civis Estratégia</span>
	    			</a>
	    		</span>
	    		
	    		 
	    		<div class="topo-usuario clearfix">
	    			<p class="topo-usuario-login">
	    				<em class="descricao">Departamento:</em>
	    				<strong class="titulo cor-destaque login-titulo"><?php
	    				echo $usuarioLogado["Departamento"]["titulo"];	?></strong>
	    			</p>
	    			
	    			<div class="topo-usuario-bloco clearfix">
	    				<img src="" alt="" height="56"/>
	    				<div class="texto">
	    					<strong class="nome"><?php	echo $usuarioLogado["Pessoa"]["titulo"];	?></strong>
							<br /><?php	echo $usuarioLogado["Grupo"]["titulo"];	?>
	    					<div class="links">
	    						<?php echo $this->Html->link("Alterar Dados", array("controller"=>"usuario","action"=>"alterardados"));?>	
	    						<span class="separador"> | </span>
	    						<?php echo $this->Html->link("Sair", array("controller"=>"autenticacao","action"=>"logout"));?>		
	    					</div>
	    				</div>
		    			
	    			</div><!-- fim .topo-usuario-bloco -->
					
	    		</div><!-- fim .topo-usuario -->
	    		 
	    		
	        </div><!-- /#header-content -->
	    </header><!-- /#header -->
			


		<!-- Nav -->
		<?php echo $this->element('nav');?>
		<!-- end Nav -->



		<div class="wrapper-content">
			<div class="content container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>	<!-- /.content -->
		</div><!-- /.wrapper -->


		<footer class="footer">
			<!-- <?php echo $this->element('footer')?> -->
		</footer><!-- /.footer -->
		

	</div><!-- /#wrapper -->

	<!-- Scripts -->
	<?php echo $this->element('scripts'); ?>
	<!-- end Scripts -->
	
		
	</body>

</html>