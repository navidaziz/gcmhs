<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Public_Controller
{

  /**
   * constructor method
   */
  public function __construct()
  {
    //$this->load->model("user_m");
    parent::__construct();

    //$this->output->enable_profiler(TRUE);
  }
  //---------------------------------------------------------------


  /**
   * Default action to be called
   */
  public function index()
  {


    if ($this->session->userdata("logged_in")) {

      redirect(ADMIN_DIR . $this->session->userdata("role_homepage_uri"), 'refresh');
    } else {
      redirect(base_url(ADMIN_DIR . 'users/login'), 'refresh');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(ADMIN_DIR . "users/login");
  }
}
