<?php
/**
 * Bootstrap Session Helper
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

App::uses('SessionHelper', 'View/Helper');

class BootstrapSessionHelper extends SessionHelper
{
    /**
     * Flash
     *
     * @param $key string
     * @param $attrs array
     * @return string
     */
    public function flash($key = 'flash', $attrs = array())
    {
        if (empty($attrs['params']['class'])) {
            $attrs['params']['class'] = 'alert';
        }
        return parent::flash($key, $attrs);
    }
}
