<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_additional_information_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "product_additional_informations";
        $this->pk = "product_additional_information_id";
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
                            "field"  =>  "product_additional_information_title",
                            "label"  =>  "Product Additional Information Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_additional_information_value",
                            "label"  =>  "Product Additional Information Value",
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
                    
                    $inputs["product_additional_information_title"]  =  $this->input->post("product_additional_information_title");
                    
                    $inputs["product_additional_information_value"]  =  $this->input->post("product_additional_information_value");
                    
	return $this->product_additional_information_model->save($inputs);
	}	 	

public function update_data($product_additional_information_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_id"]  =  $this->input->post("product_id");
                    
                    $inputs["product_additional_information_title"]  =  $this->input->post("product_additional_information_title");
                    
                    $inputs["product_additional_information_value"]  =  $this->input->post("product_additional_information_value");
                    
	return $this->product_additional_information_model->save($inputs, $product_additional_information_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_additional_information_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("product_additional_informations.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_additional_informations.product_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_additional_information_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_additional_information_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_additional_information_model->joinGet($fields, "product_additional_informations", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->product_additional_informations = $this->product_additional_information_model->joinGet($fields, "product_additional_informations", $join_table, $where);
			return $data;
		}else{
			return $this->product_additional_information_model->joinGet($fields, "product_additional_informations", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product_additional_information($product_additional_information_id){
	
		$fields = array("product_additional_informations.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_additional_informations.product_id",
        );
		$where = "product_additional_informations.product_additional_information_id = $product_additional_information_id";
		
		return $this->product_additional_information_model->joinGet($fields, "product_additional_informations", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

