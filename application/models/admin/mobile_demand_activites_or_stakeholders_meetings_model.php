<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Mobile_demand_activites_or_stakeholders_meetings_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "mobile_demand_activites_or_stakeholders_meetings";
        $this->pk = "m_d_a_or_s_m_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "id",
                            "label"  =>  "Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "meeting_id",
                            "label"  =>  "Meeting Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "stakeholder_or_activity_type_id",
                            "label"  =>  "Stakeholder Or Activity Type Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "meeting_demand_id",
                            "label"  =>  "Meeting Demand Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_id",
                            "label"  =>  "User Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "stakeholder_and_activty",
                            "label"  =>  "Stakeholder And Activty",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "stakehoder_rating",
                            "label"  =>  "Stakehoder Rating",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "stakeholder_and_activity_detail",
                            "label"  =>  "Stakeholder And Activity Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["id"]  =  $this->input->post("id");
                    
                    $inputs["meeting_id"]  =  $this->input->post("meeting_id");
                    
                    $inputs["stakeholder_or_activity_type_id"]  =  $this->input->post("stakeholder_or_activity_type_id");
                    
                    $inputs["meeting_demand_id"]  =  $this->input->post("meeting_demand_id");
                    
                    $inputs["user_id"]  =  $this->input->post("user_id");
                    
                    $inputs["stakeholder_and_activty"]  =  $this->input->post("stakeholder_and_activty");
                    
                    $inputs["stakehoder_rating"]  =  $this->input->post("stakehoder_rating");
                    
                    $inputs["stakeholder_and_activity_detail"]  =  $this->input->post("stakeholder_and_activity_detail");
                    
	return $this->mobile_demand_activites_or_stakeholders_meetings_model->save($inputs);
	}	 	

public function update_data($m_d_a_or_s_m_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["id"]  =  $this->input->post("id");
                    
                    $inputs["meeting_id"]  =  $this->input->post("meeting_id");
                    
                    $inputs["stakeholder_or_activity_type_id"]  =  $this->input->post("stakeholder_or_activity_type_id");
                    
                    $inputs["meeting_demand_id"]  =  $this->input->post("meeting_demand_id");
                    
                    $inputs["user_id"]  =  $this->input->post("user_id");
                    
                    $inputs["stakeholder_and_activty"]  =  $this->input->post("stakeholder_and_activty");
                    
                    $inputs["stakehoder_rating"]  =  $this->input->post("stakehoder_rating");
                    
                    $inputs["stakeholder_and_activity_detail"]  =  $this->input->post("stakeholder_and_activity_detail");
                    
	return $this->mobile_demand_activites_or_stakeholders_meetings_model->save($inputs, $m_d_a_or_s_m_id);
	}	
	
    //----------------------------------------------------------------
 public function get_mobile_demand_activites_or_stakeholders_meetings_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("mobile_demand_activites_or_stakeholders_meetings.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->mobile_demand_activites_or_stakeholders_meetings_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->mobile_demand_activites_or_stakeholders_meetings_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->mobile_demand_activites_or_stakeholders_meetings_model->joinGet($fields, "mobile_demand_activites_or_stakeholders_meetings", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->mobile_demand_activites_or_stakeholders_meetings = $this->mobile_demand_activites_or_stakeholders_meetings_model->joinGet($fields, "mobile_demand_activites_or_stakeholders_meetings", $join_table, $where);
			return $data;
		}else{
			return $this->mobile_demand_activites_or_stakeholders_meetings_model->joinGet($fields, "mobile_demand_activites_or_stakeholders_meetings", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_mobile_demand_activites_or_stakeholders_meetings($m_d_a_or_s_m_id){
	
		$fields = array("mobile_demand_activites_or_stakeholders_meetings.*");
		$join_table = array();
		$where = "mobile_demand_activites_or_stakeholders_meetings.m_d_a_or_s_m_id = $m_d_a_or_s_m_id";
		
		return $this->mobile_demand_activites_or_stakeholders_meetings_model->joinGet($fields, "mobile_demand_activites_or_stakeholders_meetings", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

