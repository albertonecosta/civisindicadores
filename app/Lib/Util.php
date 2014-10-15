<?php
class Util{
	
	const ATIVO 	= 1;
	const INATIVO 	= 0;
	
	const NAO_INICIADO	= 2;
	const EM_ANDAMENTO	= 3;
	const AGUARDANDO_OUTRA_PESSOA	= 4;
	const CONCLUIDO	= 5;
	const CANCELADO	= 6;
	const NAO_CONCLUIDO	= 7;
	
	const NAO_INFORMADO = 2;
	const ADEQUADO = 3;
	const ATENCAO = 4;
	const PREOCUPANTE = 6;
	
	const CALCULO_SOMA = 1;
	const CALCULO_MEDIA = 2;
	
	const DESDOBRAMENTO_MENSAL = 1;
	const DESDOBRAMENTO_ANUAL = 0;
	
	const TIPO_CALCULO_NEGATIVO = 1;
	const TIPO_CALCULO_NEGATIVO_NAO_ACUMULATIVO = 2;
	const TIPO_CALCULO_POSITIVO = 3;
	const TIPO_CALCULO_POSITIVO_NAO_CUMULATIVO = 4;
	
	const PAGE_LIMIT = 10;
	const COMPLETO = 1;
	const INCOMPLETO = 0;
	
	const EXIBIR	= 1;
	const ESCONDER	= 0;
	
	const TIPO_PADRAO = 1;
	const TIPO_MEDIDA = 2;
	
	const TIPO_SUPERIOR = 1;
	const TIPO_INFERIOR = 2;
	
	const TIPO_CAMPO_GERAL = 1;
	const TIPO_CAMPO_ARRAY = 2;
	
	const MENSAGEM_PADRAO_PAGINACAO = 'Página {:page} de {:pages}, exibindo {:current} registro(s) de {:count} no total.';
	const PROXIMO_PAGINACAO = 'próxima >';
	const ANTERIOR_PAGINACAO = '< anterior';
	const PRIMEIRA_PAGINACAO = 'primeira';
	const ULTIMA_PAGINACAO = 'última';
	
	const MENSAGEM_DELETAR = 'Você realmente deseja deletar o registro # %s?';
	
	const REGISTRO_NAO_ENCONTRADO = 'Registro não encontrado.';
	
	const REGISTRO_EDITADO_SUCESSO = 'Registro editado com sucesso.';
	const REGISTRO_ADICIONADO_SUCESSO = 'Registro adicionado com sucesso.';
	const REGISTRO_DELETADO_SUCESSO = 'Registro deletado com sucesso.';
	const REGISTROS_EXCLUIDOS_SUCESSO = 'Os registros selecionados foram excluídos com sucesso.';
	
    const SENHA_NAO_CONFEREM_BANCO = 'Senha atual não confere com a senha registrada.';
    const SENHA_NAO_CONFEREM = 'Nova senha não confere com o campo de confirmação.';
        
	const REGISTRO_EDITADO_FALHA = '<b>Não foi possível editar o registro</b>. Por favor, confira todos os campos obrigatórios e tente novamente.';
	const REGISTRO_ADICIONADO_FALHA = '<b>Não foi possível adicionar o registro</b>. Por favor, confira todos os campos obrigatórios e tente novamente.';
	const REGISTRO_DELETADO_FALHA = 'Não foi possível deletar o registro, favor tente novamente.';
	const REGISTRO_DELETADO_FALHA_ESTATICO = "Não foi possível deletar o registro, Registros estáticos não podem ser deletados.";
	
	const MENSAGEM_ENVIADA_SUCESSO = 'Mensagem enviada com sucesso.';
	const MENSAGEM_ENVIADA_FALHA = 'Não foi possível enviar a mensagem.';
	
	const AVISO_ENVIADO_SUCESSO = 'Aviso enviado com sucesso.';
	const AVISO_ENVIADO_FALHA = 'Não foi possível enviar o aviso por email.';
	
	const PERFIL_SINDICO = 1;
	const PERFIL_SUBSINDICO = 2;
	
	const MENSAGEM_LIDA = 1;
	const MENSAGEM_NAO_LIDA = 0;
	
	const NAO_EXISTE_MENSAGEM = 'Nao existe mensagens para voce';
	
