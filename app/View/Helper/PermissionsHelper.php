<?php

App::uses('AppHelper', 'View/Helper');

class PermissionsHelper extends AppHelper {
    
    var $helpers = array('Session');
    
    function check($path){
        if($this->Session->check('Auth.Permissions.'.$path)
        && $this->Session->read('Auth.Permissions.'.$path) === true){
            return true;
        }
        return false;
    }
}
?>