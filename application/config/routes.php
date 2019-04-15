<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'example';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['example/(:any)'] = 'example/example/$1';
