<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Album_image_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "album_images";
        $this->pk = "album_image_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "gallery_id",
                            "label"  =>  "Gallery Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "image_detail",
                            "label"  =>  "Image Detail",
                            "rules"  =>  "required"
                        ),
                        
                       
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    
                    $inputs["gallery_id"]  =  $this->input->post("gallery_id");
                    
                    $inputs["image_detail"]  =  $this->input->post("image_detail");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->album_image_model->save($inputs);
	}	 	

public function update_data($album_image_id, $image_field= NULL){
	$inputs = array();
            
                    
                    $inputs["gallery_id"]  =  $this->input->post("gallery_id");
                    
                    $inputs["image_detail"]  =  $this->input->post("image_detail");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$album_images = $this->get_album_image($album_image_id);
						$file_path = $album_images[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->album_image_model->save($inputs, $album_image_id);
	}	
	
    //----------------------------------------------------------------
 public function get_album_image_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("album_images.*"
                , "gallery.album_title"
            );
		$join_table = array(
            "gallery" => "gallery.GALLERY_ID = album_images.GALLERY_ID",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->album_image_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->album_image_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->album_image_model->joinGet($fields, "album_images", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->album_images = $this->album_image_model->joinGet($fields, "album_images", $join_table, $where);
			return $data;
		}else{
			return $this->album_image_model->joinGet($fields, "album_images", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_album_image($album_image_id){
	
		$fields = array("album_images.*"
                , "gallery.album_title"
            );
		$join_table = array(
            "gallery" => "gallery.GALLERY_ID = album_images.GALLERY_ID",
        );
		$where = "album_images.album_image_id = $album_image_id";
		
		return $this->album_image_model->joinGet($fields, "album_images", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

