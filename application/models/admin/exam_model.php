<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Exam_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "exams";
        $this->pk = "exam_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "year",
                            "label"  =>  "Year",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "term",
                            "label"  =>  "Term",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "passing_percentage",
                            "label"  =>  "Passing Percentage",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "promotion_percentage",
                            "label"  =>  "Promotion Percentage",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "exam_data",
                            "label"  =>  "Exam Data",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["year"]  =  $this->input->post("year");
                    
                    $inputs["term"]  =  $this->input->post("term");
                    
                    $inputs["passing_percentage"]  =  $this->input->post("passing_percentage");
                    
                    $inputs["promotion_percentage"]  =  $this->input->post("promotion_percentage");
                    
                    $inputs["exam_data"]  =  $this->input->post("exam_data");
                    
	return $this->exam_model->save($inputs);
	}	 	

public function update_data($exam_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["year"]  =  $this->input->post("year");
                    
                    $inputs["term"]  =  $this->input->post("term");
                    
                    $inputs["passing_percentage"]  =  $this->input->post("passing_percentage");
                    
                    $inputs["promotion_percentage"]  =  $this->input->post("promotion_percentage");
                    
                    $inputs["exam_data"]  =  $this->input->post("exam_data");
                    
	return $this->exam_model->save($inputs, $exam_id);
	}	
	
    //----------------------------------------------------------------
 public function get_exam_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("exams.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->exam_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->exam_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->exam_model->joinGet($fields, "exams", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->exams = $this->exam_model->joinGet($fields, "exams", $join_table, $where);
			return $data;
		}else{
			return $this->exam_model->joinGet($fields, "exams", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_exam($exam_id){
	
		$fields = array("exams.*");
		$join_table = array();
		$where = "exams.exam_id = $exam_id";
		
		return $this->exam_model->joinGet($fields, "exams", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

