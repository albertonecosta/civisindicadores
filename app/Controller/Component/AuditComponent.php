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
App::uses("Auditoria", "Model");
App::uses("AuditoriaCampos", "Model");

class AuditComponent extends Component {
	
    public function setDadosAntes($dados){
    	$_SESSION['dados_a_salvar'] = $dados;
    }
	
	public function getDadosAntes(){
		if(isset($_SESSION['dados_a_salvar'])){
			$dados = $_SESSION['dados_a_salvar'];
			unset($_SESSION['dados_a_salvar']);
			return $dados;
		}else{
			return false;
		}
	}
	
	/**
	 * Esta função recebe um array $dados, com os campos e os valores que serão salvos no banco, alem do controller
	 * onde foi disparada a ação o model que está sendo alterado e a ação do controller
	 */
	public function salvar($dados, $aliasController, $arrayModel, $aliasAcao, $limparSession = false, $id_elemento, $id_usuario){
		if($limparSession){
			if(isset($_SESSION['dados_a_salvar'])){
				unset($_SESSION['dados_a_salvar']);
			}
		}
		
		$this->Auditoria = new Auditoria;
		$this->AuditoriaCampos = new AuditoriaCampos;
		
		$dados_antes = $this->getDadosAntes();
		if(is_array($dados)){
			if($dados_antes){
				$auditoria_data = array("Auditoria" => array("alias_controller" => $aliasController, "alias_acao" => $aliasAcao, "usuario_id" => $id_usuario, "elemento_id" => $id_elemento));
				if($this->Auditoria->save($auditoria_data)){
					$auditoria_campos_data = array();
					foreach($dados as $key => $value){
						foreach($dados_antes as $key2 => $value2){												
							if($key == $key2){
								if(is_array($value2)){
									$value2 = serialize($value2);
									$value = serialize($value);
								}
								if($value != $value2){
									$auditoria_campos_data['AuditoriaCampos']['valor_antigo'] = $value2;
									$auditoria_campos_data['AuditoriaCampos']['alias_model'] = $key;
									$auditoria_campos_data['AuditoriaCampos']['valor_novo'] = $value;
									$auditoria_campos_data['AuditoriaCampos']['auditoria_id'] = $this->Auditoria->id;
									if(!$this->AuditoriaCampos->save($auditoria_campos_data)){
										throw new CakeException("Um erro ocorreu ao tentar salvar o log de dados");					
									}
									$this->AuditoriaCampos->id = null;
								}
							}
						}
					}
				}			
			}else{
				$auditoria_data = array("Auditoria" => array("alias_controller" => $aliasController, "alias_acao" => $aliasAcao, "usuario_id" => $id_usuario, "elemento_id" => $id_elemento));			
				
				if($this->Auditoria->save($auditoria_data)){
					$auditoria_campos_data = array();
					if(count($arrayModel) > 0){
						foreach($arrayModel as $model){
							foreach($dados as $key => $value){
								if($key == $model){
									$auditoria_campos_data['AuditoriaCampos']['alias_model'] = $key;
									if(is_array($value)){
										$value = serialize($value);
									}
									$auditoria_campos_data['AuditoriaCampos']['valor_novo'] = $value;
									$auditoria_campos_data['AuditoriaCampos']['auditoria_id'] = $this->Auditoria->id;
									if(!$this->AuditoriaCampos->save($auditoria_campos_data)){
										throw new CakeException("Um erro ocorreu ao tentar salvar o log de dados");					
									}
									$this->AuditoriaCampos->id = null;
								}
							}
						}
					}else{
						foreach($dados as $key => $value){
							$auditoria_campos_data['AuditoriaCampos']['alias_model'] = $key;
							if(is_array($value)){
								$value = serialize($value);
							}
							$auditoria_campos_data['AuditoriaCampos']['valor_novo'] = $value;
							$auditoria_campos_data['AuditoriaCampos']['auditoria_id'] = $this->Auditoria->id;
							if(!$this->AuditoriaCampos->save($auditoria_campos_data)){
								throw new CakeException("Um erro ocorreu ao tentar salvar o log de dados");					
							}
							$this->AuditoriaCampos->id = null;
						}
					}
				}
			}
		}else{
			$auditoria_data = array("Auditoria" => array("alias_controller" => $aliasController, "alias_acao" => $aliasAcao, "usuario_id" => $_SESSION['Auth']['User']['id'], "elemento_id" => $id_elemento));
			$this->Auditoria->save($auditoria_data);
		}
	}
}
?>