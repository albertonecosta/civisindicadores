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
 * IndicadorMeta Model
 *
 * @property Usuario $Usuario
 */
class IndicadorMeta extends AppModel {

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
		if(isset($this->data['IndicadorMeta']["janeiro"]) && !empty($this->data['IndicadorMeta']["janeiro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["janeiro"]);
			$this->data['IndicadorMeta']["janeiro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["fevereiro"]) && !empty($this->data['IndicadorMeta']["fevereiro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["fevereiro"]);
			$this->data['IndicadorMeta']["fevereiro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["marco"]) && !empty($this->data['IndicadorMeta']["marco"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["marco"]);
			$this->data['IndicadorMeta']["marco"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["abril"]) && !empty($this->data['IndicadorMeta']["abril"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["abril"]);
			$this->data['IndicadorMeta']["abril"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["maio"]) && !empty($this->data['IndicadorMeta']["maio"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["maio"]);
			$this->data['IndicadorMeta']["maio"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["junho"]) && !empty($this->data['IndicadorMeta']["junho"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["junho"]);
			$this->data['IndicadorMeta']["junho"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["julho"]) && !empty($this->data['IndicadorMeta']["julho"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["julho"]);
			$this->data['IndicadorMeta']["julho"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["agosto"]) && !empty($this->data['IndicadorMeta']["agosto"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["agosto"]);
			$this->data['IndicadorMeta']["agosto"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["setembro"]) && !empty($this->data['IndicadorMeta']["setembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["setembro"]);
			$this->data['IndicadorMeta']["setembro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["outubro"]) && !empty($this->data['IndicadorMeta']["outubro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["outubro"]);
			$this->data['IndicadorMeta']["outubro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["novembro"]) && !empty($this->data['IndicadorMeta']["novembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["novembro"]);
			$this->data['IndicadorMeta']["novembro"] = str_replace(",", ".", $valor);
		}
		if(isset($this->data['IndicadorMeta']["dezembro"]) && !empty($this->data['IndicadorMeta']["dezembro"])){
			$valor = str_replace(".", "", $this->data['IndicadorMeta']["dezembro"]);
			$this->data['IndicadorMeta']["dezembro"] = str_replace(",", ".", $valor);
		}
	}
	
	public function afterFind($results){
		foreach($results as $key=>$model){
			if(isset($model["IndicadorMeta"])){
				if(isset($model['IndicadorMeta']["janeiro"])){
					$results[$key]['IndicadorMeta']["janeiro"] = number_format($model['IndicadorMeta']["janeiro"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["fevereiro"])){
					$results[$key]['IndicadorMeta']["fevereiro"] = number_format($model['IndicadorMeta']["fevereiro"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["marco"])){
					$results[$key]['IndicadorMeta']["marco"] = number_format($model['IndicadorMeta']["marco"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["abril"])){
					$results[$key]['IndicadorMeta']["abril"] = number_format($model['IndicadorMeta']["abril"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["maio"])){
					$results[$key]['IndicadorMeta']["maio"] = number_format($model['IndicadorMeta']["maio"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["junho"])){
					$results[$key]['IndicadorMeta']["junho"] = number_format($model['IndicadorMeta']["junho"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["julho"])){
					$results[$key]['IndicadorMeta']["julho"] = number_format($model['IndicadorMeta']["julho"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["agosto"])){
					$results[$key]['IndicadorMeta']["agosto"] = number_format($model['IndicadorMeta']["agosto"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["setembro"])){
					$results[$key]['IndicadorMeta']["setembro"] = number_format($model['IndicadorMeta']["setembro"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["outubro"])){
					$results[$key]['IndicadorMeta']["outubro"] = number_format($model['IndicadorMeta']["outubro"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["novembro"])){
					$results[$key]['IndicadorMeta']["novembro"] = number_format($model['IndicadorMeta']["novembro"], 2,',','.');
				}
				if(isset($model['IndicadorMeta']["dezembro"])){
					$results[$key]['IndicadorMeta']["dezembro"] = number_format($model['IndicadorMeta']["dezembro"], 2,',','.');
				}
			}
			
		}
		return $results;
	}

}
