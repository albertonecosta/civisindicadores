<?php
error_reporting(0);
//Parâmetros
$parameters = $_GET['table_data'];
$showLabel = $_GET['showlabel'] == "1";
$showScale = $_GET['showscale'] == "1";

$width = $_GET['width'];
$height = $_GET['height'];

if ($width == "") {
	$width = 500;
}
if ($height == "") {
	$height = 500;
}

$zones = 10;

$zonewidth = ($width*0.9)/$zones;
$zoneheight = ($height*0.9)/$zones;




//Inclui Pontos no Gráfico

$parameters = explode(';', $parameters);
$angle = 360/count($parameters);
$cX = $width/2;
$cY = $height/2;
$k = 0;
$color_green = "";
$color_yellow = "";
$color_strongred = "";
$color_darkgrey = "";
$color_blue = "";
$colorStatus = array($color_green, $color_yellow, $color_strongred);


foreach ($parameters as $parameter) {
	$atributos = explode("|", $parameter);
	$descricao = $atributos[0];
	$prioridade = $atributos[1];
	$andamento = $atributos[2];
	$cor = (isset($colorStatus[$atributos[3]])) ? $colorStatus[$atributos[3]] : "#FFF";
	$link = $_GET["base"] . '/Projeto/visualizar/'.$atributos[4];
	
	$radius = (100 - str_replace('%', '', $andamento))*($zonewidth*10)/100/2;
	$tamanho = 10;
	if ($prioridade == 'Alta') {
		$tamanho = 10;
	}
	if ($prioridade == 'Média') {
		$tamanho = 7;
	}
	if ($prioridade == 'Baixa') {
		$tamanho = 5;
	}
	$points[] = array(DrawCirclePointX($cX, $radius, $angle*$k), DrawCirclePointY($cY, $radius, $angle*$k), $tamanho, $descricao, $cor, $link);	
	$k++;
}




//Pontos na circunferência

function DrawCirclePointX($cX, $radius, $angle) {
	$circlePointX = $cX+$radius*cos(deg2rad($angle));
	return $circlePointX;
}
function DrawCirclePointY($cY, $radius, $angle) {
	$circlePointY = $cY+$radius*sin(deg2rad($angle));
	return $circlePointY;
}

?>
<script type="text/javascript">
	function $(obj){
		return window.document.getElementById(obj);
	}
</script>

<div style="text-align: center" >
<img id="alvo" src="http://<?php echo $_SERVER['HTTP_HOST'] . $_GET["base"]; ?>/graficos/alvo_projeto.php?width=<?php echo $_GET['width']; ?>&height=<?php echo $_GET['height']; ?>&showscale=<?php echo $_GET['showscale']; ?>&showlabel=<?php echo $_GET['showlabel']; ?>&table_data=<?php echo $_GET['table_data']; ?>" usemap="#targetmap" />
<map name="targetmap">
<?php

foreach ($points as $point) {
	$plot = $point;
	$plotX = $plot[0]; //+ ($width/2);
	$plotY = $plot[1]; //+ ($height/2);
	$plotZ = $plot[2];
	
	$plotLabel = $plot[3];
	?>
	<area shape="circle"  coords="<?php echo $plotX.','.$plotY.','.$plotZ; ?>" onmouseout="$('<?php echo $plotLabel; ?>').style.display = 'none';" onmouseover="$('<?php echo $plotLabel; ?>').style.left = event.x;$('<?php echo $plotLabel; ?>').style.top = (event.y+25);$('<?php echo $plotLabel; ?>').style.display = 'inline';" href="<?php echo $plot[5]; ?>" target="_parent" alt="<?php echo $plotLabel; ?>" caption="<?php echo $plotLabel; ?>" />
	<?php
	
}
?>
</map>

</div>
<?php
foreach ($points as $point) {
	$plot = $point;
	$plotX = $plot[0] + ($width/2);
	$plotY = $plot[1] + ($height/2);
	$plotZ = $plot[2];
	$plotLabel = $plot[3];
	?>
	<div  id="<?php echo $plotLabel; ?>" style="left:<?php echo ($plotX+25) ?>;top:<?php echo ($plotY+25) ?>;position:absolute;display: none;border-radius: 5px 5px; padding: 4px 4px 4px 4px; background-color:lightgray;border: 1px solid #BBB;font-family: verdana; font-size:12px;"><?php echo $plotLabel; ?></div>
	<?php
	
}
?>