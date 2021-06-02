<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_categories extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_category_model");
		$this->lang->load("product_categories", 'english');
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
		
        $where = "`product_categories`.`status` IN (0, 1) ";
		$data = $this->product_category_model->get_product_category_list($where);
		 $this->data["product_categories"] = $data->product_categories;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Categories');
		$this->data["view"] = ADMIN_DIR."product_categories/product_categories";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_category($product_category_id){
        
        $product_category_id = (int) $product_category_id;
        
        $this->data["product_categories"] = $this->product_category_model->get_product_category($product_category_id);
        $this->data["title"] = $this->lang->line('Product Category Details');
		$this->data["view"] = ADMIN_DIR."product_categories/view_product_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_categories`.`status` IN (2) ";
		$data = $this->product_category_model->get_product_category_list($where);
		 $this->data["product_categories"] = $data->product_categories;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Categories');
		$this->data["view"] = ADMIN_DIR."product_categories/trashed_product_categories";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_category_id, $page_id = NULL){
        
        $product_category_id = (int) $product_category_id;
        
        
        $this->product_category_model->changeStatus($product_category_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_categories/view/".$page_id);
    }
    
    /**
      * function to restor product_category from trash
      * @param $product_category_id integer
      */
     public function restore($product_category_id, $page_id = NULL){
        
        $product_category_id = (int) $product_category_id;
        
        
        $this->product_category_model->changeStatus($product_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_categories/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_category from trash
      * @param $product_category_id integer
      */
     public function draft($product_category_id, $page_id = NULL){
        
        $product_category_id = (int) $product_category_id;
        
        
        $this->product_category_model->changeStatus($product_category_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_categories/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_category from trash
      * @param $product_category_id integer
      */
     public function publish($product_category_id, $page_id = NULL){
        
        $product_category_id = (int) $product_category_id;
        
        
        $this->product_category_model->changeStatus($product_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_categories/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_category
      * @param $product_category_id integer
      */
     public function delete($product_category_id, $page_id = NULL){
        
        $product_category_id = (int) $product_category_id;
        //$this->product_category_model->changeStatus($product_category_id, "3");
        //Remove file....
						$product_categories = $this->product_category_model->get_product_category($product_category_id);
						$file_path = $product_categories[0]->product_category_image;
						$this->product_category_model->delete_file($file_path);
		$this->product_category_model->delete(array( 'product_category_id' => $product_category_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_categories/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_category
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Product Category');$this->data["view"] = ADMIN_DIR."product_categories/add_product_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_category_image")){
                       $_POST['product_category_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_category_id = $this->product_category_model->save_data();
          if($product_category_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_categories/edit/$product_category_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_categories/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_category
      */
     public function edit($product_category_id){
		 $product_category_id = (int) $product_category_id;
        $this->data["product_category"] = $this->product_category_model->get($product_category_id);
		  
        $this->data["title"] = $this->lang->line('Edit Product Category');$this->data["view"] = ADMIN_DIR."product_categories/edit_product_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_category_id){
		 
		 $product_category_id = (int) $product_category_id;
       
	   if($this->product_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_category_image")){
                         $_POST["product_category_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_category_id = $this->product_category_model->update_data($product_category_id);
          if($product_category_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_categories/edit/$product_category_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_categories/edit/$product_category_id");
            }
        }else{
			$this->edit($product_category_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_categories"] = $this->product_category_model->getBy($where, false, "product_category_id" );
				$j_array[]=array("id" => "", "value" => "product_category");
				foreach($data["product_categories"] as $product_category ){
					$j_array[]=array("id" => $product_category->product_category_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
