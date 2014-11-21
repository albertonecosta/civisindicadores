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

App::uses('AppHelper', 'View/Helper');
App::import('Lib', 'ControleDeAcesso');

class ControleDeAcessoHelper extends AppHelper {

	private $ControleDeAcesso;
	
	public function validaAcessoElemento($elemnt, $controller=''){
		return $this->_getControleDeAcesso()->validaAcessoElemento($elemnt, $this->_getController($controller));
	}
	
	public function _getController($controller=''){
		if(empty($controller)){
				$controller = strtoupper(substr($this->request->params['controller'], 0,1)).substr($this->request->params['controller'], 1);
		}
		return $controller;
	}
	
	private function _getControleDeAcesso(){
		if(!$this->ControleDeAcesso instanceof ControleDeAcesso)
			$this->ControleDeAcesso = new ControleDeAcesso(null, null);
		return $this->ControleDeAcesso;
	}
}



