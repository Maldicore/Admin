# CakePHP Admin Plugin

CakePHP Plugin for automagic admin using Twitter Bootstrap.
Version 1.0 for CakePHP 2.x

This plugin uses the cake scaffolding to create admin panel automagically!

![Restore](https://lh4.googleusercontent.com/-OLACr5gkYLk/UNz5R4Vw-zI/AAAAAAAACYg/haHQDLNHYfI/s958/cakephpadmin.png)

## Installation

1. Copy or clone plugin to ``app/Plugin/Admin``
1. Enable the plugin in ``app/Config/bootstrap.php`` !make sure to enable bootstrap true.
Example code:
```
CakePlugin::load('Admin',array('bootstrap' => true));
```
3. The plugin uses CakePHP's Session Component, so if you haven't already, make sure it's added to ``app/Controller/AppController.php``.
Example code:
```
public $components = array('Session');
```


## Database Tables

Create the database tables

```
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(150) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `middle_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `group_id` int(4) DEFAULT '4',
  `is_active` tinyint(1) DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 
-- Data for table `users`
-- 

INSERT INTO `users` (
	`id`, 
	`username`, 
	`password`, 
	`email`, 
	`first_name`, 
	`middle_name`, 
	`last_name`, 
	`group_id`, 
	`is_active`, 
	`created_date`, 
	`timestamp`) 
	VALUES (
	'1',
	'admin',
	'21232f297a57a5a743894a0e4a801fc3',
	'admin@admin.com',
	'Admin', '', '',
	'1',
	'1',
	NULL,
	''
);

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- 
-- Data for table `groups`
-- 

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
  ('1', 'administrators', '2012-07-05 17:16:24', '2012-07-05 17:16:24'),
  ('2', 'managers', '2012-07-05 17:16:34', '2012-07-05 17:16:34'),
  ('3', 'users', '2012-07-05 17:16:45', '2012-07-05 17:16:45');
```

## Usage/Quick Start

1. Go to ``http://site-url/admin``
1. Login to your admin panel: Both username/password: ``admin``

NOTE: Make sure your table relationships are correctly set in the Models for dropdowns.

## Customization/Advanced Settings (not so advance though!)

### $displayFieldTypes
You can define a variable $displayFieldTypes in any of the models to specify
how the field should be displayed. This var accept a list of field names with the type 
of display, that includes:
* wysihtml
* image
* file
* checkbox

The feature adds a class to the view field which is manipulated via javascript.

example usage:
```php
var $displayFieldTypes = array(
		'introduction' => 'wysihtml',
		'image' => 'image',
		'image1' => 'image',
		'image2' => 'image',
		'image3' => 'image',
		'image4' => 'image',
		'is_active' => 'checkbox'
		);
```

##### wysihtml

wysihtml uses https://github.com/jhollingworth/bootstrap-wysihtml5 and the wysihtml5 is initialized inside /app/Plugin/Admin/webroot/js/script.js

You can change the toolbar features/buttons of wysihtml5 inside script.js:

The defaults are:
```js
$('.textarea').wysihtml5({
		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": false, //Button which allows you to edit the generated HTML. Default false
		"link": true, //Button to insert a link. Default true
		"image": true, //Button to insert an image. Default true,
		"color": false //Button to change color of font
	});
```
For the font color to work on the front end make sure to include the color style file wysiwyg-color.css in your front end.

```php
<?php echo $this->Html->css('/Admin/css/wysiwyg-color.css'); ?>
```

#### $upLoads

You can define a variable $uploads in any of the models to specify upload path.
Variable accepts two arrays imgDir & itemDir, imgDir can only be a string and itemDir can be a string or an array.
The array should hold the name of the table field name which has the folder name

example usage:
```php
var $upLoads = array(
	'imgDir' => 'library',
	'itemDir' => array('field' => 'param_url'),
	);
```

#### $ignoreFieldList

You can define a variable $ignoreFieldList in any of the models to ignore fields from
the list view. The list view can be huge at times with many unwanted fields, here you 
can give a list of fields to be ignored from the list view

example usage:
```php
var $ignoreFieldList = array(
		'perm_url',
		'commencing_date',
		'termination_date',
		'longitude',
		'latitude',
		'slogan',
		'id',
		'location',
		);
```

### $ignoreModelList

You can define a variable $ignoreModelList in your application ``AppModel.php`` file
inside model folder. The models are pursed from the application Model directory,
some times you might have a model eg: a tableless model that you want to ignore.
A list of models to be ignored can be defined in this variable $ignoreModelList

example usage:
```php
var $ignoreModelList = array(
	'Country',
	)
```

### $adminSetting, array key icon

#### Admin dashboard icons

Admin dashboard icons can be customized using the $adminSetting variable inside
each Model using an array with key value of 'icon'. EXCLUDE the extension '.png'
All the files are stored in app/Plugin/Admin/webroot/img/admin_icons/ folder.
If you do not specify an icon explicitly it will choose an icon from the folder 
in folder listing order. You can place an icon/image of .png inside this folder 
and explicitly define it in your model.

example usage
```php
var $adminSettings = array(
		'icon' => 'blog',
		);
```
## Requirements

PHP version: PHP 5.2+
CakePHP version: 2.1

## Support

For support and feature request, please create an issue: 
https://github.com/Maldicore/Admin/issues

We are not actively using this plugin as most of our current projects are done using Laravel.

So support and development will be limited to as and when need and respect to time available.

## Contributing to this Plugin

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features.

If you want to develop, manage and continue supporting this plugin drop us an email info@maldicore.com

Good Luck!

## License
Copyright 2012, Maldicore Group Pvt Ltd

Licensed under The MIT License: http://www.opensource.org/licenses/mit-license.php