	const ENVIAR_EMAIL = 1;
	const NAO_ENVIAR_EMAIL = 0;
	
	
	public function __construct(){}
	
	/**
	 * Método que retorna o último dia do mês e o ano passados por parâmetro
	 * @param Int $mes
	 * @param Int $ano
	 * @static
	 * @return Int
	 */
	public static function ultimoDiaMes($mes,$ano){
		return date("d",mktime(0,0,0,$mes + 1,0,$ano));
	}
	
	public static function getStatus($status){
		$retorno = "";
		switch ($status) {
			case Util::ATIVO:
				$retorno = "Ativo";
				break;
			case Util::INATIVO:
				$retorno = "Inativo";
				break;
			case Util::NAO_INICIADO:
				$retorno = "Não iniciado";
				break;
			case Util::EM_ANDAMENTO:
				$retorno = "Em andamento";
				break;
			case Util::AGUARDANDO_OUTRA_PESSOA:
				$retorno = "Aguardando outra pessoa";
				break;
			case Util::CONCLUIDO:
				$retorno = "Concluido";
				break;
			case Util::CANCELADO:
				$retorno = "Cancelado";
				break;
			case Util::NAO_CONCLUIDO:
				$retorno = "Não concluido";
				break;			
			default:				
				break;
		}
		return $retorno;
	}
	
	public static function getTipoCalculo($numero){
		switch ($numero) {
			case Util::TIPO_CALCULO_NEGATIVO:
				$retorno = "Negativo";
				break;
			case Util::TIPO_CALCULO_NEGATIVO_NAO_ACUMULATIVO:
				$retorno = "Negativo não acumulativo";
				break;
			case Util::TIPO_CALCULO_POSITIVO:
				$retorno = "Positivo";
				break;
			case Util::TIPO_CALCULO_POSITIVO_NAO_CUMULATIVO:
				$retorno = "Positivo não acumulativo";
				break;			
			default:				
				break;
		}
		return $retorno;
	}
	
	public static function getTimesTamp($dataPtBr){
		$arrayData = explode(" ", $dataPtBr);
		if(count($arrayData) == 2){
			$strData = $arrayData[0];
			$strHora = $arrayData[1]; 
		}else{
			$strData = $arrayData[0];
			$strHora = "00:00:00";
		}
		list($intDia,$intMes,$intAno) = explode("/", $strData);
		$arrayHora = explode(":", $strHora);
		if(count($arrayHora) == 3){
			list($intHora,$intMin,$intSeg) = explode(":", $strHora);
		}else if(count($arrayHora) == 2){
			list($intHora,$intMin) = explode(":", $strHora);
			$intSeg = 0;
		}
		return mktime((int)$intHora,(int)$intMin,(int)$intSeg,(int)$intMes,(int)$intDia,(int)$intAno);
	}
	
	public static function getBomDiaBoaTardeBoaNoite(){
		$hora = date("H");
		if($hora >= 0 && $hora < 12)
			return "Bom dia";
		if($hora >= 12 && $hora < 18)
			return "Boa tarde";
		else
			return "Boa noite";
	}
	
	/**
	 * Mëtodo que tem a função de inverter o formato de data original
	 * Caso a data venha no formato ptbr, é invertido para o fotmato usa
	 * Caso venha no USA, inverte para o ptbr
	 * Caso venha hora, retorna com hora, sem os segundos
	 * Caso não venha com hora, retorna sem hora
	 * @param string $strData
	 * @static
	 * @access public
	 * @return string
	 */
	public static function inverteData($strData){
		$strData = trim($strData);
		$arrayData = explode(" ", $strData);
		
		$data = $arrayData[0];
		$hora = (isset($arrayData[1])) ? " " . substr($arrayData[1], 0,5) : "";
		
		/* ptbr to usa */
		if(strpos($data, "/")){
			list($dia,$mes,$ano) = explode("/", $data);
			return $ano . "-" . $mes . "-" . $dia . $hora;
		}
		/* usa to ptbr */
		else if(strpos($data, "-")){
			list($ano,$mes,$dia) = explode("-", $data);
			return $dia . "/" . $mes . "/" . $ano . $hora;
		}
	}

	
	
