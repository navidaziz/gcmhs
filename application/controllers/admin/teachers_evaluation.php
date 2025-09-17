<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teachers_evaluation extends Admin_Controller
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
		$this->data["view"] = ADMIN_DIR . "teachers_evaluation/index";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
