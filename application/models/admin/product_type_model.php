<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_type_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "product_types";
        $this->pk = "product_type_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "product_category_id",
                            "label"  =>  "Product Category Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_type_title",
                            "label"  =>  "Product Type Title",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["product_category_id"]  =  $this->input->post("product_category_id");
                    
                    $inputs["product_type_title"]  =  $this->input->post("product_type_title");
                    
                    if($_FILES["product_type_image"]["size"] > 0){
                        $inputs["product_type_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_type_image");
                    }
                    
	return $this->product_type_model->save($inputs);
	}	 	

public function update_data($product_type_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_category_id"]  =  $this->input->post("product_category_id");
                    
                    $inputs["product_type_title"]  =  $this->input->post("product_type_title");
                    
                    if($_FILES["product_type_image"]["size"] > 0){
						//remove previous file....
						$product_types = $this->get_product_type($product_type_id);
						$file_path = $product_types[0]->product_type_image;
						$this->delete_file($file_path);
                        $inputs["product_type_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_type_image");
                    }
                    
	return $this->product_type_model->save($inputs, $product_type_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_type_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("product_types.*"
                , "product_categories.product_category_title"
            );
		$join_table = array(
            "product_categories" => "product_categories.product_category_id = product_types.product_category_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_type_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_type_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_type_model->joinGet($fields, "product_types", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->product_types = $this->product_type_model->joinGet($fields, "product_types", $join_table, $where);
			return $data;
		}else{
			return $this->product_type_model->joinGet($fields, "product_types", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product_type($product_type_id){
	
		$fields = array("product_types.*"
                , "product_categories.product_category_title"
            );
		$join_table = array(
            "product_categories" => "product_categories.product_category_id = product_types.product_category_id",
        );
		$where = "product_types.product_type_id = $product_type_id";
		
		return $this->product_type_model->joinGet($fields, "product_types", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

