<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends MY_Controller {

	function __construct() {
		parent::__construct();
		// anything needed here..
		$this->load->library('console');
	}

	public function index()
	{
		debugbar();
		$this->load->view('example_index');
	}

	public function test1()
	{
		/*
			Try to comment / uncomment these two debugz() line; 
		*/
		$array[] = array(
			'name' => 'John',
			'age' => '27'
		);

		debugz($array);

		$array[] = array(
			'name' => 'Marry',
			'age' => '29'
		);

		debugz($array);
	}

	public function test2()
	{
		/*
			Try to comment / uncomment these two dumpz() line; 
		*/
		$array[] = array(
			'name' => 'John',
			'age' => '27'
		);	

		dumpz($array);

		$array[] = array(
			'name' => 'Marry',
			'age' => '29'
		);

		dumpz($array);
	}

}

/* End of file Example.php */
/* Location: ./application/modules/example/controllers/Example.php */
