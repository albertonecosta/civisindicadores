<?php 
/**
*
* Copyright [2014] -  Civis Gestão Inteligente
* Este arquivo é parte do programa Civis Estratégia
* O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
* Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
* Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*
*/
?>
<div class="container">


	<h4 class="title title-section">Organograma</h4>
	
	
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<select name="data[Projeto][busca]" id="ProjetoBusca">
						<option value="">Filtrar por:</option>					
						<?php foreach($departamentos as $departamento){?>
						<option value="<?php echo $departamento["Departamento"]["id"]; ?>"><?php echo $departamento["Departamento"]["titulo"];?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Organograma'])){
						if(count($_SESSION['Search']['Organograma'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Organograma'] as $key => $temo_busca){
						?>
						<?php  
						?>
							<span class="type-tag">
								<?php echo "Departamento"?>: 
								<?php echo $labelDepartamentos[$temo_busca['busca']];?>
								<?php if(count($_SESSION['Search']['Organograma']) > 1){ 
											echo $this->Html->link("", array("action" => "excluirFiltro", $key), 
																		array("class" => "fa fa-times")); 
								}?>
								</span>
						<?php	
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</form>

	<div class="row-fluid">
		<ul class="thumbnails">
			<?php foreach($setoresSuperiores as $setor){ ?>
			
			<?php if(!isset($usuariosPorSetor[$setor["Setor"]["id"]]) || !count($usuariosPorSetor[$setor["Setor"]["id"]])) continue; ?>
			
				<div class="row-fluid" style="margin-bottom: 20px">
					<li class="span12" style="background-color: #e3e3e3;">
						<div class="thumbnail">
							<center><h3><?php echo $setor['Setor']['titulo']; ?></h3></center>
							<center>
							<?php foreach($usuariosPorSetor[$setor["Setor"]["id"]] as $key2 => $value){?>
								<?php if($value['Usuario']['chefe'] == Util::ATIVO){?>
									<div class="span12">
										<a href="javascript:abrirModal(<?php echo $value['Usuario']['id']; ?>, true)"><img class='novaImagem' src="<?php echo $this->webroot."files/usuario/".$value['Usuario']['diretorio_imagem_perfil']."/"."pequeno_".$value['Usuario']['imagem_perfil']; ?>"></a><br>
										<p><?php echo $value['Pessoa']['titulo']; ?></p>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star-o"></i>
									</div>
									<?php unset($usuariosPorSetor[$setor["Setor"]["id"]][$key2]); ?>
								<?php }?>
							<?php } ?>
							</center>
							<center>					
							<div class="row-fluid">
							<?php foreach($usuariosPorSetor[$setor["Setor"]["id"]] as $key2 => $value){?>
									<div class="span4">
										<a href="javascript:abrirModal(<?php echo $value['Usuario']['id']; ?>, true)"><img class='novaImagem'  src="<?php echo $this->webroot."files/usuario/".$value['Usuario']['diretorio_imagem_perfil']."/"."pequeno_".$value['Usuario']['imagem_perfil']; ?>"></a><br>
										<p><?php echo $value['Pessoa']['titulo']; ?></p>
														<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star-o"></i>
									</div>
							<?php } ?>
							</div>
							</center>
						</div>
					</li>
				</div>
			<?php } ?>
		</ul>
	</div>	
	<div class="row-fluid">
		<ul class="thumbnails">
		<?php $count = 0; ?>
		<?php foreach($setoresInferiores as $key => $setor){ ?>
		<?php $count++; ?>
		
		<?php if(!isset($usuariosPorSetor[$setor["Setor"]["id"]]) || !count($usuariosPorSetor[$setor["Setor"]["id"]])) continue; ?>
		
			<?php if(($key % 3) == 0){ ?>				
				<div class="row-fluid" style="margin-bottom: 20px">
			<?php } ?>		
			
				<li class="span4">
					<div class="thumbnail">
						<center><h3><?php echo $setor['Setor']['titulo']; ?></h3></center>
						<center>
						<?php foreach($usuariosPorSetor[$setor["Setor"]["id"]] as $key2 => $value){?>
							<?php if($value['Usuario']['chefe'] == Util::ATIVO){?>
								<div class="row-fluid">
									<div class="span12">
										<a href="javascript:abrirModal(<?php echo $value['Usuario']['id']; ?>, true)"><img class='novaImagem'   src="<?php echo $this->webroot."files/usuario/".$value['Usuario']['diretorio_imagem_perfil']."/"."pequeno_".$value['Usuario']['imagem_perfil']; ?>"></a><br>
										<p><?php echo $value['Pessoa']['titulo']; ?></p>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star-o"></i>
										<i class="icon-search fa fa-star-o"></i>
									</div>
								</div>
								<?php unset($usuariosPorSetor[$setor["Setor"]["id"]][$key2]); ?>
							<?php }?>
						<?php } ?>
						</center>
						<center>
						<div class="row-fluid">
						<?php foreach($usuariosPorSetor[$setor["Setor"]["id"]] as $key2 => $value){?>
							<div class="span4">
								<a href="javascript:abrirModal(<?php echo $value['Usuario']['id']; ?>, true)"><img class='novaImagem'  src="<?php echo $this->webroot."files/usuario/".$value['Usuario']['diretorio_imagem_perfil']."/"."pequeno_".$value['Usuario']['imagem_perfil']; ?>"></a><br>
								<p><?php echo $value['Pessoa']['titulo']; ?></p>
											<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star"></i>
										<i class="icon-search fa fa-star-o"></i>
										<i class="icon-search fa fa-star-o"></i>
							</div>
						<?php } ?>
						</div>
						</center>
					</div>
				</li>	
			
			<?php if(($count % 3) == 0){ ?>
				</div>
			<?php } ?>
		<?php } ?>
		</ul>
	</div>
</div>
<div id="dialog" title="Painel de Resumo" style="display: none">
</div>
<div id="dialog1" title="Painel de Resumo" style="display: none">
</div>
<div id="loading" style="display: none">
	<div class+"row-fluid">
		<center><img src="<?php echo $this->webroot."img".DS."ajax-loader.gif" ?>" /></center>
	</div>
	<div class="row-fluid">
		<center>Carregando</center>
	</div>	
</div>
<div id="painelAnomalias" title="Painel de Anomalias" style="display: none">
</div>

<script>
	
    
	function abrirModal(usuario_id, comDialog){
		var action = "<?php echo $this->webroot;?>Organograma/ajaxPainelResumo";
		$("#dialog").html($("#loading").html());
		if(comDialog == true){
			$("#dialog").dialog({
				height: 400,
		    	width: 890,
		    	modal: true
			});
		}
		$.post(
			action,
			{usuario_id: usuario_id, data_atual: "atual"},
			function(data){
				$("#dialog").html("");
				$("#dialog").html(data);								
			}
		);
	}
	
	function resumoIndicador(idIndicador, mes, comDialog){
		//true = abrir em modal diferentel, false = abrir no mesmo modal
		//var comDialog = false;
		var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxPainelResumoApenas";
		$.post(
			action,
			{indicador_id: idIndicador, mes: mes},
			function(data){
				if(comDialog == true){
					$("#dialog1").html(data);				
					$("#dialog1").dialog({
						height: 400,
				    	width: 350,
				    	modal: true
					});
				}else{
					$("#dialog").html(data);				
					$("#dialog").dialog({
						height: 400,
				    	width: 350,
				    	modal: true
					});
				}
				
			}
		);
	}
	
	function abrirPainelAnomalia(idAnomalia){
		//true = abrir em modal diferentel, false = abrir no mesmo modal
		var comDialog = false;
		var action = "<?php echo $this->webroot;?>Anomalia/ajaxPainelAnomalia/" + idAnomalia;
		$.get(
			action,
			{},
			function(data){
				if(comDialog == true){
					$("#painelAnomalias").html(data);
					$("#painelAnomalias").css("display", "block");
				    $("#painelAnomalias").dialog({
				    	height: 500,
				    	width: 800,
				    	modal: true
				    });
			   }else{
			   		$("#dialog").html(data);
					$("#dialog").css("display", "block");
				    $("#dialog").dialog({
				    	height: 500,
				    	width: 800,
				    	modal: true
				    });
			   }
			}
		);	
	}
</script>