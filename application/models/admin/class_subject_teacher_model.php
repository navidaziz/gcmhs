<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Class_subject_teacher_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "class_subject_teacher";
        $this->pk = "class_subject_teacher_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "exam_id",
                            "label"  =>  "Exam Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "class_subject_id",
                            "label"  =>  "Class Subject Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "class_teacher",
                            "label"  =>  "Class Teacher",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "paper_checked_by",
                            "label"  =>  "Paper Checked By",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["exam_id"]  =  $this->input->post("exam_id");
                    
                    $inputs["class_subject_id"]  =  $this->input->post("class_subject_id");
                    
                    $inputs["class_teacher"]  =  $this->input->post("class_teacher");
                    
                    $inputs["paper_checked_by"]  =  $this->input->post("paper_checked_by");
                    
	return $this->class_subject_teacher_model->save($inputs);
	}	 	

public function update_data($class_subject_teacher_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["exam_id"]  =  $this->input->post("exam_id");
                    
                    $inputs["class_subject_id"]  =  $this->input->post("class_subject_id");
                    
                    $inputs["class_teacher"]  =  $this->input->post("class_teacher");
                    
                    $inputs["paper_checked_by"]  =  $this->input->post("paper_checked_by");
                    
	return $this->class_subject_teacher_model->save($inputs, $class_subject_teacher_id);
	}	
	
    //----------------------------------------------------------------
 public function get_class_subject_teacher_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("class_subject_teacher.*"
                , "exams.term"
            
                , "class_subjects.subject_id"
            );
		$join_table = array(
            "exams" => "exams.exam_id = class_subject_teacher.exam_id",
        
            "class_subjects" => "class_subjects.class_subject_id = class_subject_teacher.class_subject_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->class_subject_teacher_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->class_subject_teacher_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->class_subject_teacher_model->joinGet($fields, "class_subject_teacher", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->class_subject_teacher = $this->class_subject_teacher_model->joinGet($fields, "class_subject_teacher", $join_table, $where);
			return $data;
		}else{
			return $this->class_subject_teacher_model->joinGet($fields, "class_subject_teacher", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_class_subject_teacher($class_subject_teacher_id){
	
		$fields = array("class_subject_teacher.*"
                , "exams.term"
            
                , "class_subjects.subject_id"
            );
		$join_table = array(
            "exams" => "exams.exam_id = class_subject_teacher.exam_id",
        
            "class_subjects" => "class_subjects.class_subject_id = class_subject_teacher.class_subject_id",
        );
		$where = "class_subject_teacher.class_subject_teacher_id = $class_subject_teacher_id";
		
		return $this->class_subject_teacher_model->joinGet($fields, "class_subject_teacher", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

