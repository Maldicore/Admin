<?php
/**
 * Default Layout
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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($pluralHumanName) ? str_replace('Admin ', '', $pluralHumanName) . ' - ' : '' ?><?php echo __('Admin'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
        <?php echo $this->Html->css('/Admin/css/bootstrap-wysihtml5-0.0.2'); ?>
        <?php echo $this->Html->css('/Admin/css/datepicker'); ?>
        <?php echo $this->Html->css('/Admin/css/styles'); ?>
        <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>        
        <?php //echo $this->Html->script('/Admin/js/advanced'); ?>
        <?php echo $this->Html->script('/Admin/js/wysihtml5-0.3.0_rc2'); ?>
        <?php echo $this->Html->script('/Admin/js/bootstrap.min'); ?>
        <?php echo $this->Html->script('/Admin/js/bootstrap-wysihtml5-0.0.2'); ?>
        <?php echo $this->Html->script('/Admin/js/bootstrap-datepicker'); ?>
        <?php echo $this->Html->script('/Admin/js/jquery.dataTables'); ?>
        <?php echo $this->Html->script('/Admin/js/scripts'); ?>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php echo $this->Html->meta('icon'); ?>
    </head>
    <body>
        <div class="navbar navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?php echo $this->Html->link(__('Admin'), array('plugin' => 'admin', 'controller' => 'admin', 'action' => 'index'), array('class' => 'brand')); ?>
                    <div class="nav-collapse">
                        <?php if (isset($navbar)): ?>
                        <?php $menuItem = 0; ?>
                            <ul class="nav">
                                <?php foreach ($navbar as $nav): ?>
                                <?php 
                                    if($menuItem == 7){
                                 ?>
                                 <ul class="nav nav-tabs">
                                  <li class="dropdown">
                                    <a class="dropdown-toggle"
                                       data-toggle="dropdown"
                                       href="#">
                                        More
                                        <b class="caret"></b>
                                      </a>
                                    <ul class="dropdown-menu">
                                    <li<?php echo $nav['url']['controller'] == $this->request['controller'] ? ' class="active"' : ''; ?>><?php echo $this->Html->link($nav['title'], $nav['url']); ?></li>
                                <?php } else { ?>
                                    <li<?php echo $nav['url']['controller'] == $this->request['controller'] ? ' class="active"' : ''; ?>><?php echo $this->Html->link($nav['title'], $nav['url']); ?></li>
                                <?php } ?>
                                <?php $menuItem += 1; ?>
                                <?php endforeach; ?>
                                <?php 
                                    if($menuItem>7){
                                 ?>
                                    </ul>
                                  </li>
                                </ul>
                                <?php } ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="nav-collapse pull-right">
                        <ul class="nav">
                            <li><?php echo $this->Html->link(__('Visit Site'), '/'); ?></li>
                            <li><?php echo $this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php echo $this->fetch('content'); ?>
            </div>
            <hr>
            <div class="row-fluid">
                <?php //echo str_replace('class="cake-sql-log"', 'class="table table-bordered table-striped"', $this->element('sql_dump')); ?>
                <?php // debug($this); ?>
                <p style="text-align:center;">Powered by: <a href="#">CakePHP Admin Plugin</a></p>
            </div>
        </div>
    </body>
</html>
