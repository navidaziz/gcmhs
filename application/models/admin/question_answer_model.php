<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Question_answer_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "questions_answers";
        $this->pk = "question_answer_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "test_id",
                            "label"  =>  "Test Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "question_id",
                            "label"  =>  "Question Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "student_id",
                            "label"  =>  "Student Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "answer",
                            "label"  =>  "Answer",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
                    $inputs["question_id"]  =  $this->input->post("question_id");
                    
                    $inputs["student_id"]  =  $this->input->post("student_id");
                    
                    $inputs["answer"]  =  $this->input->post("answer");
                    
	return $this->question_answer_model->save($inputs);
	}	 	

public function update_data($question_answer_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
                    $inputs["question_id"]  =  $this->input->post("question_id");
                    
                    $inputs["student_id"]  =  $this->input->post("student_id");
                    
                    $inputs["answer"]  =  $this->input->post("answer");
                    
	return $this->question_answer_model->save($inputs, $question_answer_id);
	}	
	
    //----------------------------------------------------------------
 public function get_question_answer_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("questions_answers.*"
                , "tests.test_title"
            
                , "questions.question_title"
            
                , "students.student_name"
            );
		$join_table = array(
            "tests" => "tests.test_id = questions_answers.test_id",
        
            "questions" => "questions.question_id = questions_answers.question_id",
        
            "students" => "students.student_id = questions_answers.student_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->question_answer_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->question_answer_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->question_answer_model->joinGet($fields, "questions_answers", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->questions_answers = $this->question_answer_model->joinGet($fields, "questions_answers", $join_table, $where);
			return $data;
		}else{
			return $this->question_answer_model->joinGet($fields, "questions_answers", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_question_answer($question_answer_id){
	
		$fields = array("questions_answers.*"
                , "tests.test_title"
            
                , "questions.question_title"
            
                , "students.student_name"
            );
		$join_table = array(
            "tests" => "tests.test_id = questions_answers.test_id",
        
            "questions" => "questions.question_id = questions_answers.question_id",
        
            "students" => "students.student_id = questions_answers.student_id",
        );
		$where = "questions_answers.question_answer_id = $question_answer_id";
		
		return $this->question_answer_model->joinGet($fields, "questions_answers", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

