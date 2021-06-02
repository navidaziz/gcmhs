<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Question_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "questions";
        $this->pk = "question_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "class_id",
                            "label"  =>  "Class Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "subject_id",
                            "label"  =>  "Subject Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "question_type",
                            "label"  =>  "Question Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "chapter_name",
                            "label"  =>  "Chapter Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "question_title",
                            "label"  =>  "Question Title",
                            "rules"  =>  "required"
                        ),
                        
                      /*  array(
                            "field"  =>  "question_image",
                            "label"  =>  "Question Image",
                            "rules"  =>  "required"
                        ),*/
                        
                        array(
                            "field"  =>  "option_one",
                            "label"  =>  "Option One",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "option_two",
                            "label"  =>  "Option Two",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "option_three",
                            "label"  =>  "Option Three",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "option_four",
                            "label"  =>  "Option Four",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "qustion_correct_answer",
                            "label"  =>  "Qustion Correct Answer",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["question_type"]  =  $this->input->post("question_type");
                    
                    $inputs["chapter_name"]  =  $this->input->post("chapter_name");
                    
                    $inputs["question_title"]  =  $this->input->post("question_title");
                    
                    if($_FILES["question_image"]["size"] > 0){
                        $inputs["question_image"]  =  $this->router->fetch_class()."/".$this->input->post("question_image");
                    }
                    
                    $inputs["option_one"]  =  $this->input->post("option_one");
                    
                    $inputs["option_two"]  =  $this->input->post("option_two");
                    
                    $inputs["option_three"]  =  $this->input->post("option_three");
                    
                    $inputs["option_four"]  =  $this->input->post("option_four");
                    
                    $inputs["qustion_correct_answer"]  =  $this->input->post("qustion_correct_answer");
                    
	return $this->question_model->save($inputs);
	}	 	

public function update_data($question_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["question_type"]  =  $this->input->post("question_type");
                    
                    $inputs["chapter_name"]  =  $this->input->post("chapter_name");
                    
                    $inputs["question_title"]  =  $this->input->post("question_title");
                    
                    if($_FILES["question_image"]["size"] > 0){
						//remove previous file....
						$questions = $this->get_question($question_id);
						$file_path = $questions[0]->question_image;
						$this->delete_file($file_path);
                        $inputs["question_image"]  =  $this->router->fetch_class()."/".$this->input->post("question_image");
                    }
                    
                    $inputs["option_one"]  =  $this->input->post("option_one");
                    
                    $inputs["option_two"]  =  $this->input->post("option_two");
                    
                    $inputs["option_three"]  =  $this->input->post("option_three");
                    
                    $inputs["option_four"]  =  $this->input->post("option_four");
                    
                    $inputs["qustion_correct_answer"]  =  $this->input->post("qustion_correct_answer");
                    
	return $this->question_model->save($inputs, $question_id);
	}	
	
    //----------------------------------------------------------------
 public function get_question_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("questions.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = questions.class_id",
        
            "subjects" => "subjects.subject_id = questions.subject_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->question_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->question_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->question_model->joinGet($fields, "questions", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->questions = $this->question_model->joinGet($fields, "questions", $join_table, $where);
			return $data;
		}else{
			return $this->question_model->joinGet($fields, "questions", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_question($question_id){
	
		$fields = array("questions.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = questions.class_id",
        
            "subjects" => "subjects.subject_id = questions.subject_id",
        );
		$where = "questions.question_id = $question_id";
		
		return $this->question_model->joinGet($fields, "questions", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

