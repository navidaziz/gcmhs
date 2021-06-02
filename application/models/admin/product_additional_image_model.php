<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_additional_image_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "product_additional_images";
        $this->pk = "product_additional_image_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "product_id",
                            "label"  =>  "Product Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_additional_image",
                            "label"  =>  "Product Additional Image",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_additional_image_detail",
                            "label"  =>  "Product Additional Image Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["product_id"]  =  $this->input->post("product_id");
                    
                    if($_FILES["product_additional_image"]["size"] > 0){
                        $inputs["product_additional_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_additional_image");
                    }
                    
                    $inputs["product_additional_image_detail"]  =  $this->input->post("product_additional_image_detail");
                    
	return $this->product_additional_image_model->save($inputs);
	}	 	

public function update_data($product_additional_image_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_id"]  =  $this->input->post("product_id");
                    
                    if($_FILES["product_additional_image"]["size"] > 0){
						//remove previous file....
						$product_additional_images = $this->get_product_additional_image($product_additional_image_id);
						$file_path = $product_additional_images[0]->product_additional_image;
						$this->delete_file($file_path);
                        $inputs["product_additional_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_additional_image");
                    }
                    
                    $inputs["product_additional_image_detail"]  =  $this->input->post("product_additional_image_detail");
                    
	return $this->product_additional_image_model->save($inputs, $product_additional_image_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_additional_image_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("product_additional_images.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_additional_images.product_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_additional_image_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_additional_image_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_additional_image_model->joinGet($fields, "product_additional_images", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->product_additional_images = $this->product_additional_image_model->joinGet($fields, "product_additional_images", $join_table, $where);
			return $data;
		}else{
			return $this->product_additional_image_model->joinGet($fields, "product_additional_images", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product_additional_image($product_additional_image_id){
	
		$fields = array("product_additional_images.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_additional_images.product_id",
        );
		$where = "product_additional_images.product_additional_image_id = $product_additional_image_id";
		
		return $this->product_additional_image_model->joinGet($fields, "product_additional_images", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

