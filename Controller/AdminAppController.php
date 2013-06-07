<?php
/**
 * Admin App Controller
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

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');

class AdminAppController extends AppController
{
    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'BSForm' => array(
            'className' => 'Admin.BootstrapForm'
        ),
        'Html',
        'Session' => array(
            'className' => 'Admin.BootstrapSession'
        ),
        'Paginator' => array(
            'className' => 'Admin.BootstrapPaginator'
        )
    );
    
    // Check if they are logged in
    
    
    function authenticate()
    {
        // Check if the session variable User exists, redirect to loginform if not
        if(!$this->Session->check('User'))
        {
            $this->redirect(array('controller' => 'users', 'action' => 'login_form'));
            exit();
        }
    }
 
    // Authenticate on every action, except the login form
    function afterFilter()
    {
        if( $this->action != 'login_form' )
        {
            $this->authenticate();
        }
    }
   
    /**
     * Scaffold
     *
     * @var string
     */
    public $scaffold;

    /**
     * Pagination
     *
     * @var string
     */
    
    public function beforeRender()
    {
        
       
    }

    /**
     * Before Filter
     *
     * @return void
     */
    public function beforeFilter()
    {
        $modelClass = $this->modelClass;
        // $fieldKey = $this->field();
        $Model = ClassRegistry::init($modelClass);
        
        $ignoreModelList = array();
        if(isset($Model->ignoreModelList)){
            $ignoreModelList = $Model->ignoreModelList;
        }
        $displayFieldTypes[$modelClass] = array();
        if(isset($Model->displayFieldTypes)){
            $displayFieldTypes[$modelClass] = $Model->displayFieldTypes;
        }
        // Get association model displayfield types
        foreach ($Model->hasMany as $key => $value) {
            $subModel = ClassRegistry::init($value['className']);
            $displayFieldTypes[$key] = $subModel->displayFieldTypes;
        }
        $ignoreFieldList = array();
        if(isset($Model->ignoreFieldList)){
            $ignoreFieldList = $Model->ignoreFieldList;
        }
        $adminSettings = array();
        if(isset($Model->adminSettings)){
            $adminSettings = $Model->adminSettings;
        }

        parent::beforeFilter();
        $iconPath = APP.'Plugin'.DS.'Admin'.DS.'webroot'.DS.'img'.DS.'admin_icons';
        $iconFolder = new Folder($iconPath);
        $iconsInFolder = $iconFolder->find('.*png', true);
        foreach ($iconsInFolder as $key => $value) {
            $iconsInFolder[$key] = str_replace('.png', '', $value);
        }
        $Folder = new Folder(APP . 'Model');
        $files = $Folder->find('.*\.php', true);
        $navbar = array();
        foreach ($files as $file) {
            if ($file !== 'AppModel.php') {
                $model = str_replace('.php', '', $file);
                $Model = ClassRegistry::init($model);
                $schema = $Model->schema();
                if(!in_array($model, $ignoreModelList) && isset($schema)){
                    if(isset($Model->adminSettings['icon'])){
                        $icon_file = $iconPath.DS.$Model->adminSettings['icon'].'.png';
                        if(file_exists($icon_file)){
                            $icon = $Model->adminSettings['icon'];
                        } else {
                            $icon = $iconsInFolder[0];
                            array_shift($iconsInFolder);    
                        }
                    } else {
                        $icon = $iconsInFolder[0];
                        array_shift($iconsInFolder);
                    }
                    $controller = Inflector::tableize($model);
                    $title = Inflector::pluralize($model);
                    $navbar[] = array(
                        'title' => $title,
                        'url' => array(
                            'plugin' => 'admin',
                            'controller' => $controller,
                            'action' => 'index',
                        ),
                        'icon' => $icon,
                    );
                }
            }
        }
        $data = $this->request->data;
        if($data){
            $Model = ClassRegistry::init($modelClass);
            $imgDir = $Model->upLoads['imgDir'];
            foreach ($data[$modelClass] as $key => $value) {
                if(isset($displayFieldTypes[$modelClass][$key]) && $displayFieldTypes[$modelClass][$key] == 'image'){
                    if(empty($value['name'])){
                        unset($this->request->data[$modelClass][$key]);
                    } else {
                        $itemDir = '';
                        if(isset($Model->upLoads['itemDir']) && !empty($Model->upLoads['itemDir'])){
                            // set as a field value or as a string in model $upLoads variable
                            $itemDir = $Model->upLoads['itemDir'];
                            if(is_array($itemDir) && isset($itemDir['field'])) {
                                $itemField = $itemDir['field'];
                                if(isset($data[$modelClass][$itemField])){
                                    $itemDir = $data[$modelClass][$itemField];
                                }
                            } else {
                                $itemDir = $Model->upLoads['itemDir'];
                            }
                        }
                        $fileOK = $this->uploadFiles($imgDir, $value, $itemDir);

                        if(array_key_exists('urls', $fileOK)) {
                            // save the url in the form data
                            $this->request->data[$modelClass][$key] = $fileOK['urls'][0];
                        }
                    }
                }
            }
        }
        if(empty($ignoreFieldList))
            $ignoreFieldList = array();
        if(empty($displayFieldTypes))
            $displayFieldTypes = array();
        if(empty($ignoreModelList))
            $ignoreModelList = array();
        if(empty($adminSettings))
            $adminSettings = array();
        $this->set(compact('navbar','displayFieldTypes','ignoreFieldList', 'adminSettings'));
    }

    /**
    * uploads files
    * @return:
    *      will return an array with the success of each file upload
    */
    public function uploadFiles($folder=null, $formdata, $itemId = null) {
    // setup dir names absolute and relative
        if(isset($folder)){
            $folder_url = WWW_ROOT.'img'.DS.$folder;
            $rel_url = 'img'.DS.$folder;
        } else {
            $folder_url = WWW_ROOT.'img';
            $rel_url = 'img';
        }
        
        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }
    // if itemId is set create an item/sub folder
        if($itemId) {
    // set new absolute folder
            $folder_url = $folder_url.DS.$itemId; 
    // set new relative folder
            $rel_url = $rel_url.DS.$itemId;
            // create the folder if it does not exist
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }
        
        // list of permitted file types
        $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');

        // replace spaces with underscores
        $filename = $formdata['name'];
        $filename = str_replace(' ', '_', $filename);
        // assume filetype is false
        $typeOK = false;
        // check filetype is ok
        foreach($permitted as $type) {
            if($type == $formdata['type']) {
                $typeOK = true;
                break;
            }
        }

        // if file type ok upload the file
        if($typeOK) {
        // switch based on error code
            switch($formdata['error']) {
                case 0:
                // check filename already exists
                if(!file_exists($folder_url.DS.$filename)) {
                    // create full filename
                    $full_url = $folder_url.DS.$filename;
                    $url = $rel_url.DS.$filename;
                    // upload the file
                    $success = move_uploaded_file($formdata['tmp_name'], $url);
                    
                } else {
                    // create unique filename and upload file
                    // ini_set('date.timezone', 'India/Maldives');
                    $now = date('Y-m-d-His');
                    $full_url = $folder_url.DS.$now.$filename;
                    $url = $rel_url.DS.$now.$filename;
                    $success = move_uploaded_file($formdata['tmp_name'], $url);
                }
                // if upload was successful
                if($success) {
                    // save the url of the file
                    $result['urls'][] = substr($url, 4);
                } else {
                    $result['errors'][] = "Error uploaded $filename. Please try again.";
                }
                break;
                case 3:
                // an error occured
                $result['errors'][] = "Error uploading $filename. Please try again.";
                break;
                default:
                // an error occured
                $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                break;
            }
        } elseif($formdata['error'] == 4) {
            // no file was selected for upload
            $result['nofiles'][] = "No file Selected";
        } else {
            // unacceptable file type
            $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
        }
        
        return $result;
    }
}
