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
App::uses('AppController', 'Controller');
/**
 * Auditoria Controller
 *
 * @property Auditoria $Auditoria
 * @property SessionComponent $Session
 */
class AuditoriaController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'Auditoria.created' => array(
	                    'operator' => 'BETWEEN',
	        			'between' => array(
	        				'text' => __(' e ', true),
	        				'date' => true
	        			)
	                )
	            )
	        )
	    );
		
	    // Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->Auditoria->recursive = 2;
		
		$this->paginate['order'] = array('Auditoria.created' => 'desc');
		
		$this->set('auditoria', $this->paginate());
	}
	
	public function visualizar($id = null) {
		
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('auditoria', $this->Auditoria->read(null, $id));
		
	}
	
}