<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teachers extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $this->data["title"] = 'Staff Statement';
        $this->data["view"] = ADMIN_DIR . "teachers/index";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function trashed()
    {
        $this->data["title"] = 'X Teachers';
        $this->data["view"] = ADMIN_DIR . "teachers/trashed";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }





    private function get_inputs()
    {
        $input["teacher_id"] = $this->input->post("teacher_id");
        $input["teacher_name"] = $this->input->post("teacher_name");
        $input["father_name"] = $this->input->post("father_name");
        $input["gender"] = $this->input->post("gender");

        $input["teacher_designation"] = $this->input->post("teacher_designation");
        $input["cnic"] = $this->input->post("cnic");
        $input["mobile_number"] = $this->input->post("mobile_number");
        $input["acadmic_qualification"] = $this->input->post("acadmic_qualification");
        $input["major_subject"] = $this->input->post("major_subject");
        $input["professional_qualification"] = $this->input->post("professional_qualification");

        $input["date_of_birth"] = $this->input->post("date_of_birth") != '' ? $this->input->post("date_of_birth") : NULL;
        $input["initial_appointment_date"] = $this->input->post("initial_appointment_date") != '' ? $this->input->post("initial_appointment_date") : NULL;
        $input["current_school_assumption_date"] = $this->input->post("current_school_assumption_date") != '' ? $this->input->post("current_school_assumption_date") : NULL;
        $input["current_post_assumption_date"] = $this->input->post("current_post_assumption_date") != '' ? $this->input->post("current_post_assumption_date") : NULL;

        $input["personal_no"] = $this->input->post("personal_no") != '' ? $this->input->post("personal_no") : NULL;
        $input["basic_pay_scale"] = $this->input->post("basic_pay_scale") != '' ? $this->input->post("basic_pay_scale") : NULL;
        $input["current_pay"] = $this->input->post("current_pay") != '' ? $this->input->post("current_pay") : NULL;
        $input["gp_fund_number"] = $this->input->post("gp_fund_number") != '' ? $this->input->post("gp_fund_number") : NULL;
        $input["bank_branch"] = $this->input->post("bank_branch") != '' ? $this->input->post("bank_branch") : NULL;
        $input["bank_branch_code"] = $this->input->post("bank_branch_code") != '' ? $this->input->post("bank_branch_code") : NULL;
        $input["bank_account_no"] = $this->input->post("bank_account_no") != '' ? $this->input->post("bank_account_no") : NULL;
        $input["email"] = $this->input->post("email") != '' ? $this->input->post("email") : NULL;
        $input["address"] = $this->input->post("address") != '' ? $this->input->post("address") : NULL;
        if ($this->input->post("teacher_id") == 0) {
            $input["user_name"] = $this->input->post("mobile_number");
            $input["password"] = '123456';
        } else {
            $input["user_name"] = $this->input->post("user_name") != '' ? $this->input->post("user_name") : NULL;
            $input["password"] = $this->input->post("password") != '' ? $this->input->post("password") : NULL;
        }

        if ($this->input->post("status") == 0) {
            $input["status"] = 0;
            $input["leaved_date"] = $this->input->post("leaved_date") != '' ? $this->input->post("leaved_date") : NULL;
        }

        $inputs =  (object) $input;
        return $inputs;
    }

    public function get_teacher_form()
    {
        $teacher_id = (int) $this->input->post("teacher_id");
        if ($teacher_id == 0) {

            $input = $this->get_inputs();
        } else {
            $query = "SELECT * FROM 
        teachers 
        WHERE teacher_id = $teacher_id";
            $input = $this->db->query($query)->row();
        }
        $this->data["input"] = $input;
        $this->load->view(ADMIN_DIR . "teachers/get_teacher_form", $this->data);
    }
    public function add_teacher()
    {
        $this->form_validation->set_rules("teacher_name", "Teacher Name", "required");
        //$this->form_validation->set_rules("father_name", "Father Name", "required");
        $this->form_validation->set_rules("gender", "Gender", "required");
        //$this->form_validation->set_rules("date_of_birth", "Date Of Birth", "required");
        $this->form_validation->set_rules("teacher_designation", "Teacher Designation", "required");
        //$this->form_validation->set_rules("cnic", "Cnic", "required");
        $this->form_validation->set_rules("mobile_number", "Mobile Number", "required");
        // $this->form_validation->set_rules("acadmic_qualification", "Acadmic Qualification", "required");
        // $this->form_validation->set_rules("professional_qualification", "Professional Qualification", "required");
        // $this->form_validation->set_rules("initial_appointment_date", "Initial Appointment Date", "required");
        // $this->form_validation->set_rules("current_school_assumption_date", "Current School Assumption Date", "required");
        // $this->form_validation->set_rules("current_post_assumption_date", "Current Post Assumption Date", "required");
        // $this->form_validation->set_rules("personal_no", "Personal No", "required");
        // $this->form_validation->set_rules("basic_pay_scale", "Basic Pay Scale", "required");
        // $this->form_validation->set_rules("current_pay", "Current Pay", "required");
        // $this->form_validation->set_rules("gp_fund_number", "Gp Fund Number", "required");
        // $this->form_validation->set_rules("bank_branch", "Bank Branch", "required");
        // $this->form_validation->set_rules("bank_branch_code", "Bank Branch Code", "required");
        // $this->form_validation->set_rules("bank_account_no", "Bank Account No", "required");
        // $this->form_validation->set_rules("email", "Email", "required");
        // $this->form_validation->set_rules("address", "Address", "required");
        if ($this->input->post("teacher_id") != 0) {
            $this->form_validation->set_rules("user_name", "User Name", "required");
            $this->form_validation->set_rules("password", "Password", "required");
        }

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_inputs();
            //var_dump($inputs);
            $inputs->created_by = $this->session->userdata("userId");
            $teacher_id = (int) $this->input->post("teacher_id");
            if ($teacher_id == 0) {
                $inputs->status = 1;
                $this->db->insert("teachers", $inputs);
                $teacher_id = $this->db->insert_id();
                $data = array(
                    'role_id' => '19',
                    'user_title' => $this->input->post("teacher_name"),
                    'user_mobile_number' => $this->input->post('mobile_number'),
                    'user_name' => $this->input->post('mobile_number'),
                    'user_password' => '123456',
                    'user_email' => 'email@email.com',
                    'teacher_id' => $teacher_id
                );
                $this->db->insert("users", $data);
            } else {
                $this->db->where("teacher_id", $teacher_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $this->db->update("teachers", $inputs);

                $profile_id = $this->input->post('profile_id');
                if ($profile_id != 0) {
                    $data = array(
                        'last_updated' => date('Y-m-d H:i:s'),
                        'user_name' => $this->input->post('user_name'),
                        'user_password' => $this->input->post('password')
                    );

                    // Update the database record
                    $this->db->where("user_id", $profile_id);
                    $this->db->where("teacher_id", $teacher_id);
                    $this->db->update("users", $data);
                } else {
                    $data = array(
                        'role_id' => '19',
                        'user_title' => $this->input->post("teacher_name"),
                        'user_mobile_number' => $this->input->post('mobile_number'),
                        'user_name' => $this->input->post('mobile_number'),
                        'user_password' => '123456',
                        'user_email' => 'email@email.com',
                        'teacher_id' => $teacher_id
                    );
                    $this->db->insert("users", $data);
                }
            }
            echo "success";
        }
    }
    public function delete_teacher($teacher_id)
    {
        $teacher_id = (int) $teacher_id;
        $this->db->where("teacher_id", $teacher_id);
        $this->db->delete("teachers");
        $requested_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        redirect($requested_url);
    }




    public function teachers_list()
    {
        $columns[] = "teacher_name";
        $columns[] = "father_name";
        $columns[] = "gender";
        $columns[] = "date_of_birth";
        $columns[] = "teacher_designation";
        $columns[] = "cnic";
        $columns[] = "mobile_number";
        $columns[] = "acadmic_qualification";
        $columns[] = "major_subject";
        $columns[] = "professional_qualification";
        $columns[] = "initial_appointment_date";
        $columns[] = "current_school_assumption_date";
        $columns[] = "current_post_assumption_date";
        $columns[] = "personal_no";
        $columns[] = "basic_pay_scale";
        $columns[] = "current_pay";
        $columns[] = "gp_fund_number";
        $columns[] = "bank_branch";
        $columns[] = "bank_branch_code";
        $columns[] = "bank_account_no";
        $columns[] = "email";
        $columns[] = "address";
        $columns[] = "user_name";
        $columns[] = "password";


        $limit = $this->input->post("length");
        $start = $this->input->post("start");
        $order = $columns[$this->input->post("order")[0]["column"]];
        $dir = $this->input->post("order")[0]["dir"];

        $search = $this->db->escape("%" . $this->input->post("search")["value"] . "%");
        // Manual SQL query building
        $status = (int) $this->input->post('status');
        $sql = "SELECT *
         FROM teachers WHERE `teachers`.`status` = '" . $status . "' ";

        // Searching
        if (!empty($this->input->post("search")["value"])) {
            $sql .= " AND ";
            foreach ($columns as $column) {
                $sql .= "$column LIKE $search OR ";
            }
            $sql = rtrim($sql, "OR "); // Remove the last "OR"
        }

        // Ordering
        if ($order) {
            $sql .= " ORDER BY $order $dir";
        }

        // Pagination
        if ($this->input->post("length")) {
            if ($limit != -1) {
                $sql .= " LIMIT $limit OFFSET $start";
            }
        }

        $query = $this->db->query($sql);
        $data = $query->result();

        // Total records count
        $total_records = $this->db->query("SELECT COUNT(*) as count FROM teachers")->row()->count;

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $total_records,
            "data" => $data
        );

        echo json_encode($output);
    }
}
