<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Products extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_model");
		$this->lang->load("products", 'english');
		$this->lang->load("system", 'english');
		
		$this->load->model("admin/product_additional_information_model");
		$this->lang->load("product_additional_informations", 'english');
		
		$this->load->model("admin/product_additional_image_model");
		$this->lang->load("product_additional_images", 'english');
		
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`products`.`status` IN (0, 1) ";
		$data = $this->product_model->get_product_list($where);
		 $this->data["products"] = $data->products;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Products');
		$this->data["view"] = ADMIN_DIR."products/products";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product($product_id){
        
        $product_id = (int) $product_id;
        
        $this->data["products"] = $this->product_model->get_product($product_id);
        $this->data["title"] = $this->lang->line('Product Details');
		$this->data["view"] = ADMIN_DIR."products/view_product";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`products`.`status` IN (2) ";
		$data = $this->product_model->get_product_list($where);
		 $this->data["products"] = $data->products;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Products');
		$this->data["view"] = ADMIN_DIR."products/trashed_products";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_id, $page_id = NULL){
        
        $product_id = (int) $product_id;
        
        
        $this->product_model->changeStatus($product_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."products/view/".$page_id);
    }
    
    /**
      * function to restor product from trash
      * @param $product_id integer
      */
     public function restore($product_id, $page_id = NULL){
        
        $product_id = (int) $product_id;
        
        
        $this->product_model->changeStatus($product_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."products/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product from trash
      * @param $product_id integer
      */
     public function draft($product_id, $page_id = NULL){
        
        $product_id = (int) $product_id;
        
        
        $this->product_model->changeStatus($product_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."products/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product from trash
      * @param $product_id integer
      */
     public function publish($product_id, $page_id = NULL){
        
        $product_id = (int) $product_id;
        
        
        $this->product_model->changeStatus($product_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."products/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product
      * @param $product_id integer
      */
     public function delete($product_id, $page_id = NULL){
        
        $product_id = (int) $product_id;
        //$this->product_model->changeStatus($product_id, "3");
        //Remove file....
						$products = $this->product_model->get_product($product_id);
						$file_path = $products[0]->product_main_image;
						$this->product_model->delete_file($file_path);
		$this->product_model->delete(array( 'product_id' => $product_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."products/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product
      */
     public function add(){
		
    $this->data["product_categories"] = $this->product_model->getList("PRODUCT_CATEGORIES", "product_category_id", "product_category_title", $where ="");
    
    $this->data["product_types"] = $this->product_model->getList("PRODUCT_TYPES", "product_type_id", "product_type_title", $where ="");
    
    $this->data["product_sub_types"] = $this->product_model->getList("PRODUCT_SUB_TYPES", "product_sub_type_id", "product_sub_type_title", $where ="");
    
    $this->data["product_brands"] = $this->product_model->getList("PRODUCT_BRANDS", "product_brand_id", "product_brand_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Product');$this->data["view"] = ADMIN_DIR."products/add_product";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
		 
			 
	  if($this->product_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_main_image")){
                       $_POST['product_main_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_id = $this->product_model->save_data();
          if($product_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."products/edit/$product_id");
				
				//add additional infromation 
				for($index=0; $index <= count($this->input->post('product_additional_information_title')); $index++){
					
					}
				
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."products/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product
      */
     public function edit($product_id){
		 $product_id = (int) $product_id;
        $this->data["product"] = $this->product_model->get($product_id);
		  
    $this->data["product_categories"] = $this->product_model->getList("PRODUCT_CATEGORIES", "product_category_id", "product_category_title", $where ="");
    
    $this->data["product_types"] = $this->product_model->getList("PRODUCT_TYPES", "product_type_id", "product_type_title", $where ="");
    
    $this->data["product_sub_types"] = $this->product_model->getList("PRODUCT_SUB_TYPES", "product_sub_type_id", "product_sub_type_title", $where ="");
    
    $this->data["product_brands"] = $this->product_model->getList("PRODUCT_BRANDS", "product_brand_id", "product_brand_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Product');$this->data["view"] = ADMIN_DIR."products/edit_product";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_id){
		 
		 $product_id = (int) $product_id;
       
	   if($this->product_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_main_image")){
                         $_POST["product_main_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_id = $this->product_model->update_data($product_id);
          if($product_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."products/edit/$product_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."products/edit/$product_id");
            }
        }else{
			$this->edit($product_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["products"] = $this->product_model->getBy($where, false, "product_id" );
				$j_array[]=array("id" => "", "value" => "product");
				foreach($data["products"] as $product ){
					$j_array[]=array("id" => $product->product_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
