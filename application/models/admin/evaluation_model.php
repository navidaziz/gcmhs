<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Evaluation_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "evaluations";
        $this->pk = "evaluation_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "academical_evaluation_id",
                            "label"  =>  "Academical Evaluation Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "class_id",
                            "label"  =>  "Class Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "section_id",
                            "label"  =>  "Section Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "subject_id",
                            "label"  =>  "Subject Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "kpi_id",
                            "label"  =>  "Kpi Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "rate",
                            "label"  =>  "Rate",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "teacher_name",
                            "label"  =>  "Teacher Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "evaluator",
                            "label"  =>  "Evaluator",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["academical_evaluation_id"]  =  $this->input->post("academical_evaluation_id");
                    
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["section_id"]  =  $this->input->post("section_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["kpi_id"]  =  $this->input->post("kpi_id");
                    
                    $inputs["rate"]  =  $this->input->post("rate");
                    
                    $inputs["teacher_name"]  =  $this->input->post("teacher_name");
                    
                    $inputs["evaluator"]  =  $this->input->post("evaluator");
                    
	return $this->evaluation_model->save($inputs);
	}	 	

public function update_data($evaluation_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["academical_evaluation_id"]  =  $this->input->post("academical_evaluation_id");
                    
                    $inputs["class_id"]  =  $this->input->post("class_id");
                    
                    $inputs["section_id"]  =  $this->input->post("section_id");
                    
                    $inputs["subject_id"]  =  $this->input->post("subject_id");
                    
                    $inputs["kpi_id"]  =  $this->input->post("kpi_id");
                    
                    $inputs["rate"]  =  $this->input->post("rate");
                    
                    $inputs["teacher_name"]  =  $this->input->post("teacher_name");
                    
                    $inputs["evaluator"]  =  $this->input->post("evaluator");
                    
	return $this->evaluation_model->save($inputs, $evaluation_id);
	}	
	
    //----------------------------------------------------------------
 public function get_evaluation_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("evaluations.*"
                , "academical_evaluation.academical_evaluation_title"
            
                , "classes.Class_title"
            
                , "sections.section_title"
            
                , "subjects.subject_title"
            
                , "kpis.kpi_title"
            );
		$join_table = array(
            "academical_evaluation" => "academical_evaluation.academical_evaluation_id = evaluations.academical_evaluation_id",
        
            "classes" => "classes.class_id = evaluations.class_id",
        
            "sections" => "sections.section_id = evaluations.section_id",
        
            "subjects" => "subjects.subject_id = evaluations.subject_id",
        
            "kpis" => "kpis.kpi_id = evaluations.kpi_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->evaluation_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->evaluation_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->evaluation_model->joinGet($fields, "evaluations", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->evaluations = $this->evaluation_model->joinGet($fields, "evaluations", $join_table, $where);
			return $data;
		}else{
			return $this->evaluation_model->joinGet($fields, "evaluations", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_evaluation($evaluation_id){
	
		$fields = array("evaluations.*"
                , "academical_evaluation.academical_evaluation_title"
            
                , "classes.Class_title"
            
                , "sections.section_title"
            
                , "subjects.subject_title"
            
                , "kpis.kpi_title"
            );
		$join_table = array(
            "academical_evaluation" => "academical_evaluation.academical_evaluation_id = evaluations.academical_evaluation_id",
        
            "classes" => "classes.class_id = evaluations.class_id",
        
            "sections" => "sections.section_id = evaluations.section_id",
        
            "subjects" => "subjects.subject_id = evaluations.subject_id",
        
            "kpis" => "kpis.kpi_id = evaluations.kpi_id",
        );
		$where = "evaluations.evaluation_id = $evaluation_id";
		
		return $this->evaluation_model->joinGet($fields, "evaluations", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

