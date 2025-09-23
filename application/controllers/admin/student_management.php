<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_management extends Admin_Controller
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
		$this->data['title'] = "Teachers Evaluation";
		$this->data["view"] = ADMIN_DIR . "student_management/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
