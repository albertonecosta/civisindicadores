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
<div class="row">
		<div class="span6">
			<small>Página <?php echo $paginaAtual;?> de <?php echo $totalPaginas;?>, exibindo <?php echo $countRegistros;?> registro(s) de <?php echo $totalRegistros;?> no total.</small>	
		</div>
		<?php if($totalPaginas > 1){?>
		<div class="span6">
			<div class="pagination pagination-mini pull-right" style="margin:0;">
				<ul>
					<?php if($paginaAtual == 1){?>
						<li class="disabled prev">
							<a onclick="return false;">&lt; anterior</a>
						</li>
					<?php }else{?>
						<li class="prev">
							<a href="?pagina=<?php echo $paginaAtual - 1;?>" rel="next">&lt; anterior</a>
						</li>
					<?php }?>
					
					<?php for($i = 1 ; $i <= $totalPaginas ; $i ++){?>
						<?php if($paginaAtual == $i){?>
							<li class="active">
								<a><?php echo $i;?></a>
							</li>
						<?php }else{?>
							<li>
								<a href="?pagina=<?php echo $i;?>"><?php echo $i;?></a>
							</li>
						<?php }?>
					<?php }?>
					
					<?php if($paginaAtual == $totalPaginas){?>
						<li class="disabled next">
							<a onclick="return false;">próxima &gt;</a>
						</li>
					<?php }else{?>
					<li class="next">
						<a href="?pagina=<?php echo $paginaAtual + 1;?>" rel="next">próxima &gt;</a>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<?php }?>
</div>

<br class="clear"/>