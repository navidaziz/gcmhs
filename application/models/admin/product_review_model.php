<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Product_review_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "product_reviews";
        $this->pk = "product_review_id";
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
                            "field"  =>  "name",
                            "label"  =>  "Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "contact_detail",
                            "label"  =>  "Contact Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "rating",
                            "label"  =>  "Rating",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "review_detail",
                            "label"  =>  "Review Detail",
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
                    
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["contact_detail"]  =  $this->input->post("contact_detail");
                    
                    $inputs["rating"]  =  $this->input->post("rating");
                    
                    $inputs["review_detail"]  =  $this->input->post("review_detail");
                    
	return $this->product_review_model->save($inputs);
	}	 	

public function update_data($product_review_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["product_id"]  =  $this->input->post("product_id");
                    
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["contact_detail"]  =  $this->input->post("contact_detail");
                    
                    $inputs["rating"]  =  $this->input->post("rating");
                    
                    $inputs["review_detail"]  =  $this->input->post("review_detail");
                    
	return $this->product_review_model->save($inputs, $product_review_id);
	}	
	
    //----------------------------------------------------------------
 public function get_product_review_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("product_reviews.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_reviews.product_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->product_review_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->product_review_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->product_review_model->joinGet($fields, "product_reviews", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->product_reviews = $this->product_review_model->joinGet($fields, "product_reviews", $join_table, $where);
			return $data;
		}else{
			return $this->product_review_model->joinGet($fields, "product_reviews", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_product_review($product_review_id){
	
		$fields = array("product_reviews.*"
                , "products.product_title"
            );
		$join_table = array(
            "products" => "products.product_id = product_reviews.product_id",
        );
		$where = "product_reviews.product_review_id = $product_review_id";
		
		return $this->product_review_model->joinGet($fields, "product_reviews", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

