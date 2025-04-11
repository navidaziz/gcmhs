<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');
	}


	public function index()
	{


		$this->data['title'] = "Attendance";
		$this->data["view"] = ADMIN_DIR . "attendance/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
