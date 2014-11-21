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
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::import("Lib", "Util");

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	const PERPAGE = 20;

	public $paginate = array();
	
	public $usuarioLogado = null;
	
	public $helpers = array('Js' => array('Jquery'), 'Form', 'FilterResults.FilterForm');
	
	public $components = array(
		'ControleDeAcesso',
		'Session',
		'Audit',
		'FilterResults.FilterResults' => array(
	        'auto' => array(
	            'paginate' => false,
	            'explode'  => true,  // recomendado
	        ),
	        'explode' => array(
	            'character'   => ' ',
	            'concatenate' => 'AND',
	        )
	    ),
	    'Auth' => array(
	        'loginAction' => array(
	            'controller' => 'autenticacao',
	            'action' => 'index'
	        ),
	        'authError' => 'Acesso restrito',
	        'loginRedirect' => array('action'=>'index','controller'=>'aplicacao'),
	        'logoutRedirect' => array('action'=>'index','controller'=>'autenticacao'),
	        'authenticate' => array(
	            'Form' => array(
	                'fields' => array('username' => 'login', 'password' => 'senha'),
	        		'userModel' => 'Usuario',
	        		'scope' => array('Usuario.status' => Util::ATIVO)
	            )
	        )
	    )	    
	);

	public function beforeRender(){
		if(!$this->ControleDeAcesso->validaAcessoAcao()){
			$this->Session->setFlash("Você não tem permissão para essa ação!");
			$this->redirect(array('controller'=>'aplicacao','action'=>'index'));
		}
		$this->set('title_for_layout', $this->title);
		$this->set('tituloPagina', $this->tituloPagina);
		$this->set('controller', $this->request->params['controller']);
		$this->set('action', $this->request->params['action']);
		$this->set('body_id', strtolower($this->name . '-body'));
        $this->set('body_class', strtolower('body-' . $this->name . '-' . $this->action));
        $this->set('usuarioLogado', $this->usuarioLogado);
	}
	
	function beforeFilter() {
		AuthComponent::$sessionKey = "Auth.Indicadores";
        $this->paginate['limit'] = 20;
        $this->usuarioLogado = $this->Auth->user();
    }
    
    public function paginacao($registros, $total, $pagina = 1, $perpage = self::PERPAGE){
    	$this->set('totalRegistros', $total);
    	$this->set('paginaAtual', $pagina);
    	$this->set('limitPagina', $perpage);
    	$this->set('totalPaginas', ceil($total / $perpage));
    	$this->set('countRegistros', count($registros));
    	$this->set('offset', $this->offset($pagina, $perpage));
    }
    
    public function offset($pagina, $perpage = self::PERPAGE){
    	return (($pagina - 1) * $perpage);
    }
    
}
