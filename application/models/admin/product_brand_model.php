<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_brand_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "product_brands";
        $this->pk = "product_brand_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "product_brand_title",
                            "label"  =>  "Product Brand Title",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["product_brand_title"]  =  $this->input->post("product_brand_title");
                    
                    if($_FILES["product_brand_image"]["size"] > 0){
                        $inputs["product_brand_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_brand_image");
                    }
                    
	return $this->product_brand_model->save($inputs);
	}	 	

public function update_data($product_brand_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_brand_title"]  =  $this->input->post("product_brand_title");
                    
                    if($_FILES["product_brand_image"]["size"] > 0){
						//remove previous file....
						$product_brands = $this->get_product_brand($product_brand_id);
						$file_path = $product_brands[0]->product_brand_image;
						$this->delete_file($file_path);
                        $inputs["product_brand_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_brand_image");
                    }
                    
	return $this->product_brand_model->save($inputs, $product_brand_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_brand_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("product_brands.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_brand_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_brand_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_brand_model->joinGet($fields, "product_brands", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->product_brands = $this->product_brand_model->joinGet($fields, "product_brands", $join_table, $where);
			return $data;
		}else{
			return $this->product_brand_model->joinGet($fields, "product_brands", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product_brand($product_brand_id){
	
		$fields = array("product_brands.*");
		$join_table = array();
		$where = "product_brands.product_brand_id = $product_brand_id";
		
		return $this->product_brand_model->joinGet($fields, "product_brands", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

