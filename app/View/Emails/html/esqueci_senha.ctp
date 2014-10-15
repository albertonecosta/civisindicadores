<html>
<head>
	<meta charset="utf-8">
</head>	
<body style="margin:0;padding:0;background:#f6f6f6">
	<div style="width:600px;margin:0 auto;padding:0">
		<h1 style="font-size: 32px;margin:0 0 20px 0;color:#13AA50;letter-spacing:-0.06em">
			Esqueci minha senha
		</h1>
		<h2 style="font-size: 24px;margin:0 0 20px 0;color:#444;letter-spacing:-0.06em">
			Olá <?php echo h($usuario['Pessoa']['titulo']);?>,
		</h2>
		<p style="line-height:1.4em;margin-bottom:30px">
			Para confirmar a alteração de sua senha, por favor, clique na seguinte URL:
		</p>
		<p style="line-height:1.4em;margin-bottom:30px">
			<a href="<?php echo $link;?>" style="color:#296ecc;text-decoration:none" target="_blank">
				<?php echo $link;?>
			</a>
		</p>
		<p style="line-height:1.4em;margin-bottom:30px">
			<strong>ATENÇÃO! Este link irá expirar em 24 horas</strong>
		</p>
	</div>
</body>
</html>