<?php echo $this->element('head'); ?>
</head>
<body id="<?php echo @$body_id;?>" class="site <?php echo @$body_class;?>">
	<div id="wrapper">
		<header id="header" class="clearfix">
	    	<div id="header-content" class="container clearfix">
	    		<span class="header-logo">
	    			<a href="<?php echo $this->base;?>/" class="header-logo-a" title="Civis Estratégia">
	    				<img src="<?php echo $this->base;?>/img/logo-civis-estrategia.png" alt="Civis Estratégia">
	    				<span class="visuallyhidden">Civis Estratégia</span>
	    			</a>
	    		</span>
	        </div><!-- fim #header-conteudo -->
	    </header><!-- fim #header -->
		<div class="wrapper-content">
			<div class="content container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>	<!-- /.corpo-conteudo -->
		</div><!-- /.corpo -->
		<footer class="footer">
			<!-- <?php echo $this->element('footer')?> -->
		</footer><!-- /.rodape -->
	</div><!-- #wrapper -->
	<!-- Scripts -->
	<?php echo $this->element('scripts'); ?>
	<!-- end Scripts -->
	</body>
</html>