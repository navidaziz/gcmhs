<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_reviews extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_review_model");
		$this->lang->load("product_reviews", 'english');
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
		
        $where = "`product_reviews`.`status` IN (0, 1) ";
		$data = $this->product_review_model->get_product_review_list($where);
		 $this->data["product_reviews"] = $data->product_reviews;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Reviews');
		$this->data["view"] = ADMIN_DIR."product_reviews/product_reviews";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_review($product_review_id){
        
        $product_review_id = (int) $product_review_id;
        
        $this->data["product_reviews"] = $this->product_review_model->get_product_review($product_review_id);
        $this->data["title"] = $this->lang->line('Product Review Details');
		$this->data["view"] = ADMIN_DIR."product_reviews/view_product_review";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_reviews`.`status` IN (2) ";
		$data = $this->product_review_model->get_product_review_list($where);
		 $this->data["product_reviews"] = $data->product_reviews;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Reviews');
		$this->data["view"] = ADMIN_DIR."product_reviews/trashed_product_reviews";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_review_id, $page_id = NULL){
        
        $product_review_id = (int) $product_review_id;
        
        
        $this->product_review_model->changeStatus($product_review_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_reviews/view/".$page_id);
    }
    
    /**
      * function to restor product_review from trash
      * @param $product_review_id integer
      */
     public function restore($product_review_id, $page_id = NULL){
        
        $product_review_id = (int) $product_review_id;
        
        
        $this->product_review_model->changeStatus($product_review_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_reviews/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_review from trash
      * @param $product_review_id integer
      */
     public function draft($product_review_id, $page_id = NULL){
        
        $product_review_id = (int) $product_review_id;
        
        
        $this->product_review_model->changeStatus($product_review_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_reviews/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_review from trash
      * @param $product_review_id integer
      */
     public function publish($product_review_id, $page_id = NULL){
        
        $product_review_id = (int) $product_review_id;
        
        
        $this->product_review_model->changeStatus($product_review_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_reviews/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_review
      * @param $product_review_id integer
      */
     public function delete($product_review_id, $page_id = NULL){
        
        $product_review_id = (int) $product_review_id;
        //$this->product_review_model->changeStatus($product_review_id, "3");
        
		$this->product_review_model->delete(array( 'product_review_id' => $product_review_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_reviews/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_review
      */
     public function add(){
		
    $this->data["products"] = $this->product_review_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Product Review');$this->data["view"] = ADMIN_DIR."product_reviews/add_product_review";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_review_model->validate_form_data() === TRUE){
		  
		  $product_review_id = $this->product_review_model->save_data();
          if($product_review_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_reviews/edit/$product_review_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_reviews/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_review
      */
     public function edit($product_review_id){
		 $product_review_id = (int) $product_review_id;
        $this->data["product_review"] = $this->product_review_model->get($product_review_id);
		  
    $this->data["products"] = $this->product_review_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Product Review');$this->data["view"] = ADMIN_DIR."product_reviews/edit_product_review";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_review_id){
		 
		 $product_review_id = (int) $product_review_id;
       
	   if($this->product_review_model->validate_form_data() === TRUE){
		  
		  $product_review_id = $this->product_review_model->update_data($product_review_id);
          if($product_review_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_reviews/edit/$product_review_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_reviews/edit/$product_review_id");
            }
        }else{
			$this->edit($product_review_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_reviews"] = $this->product_review_model->getBy($where, false, "product_review_id" );
				$j_array[]=array("id" => "", "value" => "product_review");
				foreach($data["product_reviews"] as $product_review ){
					$j_array[]=array("id" => $product_review->product_review_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
