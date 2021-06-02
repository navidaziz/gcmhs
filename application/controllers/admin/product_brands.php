<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_brands extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_brand_model");
		$this->lang->load("product_brands", 'english');
		$this->lang->load("system", 'english');
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
		
        $where = "`product_brands`.`status` IN (0, 1) ";
		$data = $this->product_brand_model->get_product_brand_list($where);
		 $this->data["product_brands"] = $data->product_brands;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Brands');
		$this->data["view"] = ADMIN_DIR."product_brands/product_brands";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_brand($product_brand_id){
        
        $product_brand_id = (int) $product_brand_id;
        
        $this->data["product_brands"] = $this->product_brand_model->get_product_brand($product_brand_id);
        $this->data["title"] = $this->lang->line('Product Brand Details');
		$this->data["view"] = ADMIN_DIR."product_brands/view_product_brand";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_brands`.`status` IN (2) ";
		$data = $this->product_brand_model->get_product_brand_list($where);
		 $this->data["product_brands"] = $data->product_brands;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Brands');
		$this->data["view"] = ADMIN_DIR."product_brands/trashed_product_brands";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_brand_id, $page_id = NULL){
        
        $product_brand_id = (int) $product_brand_id;
        
        
        $this->product_brand_model->changeStatus($product_brand_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_brands/view/".$page_id);
    }
    
    /**
      * function to restor product_brand from trash
      * @param $product_brand_id integer
      */
     public function restore($product_brand_id, $page_id = NULL){
        
        $product_brand_id = (int) $product_brand_id;
        
        
        $this->product_brand_model->changeStatus($product_brand_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_brands/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_brand from trash
      * @param $product_brand_id integer
      */
     public function draft($product_brand_id, $page_id = NULL){
        
        $product_brand_id = (int) $product_brand_id;
        
        
        $this->product_brand_model->changeStatus($product_brand_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_brands/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_brand from trash
      * @param $product_brand_id integer
      */
     public function publish($product_brand_id, $page_id = NULL){
        
        $product_brand_id = (int) $product_brand_id;
        
        
        $this->product_brand_model->changeStatus($product_brand_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_brands/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_brand
      * @param $product_brand_id integer
      */
     public function delete($product_brand_id, $page_id = NULL){
        
        $product_brand_id = (int) $product_brand_id;
        //$this->product_brand_model->changeStatus($product_brand_id, "3");
        //Remove file....
						$product_brands = $this->product_brand_model->get_product_brand($product_brand_id);
						$file_path = $product_brands[0]->product_brand_image;
						$this->product_brand_model->delete_file($file_path);
		$this->product_brand_model->delete(array( 'product_brand_id' => $product_brand_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_brands/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_brand
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Product Brand');$this->data["view"] = ADMIN_DIR."product_brands/add_product_brand";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_brand_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_brand_image")){
                       $_POST['product_brand_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_brand_id = $this->product_brand_model->save_data();
          if($product_brand_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_brands/edit/$product_brand_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_brands/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_brand
      */
     public function edit($product_brand_id){
		 $product_brand_id = (int) $product_brand_id;
        $this->data["product_brand"] = $this->product_brand_model->get($product_brand_id);
		  
        $this->data["title"] = $this->lang->line('Edit Product Brand');$this->data["view"] = ADMIN_DIR."product_brands/edit_product_brand";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_brand_id){
		 
		 $product_brand_id = (int) $product_brand_id;
       
	   if($this->product_brand_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_brand_image")){
                         $_POST["product_brand_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_brand_id = $this->product_brand_model->update_data($product_brand_id);
          if($product_brand_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_brands/edit/$product_brand_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_brands/edit/$product_brand_id");
            }
        }else{
			$this->edit($product_brand_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_brands"] = $this->product_brand_model->getBy($where, false, "product_brand_id" );
				$j_array[]=array("id" => "", "value" => "product_brand");
				foreach($data["product_brands"] as $product_brand ){
					$j_array[]=array("id" => $product_brand->product_brand_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
