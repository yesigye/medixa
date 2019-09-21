<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name: app Config
*
* Author: 	Yesigye Ignatius
* 			ignatiusyesigye@gmail.com

/*
|--------------------------------------------------------------------------
| File path
|--------------------------------------------------------------------------
| The path for your uploaded files.
*/
$config['upload']['file_path'] = APPPATH.'uploads'.DIRECTORY_SEPARATOR;

/*
|--------------------------------------------------------------------------
| Resize dimensions
|--------------------------------------------------------------------------
| The height and width of images files after resizing.
*/
$config['upload']['resize_height'] = 300;
$config['upload']['resize_width'] = 300;

$config['upload']['thumbnail_height'] = 35;
$config['upload']['thumbnail_width'] = 35;
