<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_additional_images extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_additional_image_model");
		$this->lang->load("product_additional_images", 'english');
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
		
        $where = "`product_additional_images`.`status` IN (0, 1) ORDER BY `product_additional_images`.`order`";
		$data = $this->product_additional_image_model->get_product_additional_image_list($where);
		 $this->data["product_additional_images"] = $data->product_additional_images;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Additional Images');
		$this->data["view"] = ADMIN_DIR."product_additional_images/product_additional_images";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_additional_image($product_additional_image_id){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        $this->data["product_additional_images"] = $this->product_additional_image_model->get_product_additional_image($product_additional_image_id);
        $this->data["title"] = $this->lang->line('Product Additional Image Details');
		$this->data["view"] = ADMIN_DIR."product_additional_images/view_product_additional_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_additional_images`.`status` IN (2) ORDER BY `product_additional_images`.`order`";
		$data = $this->product_additional_image_model->get_product_additional_image_list($where);
		 $this->data["product_additional_images"] = $data->product_additional_images;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Additional Images');
		$this->data["view"] = ADMIN_DIR."product_additional_images/trashed_product_additional_images";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        
        $this->product_additional_image_model->changeStatus($product_additional_image_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
    }
    
    /**
      * function to restor product_additional_image from trash
      * @param $product_additional_image_id integer
      */
     public function restore($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        
        $this->product_additional_image_model->changeStatus($product_additional_image_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_additional_images/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_additional_image from trash
      * @param $product_additional_image_id integer
      */
     public function draft($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        
        $this->product_additional_image_model->changeStatus($product_additional_image_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_additional_image from trash
      * @param $product_additional_image_id integer
      */
     public function publish($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        
        $this->product_additional_image_model->changeStatus($product_additional_image_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_additional_image
      * @param $product_additional_image_id integer
      */
     public function delete($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        //$this->product_additional_image_model->changeStatus($product_additional_image_id, "3");
        //Remove file....
						$product_additional_images = $this->product_additional_image_model->get_product_additional_image($product_additional_image_id);
						$file_path = $product_additional_images[0]->product_additional_image;
						$this->product_additional_image_model->delete_file($file_path);
		$this->product_additional_image_model->delete(array( 'product_additional_image_id' => $product_additional_image_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_additional_images/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_additional_image
      */
     public function add(){
		
    $this->data["products"] = $this->product_additional_image_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Product Additional Image');$this->data["view"] = ADMIN_DIR."product_additional_images/add_product_additional_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_additional_image_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_additional_image")){
                       $_POST['product_additional_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_additional_image_id = $this->product_additional_image_model->save_data();
          if($product_additional_image_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_additional_images/edit/$product_additional_image_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_additional_images/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_additional_image
      */
     public function edit($product_additional_image_id){
		 $product_additional_image_id = (int) $product_additional_image_id;
        $this->data["product_additional_image"] = $this->product_additional_image_model->get($product_additional_image_id);
		  
    $this->data["products"] = $this->product_additional_image_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Product Additional Image');$this->data["view"] = ADMIN_DIR."product_additional_images/edit_product_additional_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_additional_image_id){
		 
		 $product_additional_image_id = (int) $product_additional_image_id;
       
	   if($this->product_additional_image_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("product_additional_image")){
                         $_POST["product_additional_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $product_additional_image_id = $this->product_additional_image_model->update_data($product_additional_image_id);
          if($product_additional_image_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_additional_images/edit/$product_additional_image_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_additional_images/edit/$product_additional_image_id");
            }
        }else{
			$this->edit($product_additional_image_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $product_additional_image_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
		//get order number of this record
        $this_product_additional_image_where = "product_additional_image_id = $product_additional_image_id";
        $this_product_additional_image = $this->product_additional_image_model->getBy($this_product_additional_image_where, true);
        $this_product_additional_image_id = $product_additional_image_id;
        $this_product_additional_image_order = $this_product_additional_image->order;
        
        
        //get order number of previous record
        $previous_product_additional_image_where = "order <= $this_product_additional_image_order AND product_additional_image_id != $product_additional_image_id ORDER BY `order` DESC";
        $previous_product_additional_image = $this->product_additional_image_model->getBy($previous_product_additional_image_where, true);
        $previous_product_additional_image_id = $previous_product_additional_image->product_additional_image_id;
        $previous_product_additional_image_order = $previous_product_additional_image->order;
        
        //if this is the first element
        if(!$previous_product_additional_image_id){
            redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_product_additional_image_inputs = array(
            "order" => $previous_product_additional_image_order
        );
        $this->product_additional_image_model->save($this_product_additional_image_inputs, $this_product_additional_image_id);
        
        $previous_product_additional_image_inputs = array(
            "order" => $this_product_additional_image_order
        );
        $this->product_additional_image_model->save($previous_product_additional_image_inputs, $previous_product_additional_image_id);
        
        
        
        redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $product_additional_image_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($product_additional_image_id, $page_id = NULL){
        
        $product_additional_image_id = (int) $product_additional_image_id;
        
        
        
        //get order number of this record
         $this_product_additional_image_where = "product_additional_image_id = $product_additional_image_id";
        $this_product_additional_image = $this->product_additional_image_model->getBy($this_product_additional_image_where, true);
        $this_product_additional_image_id = $product_additional_image_id;
        $this_product_additional_image_order = $this_product_additional_image->order;
        
        
        //get order number of next record
		
        $next_product_additional_image_where = "order >= $this_product_additional_image_order and product_additional_image_id != $product_additional_image_id ORDER BY `order` ASC";
        $next_product_additional_image = $this->product_additional_image_model->getBy($next_product_additional_image_where, true);
        $next_product_additional_image_id = $next_product_additional_image->product_additional_image_id;
        $next_product_additional_image_order = $next_product_additional_image->order;
        
        //if this is the first element
        if(!$next_product_additional_image_id){
            redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_product_additional_image_inputs = array(
            "order" => $next_product_additional_image_order
        );
        $this->product_additional_image_model->save($this_product_additional_image_inputs, $this_product_additional_image_id);
        
        $next_product_additional_image_inputs = array(
            "order" => $this_product_additional_image_order
        );
        $this->product_additional_image_model->save($next_product_additional_image_inputs, $next_product_additional_image_id);
        
        
        
        redirect(ADMIN_DIR."product_additional_images/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_additional_images"] = $this->product_additional_image_model->getBy($where, false, "product_additional_image_id" );
				$j_array[]=array("id" => "", "value" => "product_additional_image");
				foreach($data["product_additional_images"] as $product_additional_image ){
					$j_array[]=array("id" => $product_additional_image->product_additional_image_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
