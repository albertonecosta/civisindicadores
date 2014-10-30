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
App::uses('AppModel', 'Model');
/**
 * IndicadorRealizado Model
 *
 * @property Usuario $Usuario
 */
class IndicadorRealizado extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Indicador' => array(
			'className' => 'Indicador',
			'foreignKey' => 'indicador_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function beforeSave($options){
		if(isset($this->data['IndicadorRealizado']["janeiro"]) && !empty($this->data['IndicadorRealizado']["janeiro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["janeiro"]);
			$this->data['IndicadorRealizado']["janeiro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["fevereiro"]) && !empty($this->data['IndicadorRealizado']["fevereiro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["fevereiro"]);
			$this->data['IndicadorRealizado']["fevereiro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["marco"]) && !empty($this->data['IndicadorRealizado']["marco"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["marco"]);
			$this->data['IndicadorRealizado']["marco"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["abril"]) && !empty($this->data['IndicadorRealizado']["abril"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["abril"]);
			$this->data['IndicadorRealizado']["abril"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["maio"]) && !empty($this->data['IndicadorRealizado']["maio"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["maio"]);
			$this->data['IndicadorRealizado']["maio"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["junho"]) && !empty($this->data['IndicadorRealizado']["junho"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["junho"]);
			$this->data['IndicadorRealizado']["junho"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["julho"]) && !empty($this->data['IndicadorRealizado']["julho"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["julho"]);
			$this->data['IndicadorRealizado']["julho"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["agosto"]) && !empty($this->data['IndicadorRealizado']["agosto"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["agosto"]);
			$this->data['IndicadorRealizado']["agosto"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["setembro"]) && !empty($this->data['IndicadorRealizado']["setembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["setembro"]);
			$this->data['IndicadorRealizado']["setembro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["outubro"]) && !empty($this->data['IndicadorRealizado']["outubro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["outubro"]);
			$this->data['IndicadorRealizado']["outubro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["novembro"]) && !empty($this->data['IndicadorRealizado']["novembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["novembro"]);
			$this->data['IndicadorRealizado']["novembro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorRealizado']["dezembro"]) && !empty($this->data['IndicadorRealizado']["dezembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorRealizado']["dezembro"]);
			$this->data['IndicadorRealizado']["dezembro"] = str_replace(",", ".", $valor);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["IndicadorRealizado"])){
				if(isset($model['IndicadorRealizado']["janeiro"])){
					$results[$key]['IndicadorRealizado']["janeiro"] = number_format($model['IndicadorRealizado']["janeiro"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["fevereiro"])){
					$results[$key]['IndicadorRealizado']["fevereiro"] = number_format($model['IndicadorRealizado']["fevereiro"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["marco"])){
					$results[$key]['IndicadorRealizado']["marco"] = number_format($model['IndicadorRealizado']["marco"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["abril"])){
					$results[$key]['IndicadorRealizado']["abril"] = number_format($model['IndicadorRealizado']["abril"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["maio"])){
					$results[$key]['IndicadorRealizado']["maio"] = number_format($model['IndicadorRealizado']["maio"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["junho"])){
					$results[$key]['IndicadorRealizado']["junho"] = number_format($model['IndicadorRealizado']["junho"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["julho"])){
					$results[$key]['IndicadorRealizado']["julho"] = number_format($model['IndicadorRealizado']["julho"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["agosto"])){
					$results[$key]['IndicadorRealizado']["agosto"] = number_format($model['IndicadorRealizado']["agosto"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["setembro"])){
					$results[$key]['IndicadorRealizado']["setembro"] = number_format($model['IndicadorRealizado']["setembro"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["outubro"])){
					$results[$key]['IndicadorRealizado']["outubro"] = number_format($model['IndicadorRealizado']["outubro"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["novembro"])){
					$results[$key]['IndicadorRealizado']["novembro"] = number_format($model['IndicadorRealizado']["novembro"], 2,',','.');
				}
				if(isset($model['IndicadorRealizado']["dezembro"])){
					$results[$key]['IndicadorRealizado']["dezembro"] = number_format($model['IndicadorRealizado']["dezembro"], 2,',','.');
				}
			}
			
		}
		return $results;
	}

}
