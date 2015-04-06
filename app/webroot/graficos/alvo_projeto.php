<?php

/**
 * Essa página deve ser escrita em ISO-8859-1
 */

error_reporting(0);
header ("Content-type: image/png");

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

$im = @imagecreatetruecolor($width, $height) or die("Cannot Initialize new GD image stream");
imageantialias($im, true);

// Fundo Transparente
imagesavealpha($im, true);
$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $trans_colour);

//Titulo da Imagem
$text_color = imagecolorallocate($im, 0, 0, 100);

// inicia cores
$color_red = imagecolorallocate($im, 230, 230, 230);
$color_strongred = imagecolorallocate($im, 255, 0, 0);
$color_white = imagecolorallocate($im, 255, 255, 255);
$color_black = imagecolorallocate($im, 0, 0, 0);
$color_grey = imagecolorallocate($im, 200, 200, 200);
$color_darkgrey = imagecolorallocate($im, 150, 150, 150);
$color_blue = imagecolorallocate($im, 0, 0, 200);
$color_green = imagecolorallocate($im, 0, 200, 0);
$color_yellow = imagecolorallocate($im, 210, 210, 0);

$odd = true;
$greyzone = true;
$zones = 10;

$zonewidth = ($width*0.9)/$zones;
$zoneheight = ($height*0.9)/$zones;

//$situacao = new Array("Não Informado" => 0, "Adequado" => 1, "Atenção" => 2, "Preocupante" => 3, "Concluído" => 4);

for ($i = 0; $i < $zones; $i++) {

	if ($odd) {
		if ($greyzone){
			$col_ellipse = $color_grey;
		}
		else {
			$col_ellipse = $color_red;
		}
		
		
		$greyzone = !$greyzone;
	}
	else {
		$col_ellipse = $color_white;
	}
	imagefilledellipse($im, ($width/2), ($height/2), (($zones-$i)*$zonewidth), (($zones-$i)*$zoneheight), $col_ellipse);	
	
	
	$odd = !$odd;


}
//Mostra Escala
if ($showScale) {
	for ($i = 0; $i < $zones; $i++) {
		//imagestring ( resource $image , int $font , int $x , int $y , string $string , int $color )
		
		//center
		if ($i == 0) {
			$labelX = ($width/2) - 7 ;
			$labelY = ($height/2) - 6;
			$labelText = 100;
			imagestring($im, 2, $labelX, $labelY,  $labelText, $color_black);
		}
		else {
			$labelText = ($zones - $i) * 10;
			
			//right
			$labelX = ($width/2) + $i*(($zonewidth/2))+($zonewidth/4)-4;
			$labelY = ($height/2) - 3;
			//imagestring($im, 1, $labelX, $labelY,  $labelText, $color_black);
			
			//bottom
			$labelX = ($width/2)- 3 ;
			$labelY = ($height/2)+ $i*(($zoneheight/2))+($zoneheight/4)-4 ;
			//imagestring($im, 1, $labelX, $labelY,  $labelText, $color_black);
			
			
			//left
			$labelX = ($width/2) - $i*(($zonewidth/2))-($zonewidth/4)-4;
			$labelY = ($height/2) - 3;
			imagestring($im, 1, $labelX, $labelY,  $labelText, $color_black);
			
			
			//top
			$labelX = ($width/2)- 3 ;
			$labelY = ($height/2) - $i*(($zoneheight/2))-($zoneheight/4)-4 ;
			//imagestring($im, 1, $labelX, $labelY,  $labelText, $color_black);
			
		}
		
	}
}

//Inclui Pontos no Gráfico


//imagestring($im, 1, 25, 25,  $parameters, $color_black);

$parameters = explode(';', $parameters);
$angle = 360/count($parameters);
$cX = width/2;
$cY = height/2;
$k = 0;
$colorStatus = array($color_green, $color_yellow, $color_strongred);


foreach ($parameters as $parameter) {
	$atributos = explode("|", $parameter);
	$descricao = $atributos[0];
	$prioridade = $atributos[1];
	$andamento = $atributos[2];
	$cor = $colorStatus[$atributos[3]];
	
	$radius = (100 - str_replace('%', '', $andamento))*($zonewidth*10)/100/2;
	
	if ($prioridade == 'Alta') {
		$tamanho = 20;
	}
	if ($prioridade == 'Média') {
		$tamanho = 14;
	}
	if ($prioridade == 'Baixa') {
		$tamanho = 10;
	}
	
	$points[] = array(DrawCirclePointX($cX, $radius, $angle*$k), DrawCirclePointY($cY, $radius, $angle*$k), $tamanho, $descricao, $cor);	
	$k++;
}

foreach ($points as $point) {
	$plot = $point;
	$plotX = $plot[0] + ($width/2);
	$plotY = $plot[1] + ($height/2);
	$plotZ = $plot[2];
	$plotLabel = $plot[3];
	imagefilledellipse($im, $plotX, $plotY, $plotZ, $plotZ, $plot[4]);
	
	if ($showLabel) {
		imagestring($im, 3, $plotX, $plotY,  $plotLabel, $color_blue);	
	}	
	
}

//Teste de circunferência

function DrawCirclePointX($cX, $radius, $angle) {
	$circlePointX = $cX+$radius*cos(deg2rad($angle));
	return $circlePointX;
}
function DrawCirclePointY($cY, $radius, $angle) {
	$circlePointY = $cY+$radius*sin(deg2rad($angle));
	return $circlePointY;
}
/*
for ($i = 0; $i < 360; $i++) {
	imagesetpixel($im, DrawCirclePointX(($width/2), 90, $i), DrawCirclePointY(($height/2), 90, $i), $color_blue);
}	
*/
//Exibir imagem e destruir o objeto
imagepng($im);
imagedestroy($im);
?>