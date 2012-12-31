<?php
/**
 * Admin Index
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
<ul class="nav nav-pills nav-stacked nav-box">
    <?php foreach ($navbar as $nav): ?>
        <?php 
        echo '<li>';
        $icon_link = 'Admin'.DS.'img'.DS.'admin_icons'.DS.$nav['icon'].'.png';
        $style = 'background-image: url('.$icon_link.');background-repeat: no-repeat; background-position: center 50px; background-size: 50%;';
        echo $this->Html->link($nav['title'], $nav['url'], array('class'=>strtolower($nav['icon']), 'style'=>$style));
        echo '</li>';
        ?>
    <?php endforeach; ?>
</ul>
