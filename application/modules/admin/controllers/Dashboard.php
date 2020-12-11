<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['view'] = 'dashboard/index';
		$this->load->view('layout/layout', $data);
	}
}
