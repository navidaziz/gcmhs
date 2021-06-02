<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Class_subject_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "class_subjects";
        $this->pk = "class_subject_id";
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
                            "field"  =>  "marks",
                            "label"  =>  "Marks",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "passing_mark",
                            "label"  =>  "Passing Mark",
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
                    
                    $inputs["marks"]  =  $this->input->post("marks");
                    
                    $inputs["passing_mark"]  =  $this->input->post("passing_mark");
                    
	return $this->class_subject_model->save($inputs);
	}	 	

public function update_data($class_subject_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["marks"]  =  $this->input->post("marks");
                    
                    $inputs["passing_mark"]  =  $this->input->post("passing_mark");
                    
	return $this->class_subject_model->save($inputs, $class_subject_id);
	}	
	
    //----------------------------------------------------------------
 public function get_class_subject_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("class_subjects.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = class_subjects.class_id",
        
            "subjects" => "subjects.subject_id = class_subjects.subject_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->class_subject_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->class_subject_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->class_subject_model->joinGet($fields, "class_subjects", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->class_subjects = $this->class_subject_model->joinGet($fields, "class_subjects", $join_table, $where);
			return $data;
		}else{
			return $this->class_subject_model->joinGet($fields, "class_subjects", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_class_subject($class_subject_id){
	
		$fields = array("class_subjects.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = class_subjects.class_id",
        
            "subjects" => "subjects.subject_id = class_subjects.subject_id",
        );
		$where = "class_subjects.class_subject_id = $class_subject_id";
		
		return $this->class_subject_model->joinGet($fields, "class_subjects", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

