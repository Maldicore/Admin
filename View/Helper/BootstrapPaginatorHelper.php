<?php
/**
 * Bootstrap Paginator Helper
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

App::uses('PaginatorHelper', 'View/Helper');

class BootstrapPaginatorHelper extends PaginatorHelper
{
    /**
     * Paging Link
     *
     * @param $which string
     * @param $title string
     * @param $options array
     * @param $disabledTitle string
     * @param $disabledOptions array
     * @return string
     */
    protected function _pagingLink($which, $title = null, $options = array(), $disabledTitle = null, $disabledOptions = array())
    {
        $check = 'has' . $which;
        $_defaults = array(
            'url' => array(),
            'step' => 1,
            'escape' => false,
            'model' => null,
            'tag' => 'li',
            'class' => null
        );
        $options = array_merge($_defaults, (array)$options);
        $paging = $this->params($options['model']);
        if (empty($disabledOptions)) {
            $disabledOptions = $options;
        }
        if (!$this->{$check}($options['model']) && (!empty($disabledTitle) || !empty($disabledOptions))) {
            if (!empty($disabledTitle) && $disabledTitle !== true) {
                $title = $disabledTitle;
            }
            $options = array_merge($_defaults, (array)$disabledOptions);
        } elseif (!$this->{$check}($options['model'])) {
            return null;
        }
        foreach (array_keys($_defaults) as $key) {
            ${$key} = $options[$key];
            unset($options[$key]);
        }
        $url = array_merge(array('page' => $paging['page'] + ($which == 'Prev' ? $step * -1 : $step)), $url);
        $title = ($which == 'Prev') ? '&lsaquo;' : '&rsaquo;';
        unset($options['rel']);
        return $this->Html->tag($tag, $this->link($title, $url, array_merge($options, compact('escape'))), compact('class'));
    }

    /**
     * First
     *
     * @param $first string
     * @param $options array
     * @return string
     */
    public function first($first = '&laquo;', $options = array())
    {
        $defaults = array(
            'tag' => 'li',
            'after' => null,
            'model' => $this->defaultModel(),
            'separator' => null,
            'ellipsis' => '...',
            'class' => null,
            'escape' => false
        );
        $options += $defaults;
        $params = array_merge(array('page' => 1), (array)$this->params($options['model']));
        unset($options['model']);
        if ($params['pageCount'] <= 1) {
            return false;
        }
        extract($options);
        unset($options['tag'], $options['after'], $options['model'], $options['separator'], $options['ellipsis'], $options['class']);
        $out = '';
        if (is_int($first) && $params['page'] >= $first) {
            if ($after === null) {
                $after = $ellipsis;
            }
            for ($i = 1; $i <= $first; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'));
                if ($i != $first) {
                    $out .= $separator;
                }
            }
            $out .= $after;
        } elseif ($params['page'] > 1 && is_string($first)) {
            $out = $this->Html->tag($tag, $this->link($first, array('page' => 1), $options), compact('class')) . $after;
        }
        return $out;
    }

    /**
     * Last
     *
     * @param $last string
     * @param $options array
     * @return string
     */
    public function last($last = '&raquo;', $options = array())
    {
        $options = array_merge(
            array(
                'tag' => 'li',
                'before' => null,
                'model' => $this->defaultModel(),
                'separator' => ' | ',
                'ellipsis' => '...',
                'class' => null,
                'escape' => false
            ),
        (array)$options);
        $params = array_merge(array('page' => 1), (array)$this->params($options['model']));
        unset($options['model']);
        if ($params['pageCount'] <= 1) {
            return false;
        }
        extract($options);
        unset($options['tag'], $options['before'], $options['model'], $options['separator'], $options['ellipsis'], $options['class']);
        $out = '';
        $lower = $params['pageCount'] - $last + 1;
        if (is_int($last) && $params['page'] <= $lower) {
            if ($before === null) {
                $before = $ellipsis;
            }
            for ($i = $lower; $i <= $params['pageCount']; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'));
                if ($i != $params['pageCount']) {
                    $out .= $separator;
                }
            }
            $out = $before . $out;
        } elseif ($params['page'] < $params['pageCount'] && is_string($last)) {
            $options += array('rel' => 'last');
            $out = $before . $this->Html->tag(
                $tag, $this->link($last, array('page' => $params['pageCount']), $options), compact('class')
            );
        }
        return $out;
    }

    /**
     * Numbers
     *
     * @param $options array
     * @return string
     */
    public function numbers($options = array())
    {
        $defaults = array(
            'tag' => 'li',
            'before' => null,
            'after' => null,
            'model' => $this->defaultModel(),
            'class' => null,
            'modulus' => '8',
            'separator' => null,
            'first' => null,
            'last' => null,
            'ellipsis' => '...',
        );
        $options += $defaults;
        $params = (array) $this->params($options['model']) + array('page' => 1);
        unset($options['model']);
        if ($params['pageCount'] <= 1) {
            return false;
        }
        extract($options);
        unset($options['tag'], $options['before'], $options['after'], $options['model'],
            $options['modulus'], $options['separator'], $options['first'], $options['last'],
            $options['ellipsis'], $options['class']
        );
        $out = '';
        if ($modulus && $params['pageCount'] > $modulus) {
            $half = intval($modulus / 2);
            $end = $params['page'] + $half;
            if ($end > $params['pageCount']) {
                $end = $params['pageCount'];
            }
            $start = $params['page'] - ($modulus - ($end - $params['page']));
            if ($start <= 1) {
                $start = 1;
                $end = $params['page'] + ($modulus  - $params['page']) + 1;
            }
            if ($first && $start > 1) {
                $offset = ($start <= (int)$first) ? $start - 1 : $first;
                if ($offset < $start - 1) {
                    $out .= $this->first($offset, compact('tag', 'separator', 'ellipsis', 'class'));
                } else {
                    $out .= $this->first($offset, compact('tag', 'separator', 'class') + array('after' => $separator));
                }
            }
            $out .= $before;
            for ($i = $start; $i < $params['page']; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'))
                    . $separator;
            }
            $currentClass = 'active';
            if ($class) {
                $currentClass .= ' ' . $class;
            }
            //$out .= $this->Html->tag($tag, $params['page'], array('class' => $currentClass));
            $out .= $this->Html->tag($tag, $this->link($params['page']), array('class' => $currentClass));
            if ($i != $params['pageCount']) {
                $out .= $separator;
            }
            $start = $params['page'] + 1;
            for ($i = $start; $i < $end; $i++) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class')) . $separator;
            }
            if ($end != $params['page']) {
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $end), $options), compact('class'));
            }
            $out .= $after;
            if ($last && $end < $params['pageCount']) {
                $offset = ($params['pageCount'] < $end + (int)$last) ? $params['pageCount'] - $end : $last;
                if ($offset <= $last && $params['pageCount'] - $end > $offset) {
                    $out .= $this->last($offset, compact('tag', 'separator', 'ellipsis', 'class'));
                } else {
                    $out .= $this->last($offset, compact('tag', 'separator', 'class') + array('before' => $separator));
                }
            }
        } else {
            $out .= $before;
            for ($i = 1; $i <= $params['pageCount']; $i++) {
                $cls = empty($class) ? null : $class;
                if ($i == $params['page']) {
                    $cls .= ' active';
                }
                $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), array('class' => $cls));
                if ($i != $params['pageCount']) {
                    $out .= $separator;
                }
            }
            $out .= $after;
        }
        return $out;
    }
}
