<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

function d($data = NULL, $pre = TRUE) 
{
	if($pre) { echo '<pre>'; }
	print_r($data);
	if($pre) { echo '</pre>'; }	
	exit; /* pengganti die(); */
}

function debugz($data = NULL, $pre = TRUE) 
{
	if($pre) { echo '<pre>'; }
	print_r($data);
	if($pre) { echo '</pre>'; }	
	exit; /* pengganti die(); */
}



function dumpz($data = NULL, $pre = TRUE) 
{
	if($pre) { echo '<pre>'; }
	var_dump($data);
	if($pre) { echo '</pre>'; }	
	exit; /* pengganti die(); */
}


function debugbar()
{
	$ci =& get_instance();
	$ci->load->library('console');
	// $this->console->exception(new Exception('test exception'));
	$ci->console->debug('Debug message');
	$ci->console->info('Info message');
	$ci->console->warning('Warning message');
	$ci->console->error('Error message');
	$ci->output->enable_profiler(TRUE);
	// return;
}