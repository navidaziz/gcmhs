<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "tests";
        $this->pk = "test_id";
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
                            "field"  =>  "test_type",
                            "label"  =>  "Test Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "test_title",
                            "label"  =>  "Test Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "test_discription",
                            "label"  =>  "Test Discription",
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
                    
                    $inputs["test_type"]  =  $this->input->post("test_type");
                    
                    $inputs["test_title"]  =  $this->input->post("test_title");
                    
                    $inputs["test_discription"]  =  $this->input->post("test_discription");
                    
	return $this->test_model->save($inputs);
	}	 	

public function update_data($test_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["test_type"]  =  $this->input->post("test_type");
                    
                    $inputs["test_title"]  =  $this->input->post("test_title");
                    
                    $inputs["test_discription"]  =  $this->input->post("test_discription");
                    
	return $this->test_model->save($inputs, $test_id);
	}	
	
    //----------------------------------------------------------------
 public function get_test_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("tests.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = tests.class_id",
        
            "subjects" => "subjects.subject_id = tests.subject_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->test_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->test_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->test_model->joinGet($fields, "tests", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->tests = $this->test_model->joinGet($fields, "tests", $join_table, $where);
			return $data;
		}else{
			return $this->test_model->joinGet($fields, "tests", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_test($test_id){
	
		$fields = array("tests.*"
                , "classes.Class_title"
            
                , "subjects.subject_title"
            );
		$join_table = array(
            "classes" => "classes.class_id = tests.class_id",
        
            "subjects" => "subjects.subject_id = tests.subject_id",
        );
		$where = "tests.test_id = $test_id";
		
		return $this->test_model->joinGet($fields, "tests", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

