<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>Civis E-mail</title>
	</head>
	
	<body style="background:#f5f5f5;font-family:Arial, sans-serif;padding:0;margin:0">
		
		<div style="width:600px;margin: 0 auto;background:#fff">
		
			<!-- HEADER -->
			<div style="padding:20px 40px;border-bottom:5px solid #dedede;">
				<a href="#" title="" style="display: block">
					<img src="http://www.civis.com.br/img/logo.png" alt="" style="margin:0;padding:0;"/>
				</a>
			</div>
			<!-- END HEADER -->
	
			<!-- CONTENT -->
			<div style="padding:30px 40px;background:#fff;color:#888;font-family:Arial,sans-serif;font-size:14px;">   
				<h1 style="font-size: 32px;margin:0 0 20px 0;color:#cc2518;letter-spacing:-0.06em">
					Esqueci minha senha
				</h1>
				<h2 style="font-size: 24px;margin:0 0 20px 0;color:#444;letter-spacing:-0.06em">
					Olá <?php echo h($usuario['Pessoa']['nome']);?>,
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
			<!-- END CONTENT -->
	
			<!-- FOOTER -->
			<div style="width:600px;margin:0;padding:0;">
				<a href="#" title="" style="display: block">
					<img src="http://www.civis.com.br/img/rodape.jpg" alt="" style="margin:0;padding:0;"/>
				</a>
			</div>
			<!-- END FOOTER -->
		</div>
	</body>
	
</html>