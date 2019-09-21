<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CUSTOM PAGINATION CONFIGURATION
| -------------------------------------------------------------------
| This file contains configuration for pagination
|
*/
$config['page_query_string'] = TRUE;
$config['num_links']  = 4;
$config['use_page_numbers']  = TRUE;
$config['full_tag_open']  = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';
$config['num_tag_open']   = '<li class="page-item">';
$config['num_tag_close']  = '</li>';
$config['cur_tag_open']   = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close']  = '</a></li>';
$config['prev_tag_open']  = '<li class="prev">';
$config['prev_tag_close'] = '</li>';
$config['prev_link'] 	  = 'prev';
$config['next_link'] 	  = 'next';
$config['next_tag_open']  = '<li class="next">';
$config['next_tag_close'] = '</li>';
$config['first_tag_open']  = '<li class="first">';
$config['first_tag_close'] = '</li>';
$config['last_tag_open']  = '<li class="last">';
$config['last_tag_close'] = '</li>';
$config['attributes'] = array('class' => 'page-link');