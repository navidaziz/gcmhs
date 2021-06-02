<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "products";
        $this->pk = "product_id";
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
                            "field"  =>  "product_type_id",
                            "label"  =>  "Product Type Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_sub_type_id",
                            "label"  =>  "Product Sub Type Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_brand_id",
                            "label"  =>  "Product Brand Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_title",
                            "label"  =>  "Product Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_short_detail",
                            "label"  =>  "Product Short Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_detail",
                            "label"  =>  "Product Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_price",
                            "label"  =>  "Product Price",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_in_stock",
                            "label"  =>  "Product In Stock",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "product_on_sale",
                            "label"  =>  "Product On Sale",
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
                    
                    $inputs["product_type_id"]  =  $this->input->post("product_type_id");
                    
                    $inputs["product_sub_type_id"]  =  $this->input->post("product_sub_type_id");
                    
                    $inputs["product_brand_id"]  =  $this->input->post("product_brand_id");
                    
                    $inputs["product_title"]  =  $this->input->post("product_title");
                    
                    $inputs["product_short_detail"]  =  $this->input->post("product_short_detail");
                    
                    $inputs["product_detail"]  =  $this->input->post("product_detail");
                    
                    $inputs["product_price"]  =  $this->input->post("product_price");
                    
                    if($_FILES["product_main_image"]["size"] > 0){
                        $inputs["product_main_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_main_image");
                    }
                    
                    $inputs["product_in_stock"]  =  $this->input->post("product_in_stock");
                    
                    $inputs["product_on_sale"]  =  $this->input->post("product_on_sale");
                    
	return $this->product_model->save($inputs);
	}	 	

public function update_data($product_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_category_id"]  =  $this->input->post("product_category_id");
                    
                    $inputs["product_type_id"]  =  $this->input->post("product_type_id");
                    
                    $inputs["product_sub_type_id"]  =  $this->input->post("product_sub_type_id");
                    
                    $inputs["product_brand_id"]  =  $this->input->post("product_brand_id");
                    
                    $inputs["product_title"]  =  $this->input->post("product_title");
                    
                    $inputs["product_short_detail"]  =  $this->input->post("product_short_detail");
                    
                    $inputs["product_detail"]  =  $this->input->post("product_detail");
                    
                    $inputs["product_price"]  =  $this->input->post("product_price");
                    
                    if($_FILES["product_main_image"]["size"] > 0){
						//remove previous file....
						$products = $this->get_product($product_id);
						$file_path = $products[0]->product_main_image;
						$this->delete_file($file_path);
                        $inputs["product_main_image"]  =  $this->router->fetch_class()."/".$this->input->post("product_main_image");
                    }
                    
                    $inputs["product_in_stock"]  =  $this->input->post("product_in_stock");
                    
                    $inputs["product_on_sale"]  =  $this->input->post("product_on_sale");
                    
	return $this->product_model->save($inputs, $product_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("products.*"
                , "product_categories.product_category_title"
            
                , "product_types.product_type_title"
            
                , "product_sub_types.product_sub_type_title"
            
                , "product_brands.product_brand_title"
            );
		$join_table = array(
            "product_categories" => "product_categories.product_category_id = products.product_category_id",
        
            "product_types" => "product_types.product_type_id = products.product_type_id",
        
            "product_sub_types" => "product_sub_types.product_sub_type_id = products.product_sub_type_id",
        
            "product_brands" => "product_brands.product_brand_id = products.product_brand_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_model->joinGet($fields, "products", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->products = $this->product_model->joinGet($fields, "products", $join_table, $where);
			return $data;
		}else{
			return $this->product_model->joinGet($fields, "products", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product($product_id){
	
		$fields = array("products.*"
                , "product_categories.product_category_title"
            
                , "product_types.product_type_title"
            
                , "product_sub_types.product_sub_type_title"
            
                , "product_brands.product_brand_title"
            );
		$join_table = array(
            "product_categories" => "product_categories.product_category_id = products.product_category_id",
        
            "product_types" => "product_types.product_type_id = products.product_type_id",
        
            "product_sub_types" => "product_sub_types.product_sub_type_id = products.product_sub_type_id",
        
            "product_brands" => "product_brands.product_brand_id = products.product_brand_id",
        );
		$where = "products.product_id = $product_id";
		
		return $this->product_model->joinGet($fields, "products", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

