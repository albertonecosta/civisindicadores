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
<html>
<head>
	<meta charset="utf-8">
</head>
<body style="margin:0;padding:0;background:#f6f6f6">
	<div style="width:600px;margin:0 auto;padding:0">
		<div style="padding:40px;color:#444;font:normal 14px/21px Arial, sans-serif;border:1px solid #eaeaea;background:#fff;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;-webkit-box-shadow:0 0 7px #dad9d9">
			<h1 style="font-size:20px;color:#555">Reunião</h1>
			<p><b>Assunto</b>:&nbsp;<?php echo $assunto; ?> </p>
			<p><b>Local</b>:&nbsp;<?php echo $local; ?> </p>
			<p><b>Data</b>:&nbsp;<?php echo $data; ?> </p>
			<p><b>Horário</b>:&nbsp;<?php echo $horario; ?> </p>
			<p><b>Participantes</b>:&nbsp;<?php echo $participantes; ?> </p>
			<p><b>Pauta</b>:&nbsp;<?php echo $pauta ?></p>
			<p><b>Ata</b>:&nbsp;<?php echo $ata ?></p>
			<p><b>Observações</b>:&nbsp;<?php echo $observacao ?></p>
		
		</div>
	</div>
</body>
</html>