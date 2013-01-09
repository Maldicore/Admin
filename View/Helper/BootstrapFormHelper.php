<?php
/**
 * Bootstrap Form Helper
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

App::uses('FormHelper', 'View/Helper');

class BootstrapFormHelper extends FormHelper
{
    /**
     * Create
     *
     * @param $model string
     * @param $options array
     * @return string
     */
    public function create($model = null, $options = array())
    {
        if (empty($options['class'])) {
            $options['class'] = 'well';
        }

        $modelKey = $this->model();
        $Model = ClassRegistry::init($modelKey);
        if(!empty($Model->displayFieldTypes[$modelKey])){
            if(in_array('image', $Model->displayFieldTypes[$modelKey]) || in_array('file',$Model->displayFieldTypes[$modelKey])){
                    $type_val = array('type'=>'file');
                    $options = array_merge($type_val, $options);   
                }
        }

        return parent::create($model, $options);
    }

    /**
     * Input
     *
     * @param $fieldName string
     * @param $options array
     * @return string
     */
    public function input($fieldName, $options = array())
    {
        $this->setEntity($fieldName);
        $defaults = array(
            'format' => array(
                'before',
                'label',
                'between',
                'input',
                'error',
                'after'
            ),
            'div' => array(
                'class' => 'control-group'
            ),
            'error' => array(
                'attributes' => array(
                    'class' =>'help-inline',
                    'wrap' => 'span'
                )
            ),
            'help' => '',
        );

        $modelKey = $this->model();
        $fieldKey = $this->field();
        $type = $this->_introspectModel($modelKey, 'fields', $fieldKey);
        $Model = ClassRegistry::init($modelKey);

        foreach ($Model->belongsTo as $bgOptions) {
            if($bgOptions['foreignKey']==$fieldKey){
                $belongModel = new $bgOptions['className'];
                $options['options'] = $belongModel->find('list',array(
                        'conditions' => $bgOptions['conditions'],
                        'fields' => $bgOptions['fields'],
                        'order' => $bgOptions['order'],
                    ));
            }
        }

        if($type['type'] == 'date'){
            $type_val = array('class' => 'datepicker', 'type'=>'text');
            $options = array_merge($type_val, $options);   
        }
        if($type['type'] == 'timestamp'){
            $type_val = array('class' => 'datepicker', 'type'=>'text');
            $options = array_merge($type_val, $options);   
        }
        if($type['type'] == 'datetime'){
            $type_val = array('class' => 'datepicker', 'type'=>'text');
            $options = array_merge($type_val, $options);   
        }

        // debug($Model->displayFieldTypes);

        if(!empty($Model->displayFieldTypes)){
            if (in_array($fieldKey, array_keys($Model->displayFieldTypes))){
                if($Model->displayFieldTypes[$fieldKey] == 'wysihtml'){
                    $type_val = array('class' => 'wysihtml');
                    $options = array_merge($type_val, $options);
                }
                if($Model->displayFieldTypes[$fieldKey] == 'file'){
                    $type_val = array('class' => 'fileupload', 'type'=>'file');
                    $options = array_merge($type_val, $options);   
                }
                if($Model->displayFieldTypes[$fieldKey] == 'image'){
                    $imagelink = '';
                    if(isset($this->data[$modelKey][$fieldKey]) && !empty($this->data[$modelKey][$fieldKey])){
                        $imagefile = $this->data[$modelKey][$fieldKey];
                        $fullpath = APP.'webroot'.DS.'img'.DS.$imagefile;
                        if(file_exists($fullpath)){
                            $imagelink = "<img src='../../../img/".$imagefile."' width='150'> ";
                        }
                    }
                    $type_val = array('class' => 'fileupload', 'between'=>$imagelink, 'type'=>'file');
                    $options = array_merge($type_val, $options);   
                }
            }
        }

        $options = array_merge($defaults, $options);
        if (!empty($options['help'])) {
            $options['after'] = '<span class="help-block">' . $options['help'] . '</span>' . $options['after'];
        }

        return parent::input($fieldName, $options);
    }

    /**
     * Submit
     *
     * @param $caption string
     * @return string
     */
    public function submit($caption = null, $options = array())
    {
        $options = array(
            'class' => 'btn btn-primary'
        );
        return parent::submit($caption, $options);
    }
}
