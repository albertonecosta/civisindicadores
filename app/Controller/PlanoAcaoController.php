<?php
App::uses('AppController', 'Controller');
/**
 * 
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 

 * PlanoAcao Controller
 *
 * @property PlanoAcao $PlanoAcao
 * @property SessionComponent $Session
 */
class PlanoAcaoController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->FilterResults->addFilters(
	        array(
	            'filter1' => array(
	                'PlanoAcao.titulo' => array(
	                    'operator' => 'ILIKE',
	        			'explode' => array(
	        				'character' => ' ',
	        				'concatenate' => 'OR'
	        			),
	                    'value' => array(
	                        'before' => '%', // opcional
	                        'after'  => '%'  // opcional
	                    )
	                )
	            )
	        )
	    );
		
	    // Define conditions
    	$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());
		
		$this->PlanoAcao->recursive = 0;
		
		$this->paginate['conditions'][] = array('PlanoAcao.status = ' => Util::ATIVO);
		$this->paginate['order'] = array('PlanoAcao.titulo' => 'asc');
		
		$this->set('planoAcao', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function visualizar($id = null) {
		$this->PlanoAcao->id = $id;
		$this->PlanoAcao->recursive = 2;
		if (!$this->PlanoAcao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		$this->set('planoAcao', $this->PlanoAcao->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function adicionar() {
		if ($this->request->is('post')) {
			$this->PlanoAcao->create();
			if ($this->PlanoAcao->save($this->request->data)) {
				$this->loadModel("AcaoPlanoAcao");
				foreach($this->request->data['PlanoAcao']['acoes'] as $acoes){					
					$this->request->data['AcaoPlanoAcao']['plano_acao_id'] = $this->PlanoAcao->id;
					$this->request->data['AcaoPlanoAcao']['acao_id'] = $acoes;
					$this->AcaoPlanoAcao->save($this->request->data);
					$this->AcaoPlanoAcao->id = null;					
				}		
				
				$this->Audit->salvar($this->request->data, "Plano de Ação", array(), "adicionar", true, $this->PlanoAcao->id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_ADICIONADO_FALHA), 'alert');
			}
		}
		
		$this->loadModel("Acao");
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
	
		$this->set("acoes", $acoes);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function editar($id = null) {
		$this->PlanoAcao->id = $id;
		$this->PlanoAcao->read();
		$acaoPlanoAcao = $this->PlanoAcao->data['AcaoPlanoAcao'];
		if (!$this->PlanoAcao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PlanoAcao->save($this->request->data)) {
				$this->loadModel("AcaoPlanoAcao");
				foreach($acaoPlanoAcao as $acPlAc){
					$this->PlanoAcao->query("delete from acao_plano_acao where id = {$acPlAc['id']}");
				}
				if(is_array($this->request->data['PlanoAcao']['acoes'])){
					foreach($this->request->data['PlanoAcao']['acoes'] as $acoes){					
						$this->request->data['AcaoPlanoAcao']['plano_acao_id'] = $this->PlanoAcao->id;
						$this->request->data['AcaoPlanoAcao']['acao_id'] = $acoes;
						$this->AcaoPlanoAcao->save($this->request->data);
						$this->AcaoPlanoAcao->id = null;					
					}
				}				
				$this->Audit->salvar($this->request->data, "Plano de Ação", array(), "editar", false, $id, $this->Auth->user("id"));
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_SUCESSO), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(Util::REGISTRO_EDITADO_FALHA), 'alert');
			}
		}
		
		$this->request->data = $this->PlanoAcao->read(null, $id);
		
		$array = $this->request->data["AcaoPlanoAcao"];
		$selected = array();
		foreach($array as $campos){
			$selected[] = $campos['acao_id'];
		}	
		
		$this->loadModel("Acao");
		$acoes = $this->Acao->find('list', array('conditions' => array('Acao.status !=' =>Util::INATIVO), 'fields' => array('Acao.id', 'Acao.titulo')));
	
		$this->set("acoes", $acoes);
		$this->set('selected',$selected);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function excluir($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PlanoAcao->id = $id;
		if (!$this->PlanoAcao->exists()) {
			throw new NotFoundException(__(Util::REGISTRO_NAO_ENCONTRADO));
		}
		if ($this->PlanoAcao->saveField('status', Util::INATIVO)) {
			$this->Audit->salvar("", "Plano de Ação", array(), "excluir", false, $id, $this->Auth->user("id"));
			$this->Session->setFlash(__(Util::REGISTRO_DELETADO_SUCESSO), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__(Util::REGISTRO_DELETADO_FALHA), 'error');
		$this->redirect(array('action' => 'index'));
	}
}