	/**
	 * Método que retira os acentos de uma String e a retorna
	 * @param String $str
	 * @access public
	 * @static
	 * @return String
	 */
	public static function retiraAcento($str){
		$arrAcentos		= array("Á","É","Í","Ó","Ú","Â","Ê","Î","Ô","Û","Ã","Ñ","Õ","Ä","Ë","Ï","Ö","Ü","À","È","Ì","Ò","Ù","á","é","í","ó","ú","â","ê","î","ô","û","ã","ñ","õ","ä","ë","ï","ö","ü","à","è","ì","ò","ù",".",",",":",";","...","ç","%","?","/","\\","","","'","!","@","#","$","*","(",")","+","=","{","}","[","]","|","<",">","\"","&ordf;","&ordm;","&deg;","","","&raquo;","-","ª","º","»","´","~","&","°","²","³");
		$arrSemacento	= array("a","e","i","o","u","a","e","i","o","u","a","n","o","a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","a","n","o","a","e","i","o","u","a","e","i","o","u","","","","","","c","_porcento","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","e","","2","3");
		for($intPos = 0 ; $intPos < count($arrAcentos) ; $intPos++){
			$str = str_replace($arrAcentos[$intPos],$arrSemacento[$intPos],$str,$cont);
		}
		return $str;
	}

	

	/**
	 * Método responsável por retornar o dia da semana em português
	 * @param int $intDia
	 * @param int $intMes
	 * @param int $intAno
	 */
	public static function getDiaDaSemana($intDia = null, $intMes = null, $intAno = null){
		
		$intDia = (is_null($intDia)) ? date("d") : $intDia;
		$intMes = (is_null($intMes)) ? date("m") : $intMes;
		$intAno = (is_null($intAno)) ? date("Y") : $intAno;
		
		switch(date('N', mktime(0, 0, 0, $intMes, $intDia, $intAno))){
			case 1:
				$strRetorno = 'segunda-feira';
				break;
			case 2:
				$strRetorno = 'terça-feira';
				break;
			case 3:
				$strRetorno = 'quarta-feira';
				break;
			case 4:
				$strRetorno = 'quinta-feira';
				break;
			case 5:
				$strRetorno = 'sexta-feira';
				break;
			case 6:
				$strRetorno = 'sábado';
				break;
			case 7:
				$strRetorno = 'domingo';
				break;
		}
		
		return $strRetorno;
	}

	/**
	 * Retorna a extensão de um arquivo atravéz do fileName informado
	 * @param String $strFileName
	 * @static
	 * @return String
	 */
	public static function getExtensao($strFileName){
		$pecas = explode(".", $strFileName);
		$tam = count($pecas);
		return $pecas[$tam - 1];
	}

	/**
	 * Método usado na geração de senhas aleatórias
	 * @param $intTam
	 * @access public
	 * @static
	 * @return string
	 */
	public static function gerarSenha($intTam = 6){
		$array = array(
			array("1","2","3","4","5","6","7","8","9"),
			array("a","b","c","d","e","f","g","h","k","m","n","p","q","r","s","t","u","v","x","z")
		);
		$strSenha = "";
		for($i = 0 ; $i  < $intTam ; $i++ ){
			$key = rand(0,count($array)-1);
			$strSenha .= $array[$key][rand(0,count($array[$key]) - 1)];
		}
		return $strSenha;
	}

	/**
	 * Método que retorna uma string passada por parâmetro em formato de url
	 * @param String $strTitulo
	 * @access public
	 * @return String
	 */
	public static function formatarTituloParaUrl($strTitulo){
		// retira todos os acentos e caracteres especiais
		$strTitulo = str_replace(" - ", " ", $strTitulo);
		$strTitulo = self::retiraAcento($strTitulo);
		// retita os espaços em branco e troca para um "-"
		$strTitulo = str_replace(" ", "-", $strTitulo);
		return strtolower($strTitulo);
	}

	
	/**
	 * Método que retorna os estados brasileiros
	 * @static
	 */
	public static function getEstados(){
		return array("AC"=>"Acre", 
					 "AL"=>"Alagoas", 
					 "AM"=>"Amazonas", 
					 "AP"=>"Amapá",
					 "BA"=>"Bahia",
					 "CE"=>"Ceará",
					 "DF"=>"Distrito Federal",
					 "ES"=>"Espírito Santo",
					 "GO"=>"Goiás",
					 "MA"=>"Maranhão",
					 "MT"=>"Mato Grosso",
					 "MS"=>"Mato Grosso do Sul",
					 "MG"=>"Minas Gerais",
					 "PA"=>"Pará",
					 "PB"=>"Paraíba",
					 "PR"=>"Paraná",
					 "PE"=>"Pernambuco",
					 "PI"=>"Piauí",
					 "RJ"=>"Rio de Janeiro",
					 "RN"=>"Rio Grande do Norte",
					 "RO"=>"Rondônia",
					 "RS"=>"Rio Grande do Sul",
					 "RR"=>"Roraima",
					 "SC"=>"Santa Catarina",
					 "SE"=>"Sergipe",
					 "SP"=>"São Paulo",
					 "TO"=>"Tocantins");
	}
	
