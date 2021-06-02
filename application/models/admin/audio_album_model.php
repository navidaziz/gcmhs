<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Audio_album_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "audio_albums";
        $this->pk = "audio_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "audio_album_name",
                            "label"  =>  "Audio Album Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_album_detail",
                            "label"  =>  "Audio Album Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "audio_album_image",
                            "label"  =>  "Audio Album Image",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["audio_album_name"]  =  $this->input->post("audio_album_name");
                    
                    $inputs["audio_album_detail"]  =  $this->input->post("audio_album_detail");
                    
                    if($_FILES["audio_album_image"]["size"] > 0){
                        $inputs["audio_album_image"]  =  $this->router->fetch_class()."/".$this->input->post("audio_album_image");
                    }
                    
	return $this->audio_album_model->save($inputs);
	}	 	

public function update_data($audio_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["audio_album_name"]  =  $this->input->post("audio_album_name");
                    
                    $inputs["audio_album_detail"]  =  $this->input->post("audio_album_detail");
                    
                    if($_FILES["audio_album_image"]["size"] > 0){
						//remove previous file....
						$audio_albums = $this->get_audio_album($audio_id);
						$file_path = $audio_albums[0]->audio_album_image;
						$this->delete_file($file_path);
                        $inputs["audio_album_image"]  =  $this->router->fetch_class()."/".$this->input->post("audio_album_image");
                    }
                    
	return $this->audio_album_model->save($inputs, $audio_id);
	}	
	
    //----------------------------------------------------------------
 public function get_audio_album_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("audio_albums.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->audio_album_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->audio_album_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->audio_album_model->joinGet($fields, "audio_albums", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->audio_albums = $this->audio_album_model->joinGet($fields, "audio_albums", $join_table, $where);
			return $data;
		}else{
			return $this->audio_album_model->joinGet($fields, "audio_albums", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_audio_album($audio_id){
	
		$fields = array("audio_albums.*");
		$join_table = array();
		$where = "audio_albums.audio_id = $audio_id";
		
		return $this->audio_album_model->joinGet($fields, "audio_albums", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

