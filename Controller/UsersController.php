<?php
/**
 * Users Controller
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
 *
 * @author     Yusuf Abdulla Shunan <shunan@maldicore.com>
 * @copyright  Copyright 2012, Maldicore Group Pvt Ltd. (http://maldicore.com)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @since      CakePHP(tm) v 2.1.1
 */

App::uses('AdminAppController', 'Admin.Controller');
App::uses('AppController', 'Controller');

class UsersController extends AdminAppController {
    var $name = 'Users';
    var $helpers = array('Form');

    function login_form() {

    }

    function login() {

        if (empty($this->data['User']['username']) == false) {
                
            $user = $this->User->find('all', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.password' =>md5($this->data['User']['password']))));
            if($user != false) {   
                $this->Session->setFlash('Thank you for logging in!');
                $this->Session->write('User', $user);
                $this->Redirect(array('controller' => '', 'action' => 'index'));
                exit();
            } else {
                $this -> Session -> setFlash('Incorrect username/password!', true);
                $this -> Redirect(array('action' => 'login_form'));
                exit();
            }
        } 
    }

    function logout() {

        $this -> Session -> destroy();
        $this -> Session -> setFlash('You have been logged out!');

        $this -> Redirect(array('action' => 'login_form'));
        exit();
    }

}
