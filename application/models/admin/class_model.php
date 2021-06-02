<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Class_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "classes";
        $this->pk = "class_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "Class_title",
                            "label"  =>  "Class Title",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["Class_title"]  =  $this->input->post("Class_title");
                    
	return $this->class_model->save($inputs);
	}	 	

public function update_data($class_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["Class_title"]  =  $this->input->post("Class_title");
                    
	return $this->class_model->save($inputs, $class_id);
	}	
	
    //----------------------------------------------------------------
 public function get_class_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("classes.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->class_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->class_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->class_model->joinGet($fields, "classes", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->classes = $this->class_model->joinGet($fields, "classes", $join_table, $where);
			return $data;
		}else{
			return $this->class_model->joinGet($fields, "classes", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_class($class_id){
	
		$fields = array("classes.*");
		$join_table = array();
		$where = "classes.class_id = $class_id";
		
		return $this->class_model->joinGet($fields, "classes", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

