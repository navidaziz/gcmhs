<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Result_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "results";
        $this->pk = "result_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "class_no",
                            "label"  =>  "Class No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "admission_no",
                            "label"  =>  "Admission No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "roll_no",
                            "label"  =>  "Roll No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "session",
                            "label"  =>  "Session",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "class",
                            "label"  =>  "Class",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "section",
                            "label"  =>  "Section",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "student_name",
                            "label"  =>  "Student Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "islamiyat",
                            "label"  =>  "Islamiyat",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "urdu",
                            "label"  =>  "Urdu",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "english",
                            "label"  =>  "English",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "math",
                            "label"  =>  "Math",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "arabi",
                            "label"  =>  "Arabi",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "drawing",
                            "label"  =>  "Drawing",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "computer",
                            "label"  =>  "Computer",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "general_science",
                            "label"  =>  "General Studies",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "history_geography",
                            "label"  =>  "History Geography",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["class_no"]  =  $this->input->post("class_no");
                    
                    $inputs["admission_no"]  =  $this->input->post("admission_no");
                    
                    $inputs["roll_no"]  =  $this->input->post("roll_no");
                    
                    $inputs["session"]  =  $this->input->post("session");
                    
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["section"]  =  $this->input->post("section");
                    
                    $inputs["student_name"]  =  $this->input->post("student_name");
                    
                    $inputs["islamiyat"]  =  $this->input->post("islamiyat");
                    
                    $inputs["urdu"]  =  $this->input->post("urdu");
                    
                    $inputs["english"]  =  $this->input->post("english");
                    
                    $inputs["math"]  =  $this->input->post("math");
                    
                    $inputs["arabi"]  =  $this->input->post("arabi");
                    
                    $inputs["drawing"]  =  $this->input->post("drawing");
                    
                    $inputs["computer"]  =  $this->input->post("computer");
                    
                    $inputs["general_science"]  =  $this->input->post("general_science");
                    
                    $inputs["history_geography"]  =  $this->input->post("history_geography");
                    
	return $this->result_model->save($inputs);
	}	 	

public function update_data($result_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["class_no"]  =  $this->input->post("class_no");
                    
                    $inputs["admission_no"]  =  $this->input->post("admission_no");
                    
                    $inputs["roll_no"]  =  $this->input->post("roll_no");
                    
                    $inputs["session"]  =  $this->input->post("session");
                    
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["section"]  =  $this->input->post("section");
                    
                    $inputs["student_name"]  =  $this->input->post("student_name");
                    
                    $inputs["islamiyat"]  =  $this->input->post("islamiyat");
                    
                    $inputs["urdu"]  =  $this->input->post("urdu");
                    
                    $inputs["english"]  =  $this->input->post("english");
                    
                    $inputs["math"]  =  $this->input->post("math");
                    
                    $inputs["arabi"]  =  $this->input->post("arabi");
                    
                    $inputs["drawing"]  =  $this->input->post("drawing");
                    
                    $inputs["computer"]  =  $this->input->post("computer");
                    
                    $inputs["general_science"]  =  $this->input->post("general_science");
                    
                    $inputs["history_geography"]  =  $this->input->post("history_geography");
                    
	return $this->result_model->save($inputs, $result_id);
	}	
	
    //----------------------------------------------------------------
 public function get_result_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("results.*, (`islamiyat` + `urdu` + `english` + `math` + `arabi` + `drawing` + `computer` + `general_science` + `history_geography`) AS obtain_marks");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->result_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->result_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->result_model->joinGet($fields, "results", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->results = $this->result_model->joinGet($fields, "results", $join_table, $where);
			return $data;
		}else{
			
		//	exit();
			return $this->result_model->joinGet($fields, "results", $join_table, $where, FALSE, TRUE, "obtain_marks DESC");
		}
		
	}

public function get_result($result_id){
	
		$fields = array("results.*");
		$join_table = array();
		$where = "results.result_id = $result_id";
		
		return $this->result_model->joinGet($fields, "results", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