	/**
	 * Método que retorna os meses do ano
	 * @static
	 */
	public static function getMeses($index = false) {
		$meses = array("01"=>"Janeiro",
					 "02"=>"Fevereiro",
					 "03"=>"Março",
					 "04"=>"Abril",
					 "05"=>"Maio",
					 "06"=>"Junho",
			  		 "07"=>"Julho",
					 "08"=>"Agosto",
					 "09"=>"Setembro",
					 "10"=>"Outubro",
					 "11"=>"Novembro",
					 "12"=>"Dezembro"); 
		return $index ? $meses[$index]: $meses;
	}
	
	public static function getMes($mes, $invertido = false) {
		$retorno = "";
		if(!$invertido){
			switch ($mes) {
				case "01":
					$retorno = "Janeiro";
					break;			
				case "02":
					$retorno = "Fevereiro";
					break;			
				case "03":
					$retorno = "Marco";
					break;			
				case "04":
					$retorno = "Abril";
					break;			
				case "05":
					$retorno = "Maio";
					break;			
				case "06":
					$retorno = "Junho";
					break;			
				case "07":
					$retorno = "Julho";
					break;			
				case "08":
					$retorno = "Agosto";
					break;			
				case "09":
					$retorno = "Setembro";
					break;			
				case "10":
					$retorno = "Outubro";
					break;			
				case "11":
					$retorno = "Novembro";
					break;
				case "12":
					$retorno = "Dezembro";
					break;		
				default:				
					break;
			}
		}else{
			$mes = strtolower($mes);
			switch ($mes) {
				case "janeiro":
					$retorno = "01";
					break;			
				case "fevereiro":
					$retorno = "02";
					break;			
				case "marco":
					$retorno = "03";
					break;			
				case "abril":
					$retorno = "04";
					break;			
				case "maio":
					$retorno = "05";
					break;			
				case "junho":
					$retorno = "06";
					break;			
				case "julho":
					$retorno = "07";
					break;			
				case "agosto":
					$retorno = "08";
					break;			
				case "setembro":
					$retorno = "09";
					break;			
				case "outubro":
					$retorno = "10";
					break;			
				case "novembro":
					$retorno = "11";
					break;
				case "dezembro":
					$retorno = "12";
					break;		
				default:				
					break;
			}
		}
		return $retorno;
	}
	
	public static function procurarFilhos($paiId, $acos){
		$filhos = array();
		$count = 0;
		foreach($acos as $aco){		
			if ($aco[0]['parent_id'] == $paiId){	
				$filhos[$count][] = $aco[0];
				$count++;	
			}				
		}		
		return $filhos;		
	}
	
	public static function anos(){
		$anos = array();
		for ($x=(date("Y")+10);$x>1940;$x--){
			$anos[$x] = $x;
		}
		return $anos;
	}
	
	public static function getTotalAnomalias($indicador){
		$totalAnomalia = array();
		$ano = $_SESSION['ano_selecionado_indicadores'];
		$totalAnomalia[$ano]["01"] = 0;
		$totalAnomalia[$ano]["02"] = 0;
		$totalAnomalia[$ano]["03"] = 0;
		$totalAnomalia[$ano]["04"] = 0;
		$totalAnomalia[$ano]["05"] = 0;
		$totalAnomalia[$ano]["06"] = 0;
		$totalAnomalia[$ano]["07"] = 0;
		$totalAnomalia[$ano]["08"] = 0;
		$totalAnomalia[$ano]["09"] = 0;
		$totalAnomalia[$ano]["10"] = 0;
		$totalAnomalia[$ano]["11"] = 0;
		$totalAnomalia[$ano]["12"] = 0;
		foreach ($indicador['Anomalia'] as $key => $anomalia) {			
			$data = explode("/",$anomalia['data']);
			$mes = $data[1];
			$ano = $data[2];	
			
			if(isset($totalAnomalia[$ano][$mes])){
				$totalAnomalia[$ano][$mes] += 1;
			}else{
				$totalAnomalia[$ano][$mes] = 1;
			}
			
		}
		return $totalAnomalia;
	}
	
