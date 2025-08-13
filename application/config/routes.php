<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login/truecaller_callback'] = 'login/truecaller_callback';
$route['login/truecaller_login'] = 'login/truecaller_login';

$route['dashboard/update_status'] = 'dashboard/update_status';
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
