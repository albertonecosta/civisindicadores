<?php
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