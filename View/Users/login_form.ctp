<?php
echo $this->Session->flash();
echo $this->Form->create('User', array( 'controller' => 'Users', 'action' => 'login' ) );
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Login');
?>