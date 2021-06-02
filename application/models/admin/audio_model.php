<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Audio_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "audios";
        $this->pk = "audio_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "audio_name",
                            "label"  =>  "Audio Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "singer_name",
                            "label"  =>  "Singer Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "writer_name",
                            "label"  =>  "Writer Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_type",
                            "label"  =>  "Audio Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_album",
                            "label"  =>  "Audio Album",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_detail",
                            "label"  =>  "Audio Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_comment",
                            "label"  =>  "Audio Comment",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_year",
                            "label"  =>  "Audio Year",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["audio_name"]  =  $this->input->post("audio_name");
                    
                    $inputs["singer_name"]  =  $this->input->post("singer_name");
                    
                    $inputs["writer_name"]  =  $this->input->post("writer_name");
                    
                    $inputs["audio_type"]  =  $this->input->post("audio_type");
                    
                    $inputs["audio_album"]  =  $this->input->post("audio_album");
                    
                    $inputs["audio_detail"]  =  $this->input->post("audio_detail");
                    
                    $inputs["audio_comment"]  =  $this->input->post("audio_comment");
                    
                    $inputs["audio_year"]  =  $this->input->post("audio_year");
                    
                    if($_FILES["audio_file"]["size"] > 0){
                        $inputs["audio_file"]  =  $this->router->fetch_class()."/".$this->input->post("audio_file");
                    }
                    
                    if($_FILES["audio_image"]["size"] > 0){
                        $inputs["audio_image"]  =  $this->router->fetch_class()."/".$this->input->post("audio_image");
                    }
                    
	return $this->audio_model->save($inputs);
	}	 	

public function update_data($audio_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["audio_name"]  =  $this->input->post("audio_name");
                    
                    $inputs["singer_name"]  =  $this->input->post("singer_name");
                    
                    $inputs["writer_name"]  =  $this->input->post("writer_name");
                    
                    $inputs["audio_type"]  =  $this->input->post("audio_type");
                    
                    $inputs["audio_album"]  =  $this->input->post("audio_album");
                    
                    $inputs["audio_detail"]  =  $this->input->post("audio_detail");
                    
                    $inputs["audio_comment"]  =  $this->input->post("audio_comment");
                    
                    $inputs["audio_year"]  =  $this->input->post("audio_year");
                    
                    if($_FILES["audio_file"]["size"] > 0){
						//remove previous file....
						$audios = $this->get_audio($audio_id);
						$file_path = $audios[0]->audio_file;
						$this->delete_file($file_path);
                        $inputs["audio_file"]  =  $this->router->fetch_class()."/".$this->input->post("audio_file");
                    }
                    
                    if($_FILES["audio_image"]["size"] > 0){
						//remove previous file....
						$audios = $this->get_audio($audio_id);
						$file_path = $audios[0]->audio_image;
						$this->delete_file($file_path);
                        $inputs["audio_image"]  =  $this->router->fetch_class()."/".$this->input->post("audio_image");
                    }
                    
	return $this->audio_model->save($inputs, $audio_id);
	}	
	
    //----------------------------------------------------------------
 public function get_audio_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("audios.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->audio_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->audio_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->audio_model->joinGet($fields, "audios", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->audios = $this->audio_model->joinGet($fields, "audios", $join_table, $where);
			return $data;
		}else{
			return $this->audio_model->joinGet($fields, "audios", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_audio($audio_id){
	
		$fields = array("audios.*");
		$join_table = array();
		$where = "audios.audio_id = $audio_id";
		
		return $this->audio_model->joinGet($fields, "audios", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

