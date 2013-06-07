<?php
echo $this->Session->flash();
echo $this->BSForm->create('User', array( 'controller' => 'Users', 'action' => 'login' ) );
echo $this->BSForm->input('username');
echo $this->BSForm->input('password');
echo $this->BSForm->end('Login');
?>