	public static function getTotalIndicador($indicador, $filhos = null){		
		
		/**
		 * Regra pra o tipo do indicador ser inteiro ou decimal
		 */
		 if($indicador['Indicador']['tipo'] == Util::INATIVO){
		 	foreach ($indicador['IndicadorMeta'] as $key => $value) {
				 $resultado = str_replace(".", "", $value);
				 $resultado = str_replace(",", ".", $resultado);
				 $indicador['IndicadorMeta'][$key] = $resultado;
			 }
			 foreach ($indicador['IndicadorRealizado'] as $key => $value) {
				 $resultado = str_replace(".", "", $value);
				 $resultado = str_replace(",", ".", $resultado);
				 $indicador['IndicadorRealizado'][$key] = $resultado;
			 }
		 }
			
		$totalIndicador = array();		
		$count = 0;
		foreach($indicador['IndicadorMeta'] as $meta){
			foreach ($indicador['IndicadorRealizado'] as $realizado) {
				if($meta['ano'] == $realizado['ano']){
					$totalIndicador[$count]['janeiro'] = 0;
					$totalIndicador[$count]['fevereiro'] = 0;
					$totalIndicador[$count]['marco'] = 0;
					$totalIndicador[$count]['abril'] = 0;
					$totalIndicador[$count]['maio'] = 0;
					$totalIndicador[$count]['junho'] = 0;
					$totalIndicador[$count]['julho'] = 0;
					$totalIndicador[$count]['agosto'] = 0;
					$totalIndicador[$count]['setembro'] = 0;
					$totalIndicador[$count]['outubro'] = 0;
					$totalIndicador[$count]['novembro'] = 0;
					$totalIndicador[$count]['dezembro'] = 0;
					if($indicador['Indicador']['tipo_calculo'] == Util::TIPO_CALCULO_POSITIVO || $indicador['Indicador']['tipo_calculo'] == Util::TIPO_CALCULO_POSITIVO_NAO_CUMULATIVO){
						if($meta['janeiro'] != 0){
							$totalJaneiro = ($realizado['janeiro']/$meta['janeiro'])*100;
							$totalIndicador[$count]['janeiro'] = (float)number_format($totalJaneiro, 2);						
						}
						if($meta['fevereiro'] != 0){
							$totalJaneiro = ($realizado['fevereiro']/$meta['fevereiro'])*100;
							$totalIndicador[$count]['fevereiro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['marco'] != 0){
							$totalJaneiro = ($realizado['marco']/$meta['marco'])*100;
							$totalIndicador[$count]['marco'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['abril'] != 0){
							$totalJaneiro = ($realizado['abril']/$meta['abril'])*100;
							$totalIndicador[$count]['abril'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['maio'] != 0){
							$totalJaneiro = ($realizado['maio']/$meta['maio'])*100;
							$totalIndicador[$count]['maio'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['junho'] != 0){
							$totalJaneiro = ($realizado['junho']/$meta['junho'])*100;
							$totalIndicador[$count]['junho'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['julho'] != 0){
							$totalJaneiro = ($realizado['julho']/$meta['julho'])*100;
							$totalIndicador[$count]['julho'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['agosto'] != 0){
							$totalJaneiro = ($realizado['agosto']/$meta['agosto'])*100;
							$totalIndicador[$count]['agosto'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['setembro'] != 0){
							$totalJaneiro = ($realizado['setembro']/$meta['setembro'])*100;
							$totalIndicador[$count]['setembro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['outubro'] != 0){
							$totalJaneiro = ($realizado['outubro']/$meta['outubro'])*100;
							$totalIndicador[$count]['outubro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['novembro'] != 0){
							$totalJaneiro = ($realizado['novembro']/$meta['novembro'])*100;
							$totalIndicador[$count]['novembro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['dezembro'] != 0){
							$totalJaneiro = ($realizado['dezembro']/$meta['dezembro'])*100;
							$totalIndicador[$count]['dezembro'] = (float)number_format($totalJaneiro, 2);
							
						}					
					}else{
						if($meta['janeiro'] != 0){
							$totalJaneiro = ($meta['janeiro']/$realizado['janeiro'])*100;
							$totalIndicador[$count]['janeiro'] = (float)number_format($totalJaneiro, 2);						
						}
						if($meta['fevereiro'] != 0){
							$totalJaneiro = ($meta['fevereiro']/$realizado['fevereiro'])*100;
							$totalIndicador[$count]['fevereiro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['marco'] != 0){
							$totalJaneiro = ($meta['marco']/$realizado['marco'])*100;
							$totalIndicador[$count]['marco'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['abril'] != 0){
							$totalJaneiro = ($meta['abril']/$realizado['abril'])*100;
							$totalIndicador[$count]['abril'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['maio'] != 0){
							$totalJaneiro = ($meta['maio']/$realizado['maio'])*100;
							$totalIndicador[$count]['maio'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['junho'] != 0){
							$totalJaneiro = ($meta['junho']/$realizado['junho'])*100;
							$totalIndicador[$count]['junho'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['julho'] != 0){
							$totalJaneiro = ($meta['julho']/$realizado['julho'])*100;
							$totalIndicador[$count]['julho'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['agosto'] != 0){
							$totalJaneiro = ($meta['agosto']/$realizado['agosto'])*100;
							$totalIndicador[$count]['agosto'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['setembro'] != 0){
							$totalJaneiro = ($meta['setembro']/$realizado['setembro'])*100;
							$totalIndicador[$count]['setembro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['outubro'] != 0){
							$totalJaneiro = ($meta['outubro']/$realizado['outubro'])*100;
							$totalIndicador[$count]['outubro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['novembro'] != 0){
							$totalJaneiro = ($meta['novembro']/$realizado['novembro'])*100;
							$totalIndicador[$count]['novembro'] = (float)number_format($totalJaneiro, 2);
							
						}
						if($meta['dezembro'] != 0){
							$totalJaneiro = ($meta['dezembro']/$realizado['dezembro'])*100;
							$totalIndicador[$count]['dezembro'] = (float)number_format($totalJaneiro, 2);
							
						}	
					}
					$totalIndicador[$count]['ano'] = $meta['ano'];
					$count++;
					
				}
			}
		}		
		
		return $totalIndicador;
		
	}
	
	/**
	 * Terminar esta função
	 */
	public static function getMetaTotal($indicador, $ano = null){
		$total = 0;
		/**
		 * Regra pra o tipo do indicador ser inteiro ou decimal
		 */
		 if($indicador['Indicador']['tipo'] == Util::INATIVO){		 	
		 		if($ano == null){
		 			foreach ($indicador['IndicadorMeta'] as $chaveMeta => $meta) {
				 		if($meta['ano'] == $_SESSION['ano_selecionado_indicadores']){
					 		foreach ($meta as $key => $value) {
					 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano' ){
					 				$resultado = str_replace(".", "", $value);
							 		$resultado = str_replace(",", ".", $resultado);
									$total += $resultado;
					 			}					  
							 }
						}
					}
				}else{
					foreach($indicador['IndicadorRealizado'] as $chaveRealizado => $realizado){
						if($realizado['ano'] == ($_SESSION['ano_selecionado_indicadores'] - 1)){
					 		foreach ($realizado as $key => $value) {
					 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano' ){
					 				$resultado = str_replace(".", "", $value);
							 		$resultado = str_replace(",", ".", $resultado);
									$total += $resultado;
					 			}					  
							 }
						}
					}					
				}			 
		 }else{		 	
		 		if($ano == null){
		 			foreach ($indicador['IndicadorMeta'] as $chaveMeta => $meta) {
				 		if($meta['ano'] == $_SESSION['ano_selecionado_indicadores']){
					 		foreach ($meta as $key => $value) {
					 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano'){
									$total += $value;
					 			}					  
							 }
						}
					}
				}else{
					foreach($indicador['IndicadorRealizado'] as $chaveRealizado => $realizado){
						if($realizado['ano'] == ($_SESSION['ano_selecionado_indicadores'] - 1)){
					 		foreach ($realizado as $key => $value) {
					 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano' ){
									$total += $value;
					 			}					  
							 }
						}
					}					
				}		
			 }
		 
		 return (float)$total;
		 
	}
	
	public static function getProjecao($indicador){
		$totalMeta = 0;
		$totalRealizado = 0;
		/**
		 * Regra pra o tipo do indicador ser inteiro ou decimal
		 */
		 if($indicador['Indicador']['tipo'] == Util::INATIVO){
		 	foreach ($indicador['IndicadorMeta'] as $chaveMeta => $meta) {
		 		if($meta['ano'] == $_SESSION['ano_selecionado_indicadores']){
		 			$achouMes = 0;
			 		foreach ($meta as $key => $value) {
			 			if($key == strtolower(Util::getMes(date("m")+1)) && $achouMes == 0){
							$achouMes = 1;
						}
			 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano' && $achouMes == 1){
			 				$resultado = str_replace(".", "", $value);
					 		$resultado = str_replace(",", ".", $resultado);
							$totalMeta += $resultado;
			 			}
								  
					 }
				}			
			 }
			foreach ($indicador['IndicadorRealizado'] as $chaveMeta => $realizado) {
				if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
			 		foreach ($realizado as $key => $value) {
			 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano'){
			 				$resultado = str_replace(".", "", $value);
					 		$resultado = str_replace(",", ".", $resultado);
							$totalRealizado += $resultado;
			 			}
						if($key == strtolower(Util::getMes(date("m")))){
							break;
						}					  
					 }
				}			
			 }
		 }else{
		 	foreach ($indicador['IndicadorMeta'] as $chaveMeta => $meta) {
		 		if($meta['ano'] == $_SESSION['ano_selecionado_indicadores']){
			 		$achouMes = 0;
			 		foreach ($meta as $key => $value) {
			 			if($key == strtolower(Util::getMes(date("m"))) && $achouMes == 0){
							$achouMes = 1;
						}
			 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano' && $achouMes == 1){
							$totalMeta += $value;
			 			}
								  
					 }
				}			
			 }
			foreach ($indicador['IndicadorRealizado'] as $chaveMeta => $realizado) {
				if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
			 		foreach ($realizado as $key => $value) {
			 			if($key != 'id' && $key != 'indicador_id' && $key != 'ano'){
							$totalRealizado += $value;
			 			}
						if($key == strtolower(Util::getMes(date("m")))){
							break;
						}				  
					 }
				}			
			 }
		 }
		 
		 $retorno = number_format(($totalMeta+$totalRealizado)/12, 2);
		 
		 return $retorno;
	}

	public static function getDesvio($meta, $realizado){
		$meta = str_replace(".", "", $meta);
		$meta = str_replace(",", ".", $meta);
		
		$realizado = str_replace(".", "", $realizado);
		$realizado = str_replace(",", ".", $realizado);
		
		$resultado = $meta - $realizado;
		
		$resultado = number_format($resultado, 2, ",", ".");
		
		return $resultado;
	}
	
	public static function trataNumero($numero, $inverso = true){
		$retorno = false;
		if($inverso){
			$numero = str_replace(".", "", $numero);
			$numero = str_replace(",", ".", $numero);
			$retorno = $numero;
		}else{
			$numero = number_format($numero, 2, ",", ".");
			$retorno = $numero;
		}
		return $retorno;
	}
	
	public static function difData($d1, $d2, $type='', $sep='/'){
		$d1 = explode($sep, $d1);
		$d2 = explode($sep, $d2);
		switch ($type){
			case 'A':
				$X = 31536000;
				break;
			case 'M':
				$X = 2592000;
				break;
			case 'D':
				$X = 86400;
				break;
			case 'H':
				$X = 3600;
				break;
			case 'MI':
				$X = 60;
				break;
			default:
				$X = 1;
		}
		return floor(((mktime(0, 0, 0, $d2[1], $d2[0], $d2[2]) - mktime(0, 0, 0, $d1[1], $d1[0], $d1[2]))/$X));
	}
}
?>