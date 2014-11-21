<?php 
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */
?>
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
			 <?php echo $this->element('footer')?>
		</footer><!-- /.rodape -->
	</div><!-- #wrapper -->
	<!-- Scripts -->
	<?php echo $this->element('scripts'); ?>
	<!-- end Scripts -->
	</body>
</html>