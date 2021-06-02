<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Artist_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "artists";
        $this->pk = "audio_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "artist_name",
                            "label"  =>  "Artist Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "artist_detail",
                            "label"  =>  "Artist Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["artist_name"]  =  $this->input->post("artist_name");
                    
                    $inputs["artist_detail"]  =  $this->input->post("artist_detail");
                    
                    if($_FILES["artist_image"]["size"] > 0){
                        $inputs["artist_image"]  =  $this->router->fetch_class()."/".$this->input->post("artist_image");
                    }
                    
	return $this->artist_model->save($inputs);
	}	 	

public function update_data($audio_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["artist_name"]  =  $this->input->post("artist_name");
                    
                    $inputs["artist_detail"]  =  $this->input->post("artist_detail");
                    
                    if($_FILES["artist_image"]["size"] > 0){
						//remove previous file....
						$artists = $this->get_artist($audio_id);
						$file_path = $artists[0]->artist_image;
						$this->delete_file($file_path);
                        $inputs["artist_image"]  =  $this->router->fetch_class()."/".$this->input->post("artist_image");
                    }
                    
	return $this->artist_model->save($inputs, $audio_id);
	}	
	
    //----------------------------------------------------------------
 public function get_artist_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("artists.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->artist_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->artist_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->artist_model->joinGet($fields, "artists", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->artists = $this->artist_model->joinGet($fields, "artists", $join_table, $where);
			return $data;
		}else{
			return $this->artist_model->joinGet($fields, "artists", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_artist($audio_id){
	
		$fields = array("artists.*");
		$join_table = array();
		$where = "artists.audio_id = $audio_id";
		
		return $this->artist_model->joinGet($fields, "artists", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

