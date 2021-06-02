<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_questions_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "test_questions";
        $this->pk = "test_question_id";
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
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
                    $inputs["question_id"]  =  $this->input->post("question_id");
                    
	return $this->test_questions_model->save($inputs);
	}	 	

public function update_data($test_question_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
                    $inputs["question_id"]  =  $this->input->post("question_id");
                    
	return $this->test_questions_model->save($inputs, $test_question_id);
	}	
	
    //----------------------------------------------------------------
 public function get_test_questions_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("test_questions.*"
                , "tests.test_title"
            
                , "questions.question_title"
            );
		$join_table = array(
            "tests" => "tests.test_id = test_questions.test_id",
        
            "questions" => "questions.question_id = test_questions.question_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->test_questions_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->test_questions_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->test_questions_model->joinGet($fields, "test_questions", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->test_questions = $this->test_questions_model->joinGet($fields, "test_questions", $join_table, $where);
			return $data;
		}else{
			return $this->test_questions_model->joinGet($fields, "test_questions", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_test_questions($test_question_id){
	
		$fields = array("test_questions.*"
                , "tests.test_title"
            
                , "questions.question_title"
            );
		$join_table = array(
            "tests" => "tests.test_id = test_questions.test_id",
        
            "questions" => "questions.question_id = test_questions.question_id",
        );
		$where = "test_questions.test_question_id = $test_question_id";
		
		return $this->test_questions_model->joinGet($fields, "test_questions", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

