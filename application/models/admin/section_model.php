<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Section_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "sections";
        $this->pk = "section_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "section_title",
                            "label"  =>  "Section Title",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["section_title"]  =  $this->input->post("section_title");
                    
	return $this->section_model->save($inputs);
	}	 	

public function update_data($section_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["section_title"]  =  $this->input->post("section_title");
                    
	return $this->section_model->save($inputs, $section_id);
	}	
	
    //----------------------------------------------------------------
 public function get_section_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("sections.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->section_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->section_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->section_model->joinGet($fields, "sections", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->sections = $this->section_model->joinGet($fields, "sections", $join_table, $where);
			return $data;
		}else{
			return $this->section_model->joinGet($fields, "sections", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_section($section_id){
	
		$fields = array("sections.*");
		$join_table = array();
		$where = "sections.section_id = $section_id";
		
		return $this->section_model->joinGet($fields, "sections", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

