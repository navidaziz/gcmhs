<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Student_exam_subject_mark_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "students_exams_subjects_marks";
        $this->pk = "student_exam_subject_mark_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "exam_id",
                "label"  =>  "Exam Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "class_subjec_id",
                "label"  =>  "Class Subjec Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "student_id",
                "label"  =>  "Student Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "obtain_mark",
                "label"  =>  "Obtain Mark",
                "rules"  =>  "required"
            ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["exam_id"]  =  $this->input->post("exam_id");

        $inputs["class_subjec_id"]  =  $this->input->post("class_subjec_id");

        $inputs["student_id"]  =  $this->input->post("student_id");

        $inputs["obtain_mark"]  =  $student_marks = $this->input->post("obtain_mark");

        $inputs["class_id"]  =  $this->input->post("class_id");
        $inputs["subject_id"]  =  $this->input->post("subject_id");
        $inputs["section_id"]  =  $this->input->post("section_id");

        $inputs["section_id"]  =  $this->input->post("section_id");
        $inputs["created_by"]  =  $this->session->userdata('user_id');


        $inputs["total_marks"]   = $total_marks =  (int) $this->input->post("total_marks");
        $inputs['passing_marks'] = round((($total_marks * 33) * .01), 2);
        $inputs['percentage'] = round((($student_marks * 100) / $total_marks), 2);
        return $this->student_exam_subject_mark_model->save($inputs);
    }

    public function update_data($student_exam_subject_mark_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["exam_id"]  =  $this->input->post("exam_id");

        $inputs["class_subjec_id"]  =  $this->input->post("class_subjec_id");

        $inputs["student_id"]  =  $this->input->post("student_id");

        $inputs["obtain_mark"]  =  $this->input->post("obtain_mark");

        return $this->student_exam_subject_mark_model->save($inputs, $student_exam_subject_mark_id);
    }

    //----------------------------------------------------------------
    public function get_student_exam_subject_mark_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array(
            "students_exams_subjects_marks.*", "exams.term", "class_subjects.subject_id", "students.student_name"
        );
        $join_table = array(
            "exams" => "exams.exam_id = students_exams_subjects_marks.exam_id",

            "class_subjects" => "class_subjects.class_subject_id = students_exams_subjects_marks.class_subjec_id",

            "students" => "students.student_id = students_exams_subjects_marks.student_id",
        );
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->student_exam_subject_mark_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->student_exam_subject_mark_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->student_exam_subject_mark_model->joinGet($fields, "students_exams_subjects_marks", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->students_exams_subjects_marks = $this->student_exam_subject_mark_model->joinGet($fields, "students_exams_subjects_marks", $join_table, $where);
            return $data;
        } else {
            return $this->student_exam_subject_mark_model->joinGet($fields, "students_exams_subjects_marks", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_student_exam_subject_mark($student_exam_subject_mark_id)
    {

        $fields = array(
            "students_exams_subjects_marks.*", "exams.term", "class_subjects.subject_id", "students.student_name"
        );
        $join_table = array(
            "exams" => "exams.exam_id = students_exams_subjects_marks.exam_id",

            "class_subjects" => "class_subjects.class_subject_id = students_exams_subjects_marks.class_subjec_id",

            "students" => "students.student_id = students_exams_subjects_marks.student_id",
        );
        $where = "students_exams_subjects_marks.student_exam_subject_mark_id = $student_exam_subject_mark_id";

        return $this->student_exam_subject_mark_model->joinGet($fields, "students_exams_subjects_marks", $join_table, $where, FALSE, TRUE);
    }
}
