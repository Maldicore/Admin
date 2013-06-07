<?php
/**
 * Scaffold Index
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
<div class="row-fluid">
    <div class="span12">
        <div>
            <p class="nav-header"><?php echo __d('cake', 'Actions'); ?></p>
            <ul class="nav nav-tabs">
                <li><?php echo $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('plugin' => 'admin', 'action' => 'add')); ?></li>
                <?php $done = array(); ?>
                <?php foreach ($associations as $_type => $_data): ?>
                    <?php foreach ($_data as $_alias => $_details): ?>
                        <?php if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)): ?>
                            <li><?php echo $this->Html->link(__d('cake', 'List %s', Inflector::humanize($_details['controller'])), array('plugin' => 'admin', 'controller' => $_details['controller'], 'action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))), array('plugin' => 'admin', 'controller' => $_details['controller'], 'action' => 'add')); ?></li>
                            <?php $done[] = $_details['controller']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php echo $this->Session->flash(); ?>
        <div class="page-header">
            <h1><?php echo str_replace('Admin ', '', $pluralHumanName); ?></h1>
        </div>
        <?php 
            $toDisplayField = $scaffoldFields;
            foreach ($toDisplayField as $key => $value) {
                if(in_array($value, $ignoreFieldList)){
                    unset($toDisplayField[$key]);
                }
            }
         ?>
        <table class="table table-bordered table-striped">
        <!-- <table class="datagrid"> -->
            <thead>
                <tr>
                    <?php foreach ($toDisplayField as $_field): ?>
                        <th><?php echo $this->Paginator->sort($_field); ?></th>
                    <?php endforeach; ?>
                    <th colspan="3"><?php echo __d('cake', 'Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (${$pluralVar} as ${$singularVar}): ?>
                    <tr>
                        <?php foreach ($toDisplayField as $_field): ?>
                            <?php $isKey = false; ?>
                            <?php if (!empty($associations['belongsTo'])): ?>
                                <?php foreach ($associations['belongsTo'] as $_alias => $_details): ?>
                                    <?php if ($_field === $_details['foreignKey']): ?>
                                        <?php $isKey = true; ?>
                                        <td><?php echo $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('plugin' => 'admin', 'controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])); ?></td>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if ($isKey !== true): ?>
                                <?php 
                                    $f_value = h(${$singularVar}[$modelClass][$_field]);
                                    if(isset($displayFieldTypes[$modelClass][$_field])){
                                        if($displayFieldTypes[$modelClass][$_field] == 'image'){
                                            if(!empty($f_value) && file_exists(WWW_ROOT.'img'.DS.$f_value)){
                                                echo '<td>'.$this->Html->image($f_value, array('width' => '220')).'</td>';
                                            } else {
                                                echo '<td>'.$f_value.' (image not found)'.'</td>';
                                            }
                                        }
                                        if($displayFieldTypes[$modelClass][$_field] == 'checkbox'){
                                            echo '<td>';
                                            if($f_value){
                                                echo $this->html->image('/Admin/img/check_yellow.png');
                                            } else {
                                                echo $this->html->image('/Admin/img/cross_red.png');
                                            }
                                            echo '</td>';
                                        }
                                        if($displayFieldTypes[$modelClass][$_field] == 'wysihtml'){
                                            if(strlen($f_value) > 30){
                                            echo '<td class="info">'.substr($f_value,0,30).'<span>'.$f_value.'</span></td>';
                                            } else {
                                                echo '<td>'.$f_value.'</td>';
                                            }
                                        }
                                    } else {
                                        if(strlen($f_value) > 30){
                                            echo '<td class="info">'.substr($f_value,0,30).'<span>'.$f_value.'</span></td>';
                                        } else {
                                            echo '<td>'.$f_value.'</td>';
                                        }
                                    }
                                ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td><?php echo $this->Html->link(__d('cake', 'View'), array('plugin' => 'admin', 'action' => 'view', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-info')); ?></td>
                        <td><?php echo $this->Html->link(__d('cake', 'Edit'), array('plugin' => 'admin', 'action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-warning')); ?></td>
                        <td><?php echo $this->BSForm->postLink(__d('cake', 'Delete'), array('plugin' => 'admin', 'action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-danger'), __d('cake', 'Are you sure you want to delete %s %s?', $modelClass, ${$singularVar}[$modelClass][$primaryKey])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="well">
            <?php echo $this->Paginator->counter(array('format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'))); ?>
        </div>
        <?php if ($this->Paginator->numbers()): ?>
            <div class="pagination">
                <ul>
                    <?php echo $this->Paginator->first(); ?>
                    <?php echo $this->Paginator->prev(); ?>
                    <?php echo $this->Paginator->numbers(); ?>
                    <?php echo $this->Paginator->next(); ?>
                    <?php echo $this->Paginator->last(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
