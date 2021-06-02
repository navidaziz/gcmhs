<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Academical_evaluation_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "academical_evaluations";
        $this->pk = "academical_evaluation_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "academical_evaluation_title",
                            "label"  =>  "Academical Evaluation Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "academical_evaluation_date",
                            "label"  =>  "Academical Evaluation Date",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["academical_evaluation_title"]  =  $this->input->post("academical_evaluation_title");
                    
                    $inputs["academical_evaluation_date"]  =  $this->input->post("academical_evaluation_date");
                    
	return $this->academical_evaluation_model->save($inputs);
	}	 	

public function update_data($academical_evaluation_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["academical_evaluation_title"]  =  $this->input->post("academical_evaluation_title");
                    
                    $inputs["academical_evaluation_date"]  =  $this->input->post("academical_evaluation_date");
                    
	return $this->academical_evaluation_model->save($inputs, $academical_evaluation_id);
	}	
	
    //----------------------------------------------------------------
 public function get_academical_evaluation_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("academical_evaluations.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->academical_evaluation_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->academical_evaluation_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->academical_evaluation_model->joinGet($fields, "academical_evaluations", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->academical_evaluations = $this->academical_evaluation_model->joinGet($fields, "academical_evaluations", $join_table, $where);
			return $data;
		}else{
			return $this->academical_evaluation_model->joinGet($fields, "academical_evaluations", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_academical_evaluation($academical_evaluation_id){
	
		$fields = array("academical_evaluations.*");
		$join_table = array();
		$where = "academical_evaluations.academical_evaluation_id = $academical_evaluation_id";
		
		return $this->academical_evaluation_model->joinGet($fields, "academical_evaluations", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

