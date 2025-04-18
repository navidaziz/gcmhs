<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller extends MY_Controller
{

    public $controller_name = "";
    public $method_name = "";

    public function __construct()
    {

        parent::__construct();

        //$this->output->enable_profiler(TRUE);
        //var_dump($this->session->all_userdata());

        $this->load->helper("form");
        $this->load->helper("my_functions");
        $this->load->library('form_validation');
        $this->load->library("session");
        $this->load->model("user_m");
        $this->load->model("mr_m");
        $this->load->model("module_m");

        $this->load->model("admin/system_global_setting_model");

        $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
        $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        $this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));

        //get global settings
        $system_global_setting_id = 1;
        $fields = $fields = array("sytem_admin_logo", "system_title", "sytem_public_logo");
        $join_table = $join_table = array();
        $where = "system_global_setting_id = $system_global_setting_id";

        $this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true);


        //login check
        $exception_uri = array(
            ADMIN_DIR . "users/login",
            ADMIN_DIR . "users/logout"
        );

        if (!in_array(uri_string(), $exception_uri)) {

            //check if the user is logged in or not
            if ($this->user_m->loggedIn() == false) {

                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    /* special ajax here */
                    echo "<h4>Your session has expired. Please log-in again.</4>";
                    exit();
                } else {
                    redirect(ADMIN_DIR . "users/login");
                }
            }

            //now we will check if the current module is assigned to the user or not
            //$this->method_name
            $this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, 'index');
            $allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));

            //add role homepage to allowed modules
            $allowed_modules[] = $this->session->userdata("role_homepage_id");

            if (!in_array($current_action_id, $allowed_modules)) {
                $this->session->set_flashdata('msg_error', 'id: ' . $current_action_id . ' You are not allowed to access this module');
                redirect(ADMIN_DIR . $this->session->userdata("role_homepage_uri"));
            }
        }
    }
}
