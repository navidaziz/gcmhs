<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tests extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_model");
        $this->lang->load("tests", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);

        $this->load->model("admin/test_questions_model");
        $this->lang->load("test_questions", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);


        $this->load->model("admin/question_model");
        $this->lang->load("questions", 'english');
        $this->lang->load("system", 'english');
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $where = "`tests`.`status` IN (0, 1) ";
        $data = $this->test_model->get_test_list($where);
        $this->data["tests"] = $data->tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Tests');
        $this->data["view"] = ADMIN_DIR . "tests/tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test($test_id)
    {


        $test_id = (int) $test_id;
        $this->data["tests"] = $this->test_model->get_test($test_id);
        $test_data = $this->data["tests"][0];
        //var_dump($test_data);
        //get test question 

        $where = "`questions`.`status` IN (0, 1) 
		AND `questions`.`class_id` = " . $test_data->class_id . "
		AND `questions`.`subject_id` = " . $test_data->subject_id . "
		ORDER BY `questions`.`order`";
        $all_question = $this->question_model->get_question_list($where, FALSE);
        $this->data['questions'] = $all_question;
        $chapter = array();
        foreach ($all_question as $question) {

            $chapter[$question->chapter_name][] = $question;
        }


        $this->data["chapters"] = $chapter;


        //get test questions....
        $query = "SELECT `question_id` FROM `test_questions` WHERE `test_id` = $test_id";
        $query_result = $this->db->query($query);
        $test_question_ids = $query_result->result();

        foreach ($test_question_ids as $index => $test_question_id) {
            $test_question_ids[$index] = $test_question_id->question_id;
        }

        $this->data['test_question_ids'] = $test_question_ids;





        $this->data["title"] = $this->lang->line('Test Details');
        $this->data["view"] = ADMIN_DIR . "tests/view_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`tests`.`status` IN (2) ";
        $data = $this->test_model->get_test_list($where);
        $this->data["tests"] = $data->tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Tests');
        $this->data["view"] = ADMIN_DIR . "tests/trashed_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }

    /**
     * function to restor test from trash
     * @param $test_id integer
     */
    public function restore($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "tests/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test from trash
     * @param $test_id integer
     */
    public function draft($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test from trash
     * @param $test_id integer
     */
    public function publish($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test
     * @param $test_id integer
     */
    public function delete($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;
        //$this->test_model->changeStatus($test_id, "3");

        $this->test_model->delete(array('test_id' => $test_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "tests/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test
     */
    public function add()
    {

        $this->data["classes"] = $this->test_model->getList("classes", "class_id", "Class_title", $where = "");

        $this->data["subjects"] = $this->test_model->getList("subjects", "subject_id", "subject_title", $where = "");

        $this->data["title"] = $this->lang->line('Add New Test');
        $this->data["view"] = ADMIN_DIR . "tests/add_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_model->validate_form_data() === TRUE) {

            $test_id = $this->test_model->save_data();
            if ($test_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "tests/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test
     */
    public function edit($test_id)
    {
        $test_id = (int) $test_id;
        $this->data["test"] = $this->test_model->get($test_id);

        $this->data["classes"] = $this->test_model->getList("classes", "class_id", "Class_title", $where = "");

        $this->data["subjects"] = $this->test_model->getList("subjects", "subject_id", "subject_title", $where = "");

        $this->data["title"] = $this->lang->line('Edit Test');
        $this->data["view"] = ADMIN_DIR . "tests/edit_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_id)
    {

        $test_id = (int) $test_id;

        if ($this->test_model->validate_form_data() === TRUE) {

            $test_id = $this->test_model->update_data($test_id);
            if ($test_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            }
        } else {
            $this->edit($test_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["tests"] = $this->test_model->getBy($where, false, "test_id");
        $j_array[] = array("id" => "", "value" => "test");
        foreach ($data["tests"] as $test) {
            $j_array[] = array("id" => $test->test_id, "value" => "");
        }
        echo json_encode($j_array);
    }



    //-----------------------------------------------------

}
