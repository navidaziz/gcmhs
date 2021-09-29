<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class questions_answers extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/question_answer_model");
        $this->lang->load("questions_answers", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
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

        $where = "`questions_answers`.`status` IN (0, 1) ORDER BY `questions_answers`.`order`";
        $data = $this->question_answer_model->get_question_answer_list($where);
        $this->data["questions_answers"] = $data->questions_answers;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('questions Answers');
        $this->data["view"] = ADMIN_DIR . "questions_answers/questions_answers";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_question_answer($question_answer_id)
    {

        $question_answer_id = (int) $question_answer_id;

        $this->data["questions_answers"] = $this->question_answer_model->get_question_answer($question_answer_id);
        $this->data["title"] = $this->lang->line('Question Answer Details');
        $this->data["view"] = ADMIN_DIR . "questions_answers/view_question_answer";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`questions_answers`.`status` IN (2) ORDER BY `questions_answers`.`order`";
        $data = $this->question_answer_model->get_question_answer_list($where);
        $this->data["questions_answers"] = $data->questions_answers;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed questions Answers');
        $this->data["view"] = ADMIN_DIR . "questions_answers/trashed_questions_answers";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;


        $this->question_answer_model->changeStatus($question_answer_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
    }

    /**
     * function to restor question_answer from trash
     * @param $question_answer_id integer
     */
    public function restore($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;


        $this->question_answer_model->changeStatus($question_answer_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "questions_answers/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft question_answer from trash
     * @param $question_answer_id integer
     */
    public function draft($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;


        $this->question_answer_model->changeStatus($question_answer_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish question_answer from trash
     * @param $question_answer_id integer
     */
    public function publish($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;


        $this->question_answer_model->changeStatus($question_answer_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Question_answer
     * @param $question_answer_id integer
     */
    public function delete($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;
        //$this->question_answer_model->changeStatus($question_answer_id, "3");

        $this->question_answer_model->delete(array('question_answer_id' => $question_answer_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "questions_answers/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Question_answer
     */
    public function add()
    {

        $this->data["tests"] = $this->question_answer_model->getList("tests", "test_id", "test_title", $where = "");

        $this->data["questions"] = $this->question_answer_model->getList("questions", "question_id", "question_title", $where = "");

        $this->data["students"] = $this->question_answer_model->getList("students", "student_id", "student_name", $where = "");

        $this->data["title"] = $this->lang->line('Add New Question Answer');
        $this->data["view"] = ADMIN_DIR . "questions_answers/add_question_answer";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->question_answer_model->validate_form_data() === TRUE) {

            $question_answer_id = $this->question_answer_model->save_data();
            if ($question_answer_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "questions_answers/edit/$question_answer_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "questions_answers/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Question_answer
     */
    public function edit($question_answer_id)
    {
        $question_answer_id = (int) $question_answer_id;
        $this->data["question_answer"] = $this->question_answer_model->get($question_answer_id);

        $this->data["tests"] = $this->question_answer_model->getList("tests", "test_id", "test_title", $where = "");

        $this->data["questions"] = $this->question_answer_model->getList("questions", "question_id", "question_title", $where = "");

        $this->data["students"] = $this->question_answer_model->getList("students", "student_id", "student_name", $where = "");

        $this->data["title"] = $this->lang->line('Edit Question Answer');
        $this->data["view"] = ADMIN_DIR . "questions_answers/edit_question_answer";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($question_answer_id)
    {

        $question_answer_id = (int) $question_answer_id;

        if ($this->question_answer_model->validate_form_data() === TRUE) {

            $question_answer_id = $this->question_answer_model->update_data($question_answer_id);
            if ($question_answer_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "questions_answers/edit/$question_answer_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "questions_answers/edit/$question_answer_id");
            }
        } else {
            $this->edit($question_answer_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $question_answer_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;

        //get order number of this record
        $this_question_answer_where = "question_answer_id = $question_answer_id";
        $this_question_answer = $this->question_answer_model->getBy($this_question_answer_where, true);
        $this_question_answer_id = $question_answer_id;
        $this_question_answer_order = $this_question_answer->order;


        //get order number of previous record
        $previous_question_answer_where = "order <= $this_question_answer_order AND question_answer_id != $question_answer_id ORDER BY `order` DESC";
        $previous_question_answer = $this->question_answer_model->getBy($previous_question_answer_where, true);
        $previous_question_answer_id = $previous_question_answer->question_answer_id;
        $previous_question_answer_order = $previous_question_answer->order;

        //if this is the first element
        if (!$previous_question_answer_id) {
            redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_question_answer_inputs = array(
            "order" => $previous_question_answer_order
        );
        $this->question_answer_model->save($this_question_answer_inputs, $this_question_answer_id);

        $previous_question_answer_inputs = array(
            "order" => $this_question_answer_order
        );
        $this->question_answer_model->save($previous_question_answer_inputs, $previous_question_answer_id);



        redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $question_answer_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($question_answer_id, $page_id = NULL)
    {

        $question_answer_id = (int) $question_answer_id;



        //get order number of this record
        $this_question_answer_where = "question_answer_id = $question_answer_id";
        $this_question_answer = $this->question_answer_model->getBy($this_question_answer_where, true);
        $this_question_answer_id = $question_answer_id;
        $this_question_answer_order = $this_question_answer->order;


        //get order number of next record

        $next_question_answer_where = "order >= $this_question_answer_order and question_answer_id != $question_answer_id ORDER BY `order` ASC";
        $next_question_answer = $this->question_answer_model->getBy($next_question_answer_where, true);
        $next_question_answer_id = $next_question_answer->question_answer_id;
        $next_question_answer_order = $next_question_answer->order;

        //if this is the first element
        if (!$next_question_answer_id) {
            redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_question_answer_inputs = array(
            "order" => $next_question_answer_order
        );
        $this->question_answer_model->save($this_question_answer_inputs, $this_question_answer_id);

        $next_question_answer_inputs = array(
            "order" => $this_question_answer_order
        );
        $this->question_answer_model->save($next_question_answer_inputs, $next_question_answer_id);



        redirect(ADMIN_DIR . "questions_answers/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["questions_answers"] = $this->question_answer_model->getBy($where, false, "question_answer_id");
        $j_array[] = array("id" => "", "value" => "question_answer");
        foreach ($data["questions_answers"] as $question_answer) {
            $j_array[] = array("id" => $question_answer->question_answer_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
