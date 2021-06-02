<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_types extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_type_model");
		$this->lang->load("product_types", 'english');
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
		
        $where = "`product_types`.`status` IN (0, 1) ";
		$data = $this->product_type_model->get_product_type_list($where);
		 $this->data["product_types"] = $data->product_types;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Types');
		$this->data["view"] = ADMIN_DIR."product_types/product_types";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_type($product_type_id){
        
        $product_type_id = (int) $product_type_id;
        
        $this->data["product_types"] = $this->product_type_model->get_product_type($product_type_id);
        $this->data["title"] = $this->lang->line('Product Type Details');
		$this->data["view"] = ADMIN_DIR."product_types/view_product_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_types`.`status` IN (2) ";
		$data = $this->product_type_model->get_product_type_list($where);
		 $this->data["product_types"] = $data->product_types;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Types');
		$this->data["view"] = ADMIN_DIR."product_types/trashed_product_types";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_type_id, $page_id = NULL){
        
        $product_type_id = (int) $product_type_id;
        
        
        $this->product_type_model->changeStatus($product_type_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_types/view/".$page_id);
    }
    
    /**
      * function to restor product_type from trash
      * @param $product_type_id integer
      */
     public function restore($product_type_id, $page_id = NULL){
        
        $product_type_id = (int) $product_type_id;
        
        
        $this->product_type_model->changeStatus($product_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_types/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_type from trash
      * @param $product_type_id integer
      */
     public function draft($product_type_id, $page_id = NULL){
        
        $product_type_id = (int) $product_type_id;
        
        
        $this->product_type_model->changeStatus($product_type_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_types/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_type from trash
      * @param $product_type_id integer
      */
     public function publish($product_type_id, $page_id = NULL){
        
        $product_type_id = (int) $product_type_id;
        
        
        $this->product_type_model->changeStatus($product_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_types/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_type
      * @param $product_type_id integer
      */
     public function delete($product_type_id, $page_id = NULL){
        
        $product_type_id = (int) $product_type_id;
        //$this->product_type_model->changeStatus($product_type_id, "3");
        //Remove file....
						$product_types = $this->product_type_model->get_product_type($product_type_id);
						$file_path = $product_types[0]->product_type_image;
						$this->product_type_model->delete_file($file_path);
		$this->product_type_model->delete(array( 'product_type_id' => $product_type_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_types/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_type
      */
     public function add(){
		
    $this->data["product_categories"] = $this->product_type_model->getList("PRODUCT_CATEGORIES", "product_category_id", "product_category_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Product Type');$this->data["view"] = ADMIN_DIR."product_types/add_product_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_type_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_type_image")){
                       $_POST['product_type_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_type_id = $this->product_type_model->save_data();
          if($product_type_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_types/edit/$product_type_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_types/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_type
      */
     public function edit($product_type_id){
		 $product_type_id = (int) $product_type_id;
        $this->data["product_type"] = $this->product_type_model->get($product_type_id);
		  
    $this->data["product_categories"] = $this->product_type_model->getList("PRODUCT_CATEGORIES", "product_category_id", "product_category_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Product Type');$this->data["view"] = ADMIN_DIR."product_types/edit_product_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_type_id){
		 
		 $product_type_id = (int) $product_type_id;
       
	   if($this->product_type_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_type_image")){
                         $_POST["product_type_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_type_id = $this->product_type_model->update_data($product_type_id);
          if($product_type_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_types/edit/$product_type_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_types/edit/$product_type_id");
            }
        }else{
			$this->edit($product_type_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_types"] = $this->product_type_model->getBy($where, false, "product_type_id" );
				$j_array[]=array("id" => "", "value" => "product_type");
				foreach($data["product_types"] as $product_type ){
					$j_array[]=array("id" => $product_type->product_type_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
